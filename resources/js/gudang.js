/**
 * Inventory Management.
 * Handles material stock tracking, history logs, and restock operations.
 */

import "./bootstrap";
import "./api.js";

const apiMaterials = "/api/materials";
const apiHistory = "/api/stocks/history";
const apiAddStock = "/api/stocks/add";
const apiMaterialPrice = "/api/materials";
const apiPriceHistory = "/api/materials/price-history";

const getAuthHeaders = () =>
    typeof window !== "undefined" && window.getAuthHeaders
        ? window.getAuthHeaders()
        : {};

const priceFormatter = new Intl.NumberFormat("id-ID");
const materialMap = new Map();

const BASE_UNIT_CONFIG = {
    gram: { unit: "kg", factor: 1000 },
    g: { unit: "kg", factor: 1000 },
    ml: { unit: "liter", factor: 1000 },
};

function getBaseUnitConfig(unitValue) {
    const key = (unitValue || "").trim().toLowerCase();
    return BASE_UNIT_CONFIG[key] || null;
}

function resolveDisplayPrice(mat) {
    const unitValue = (mat.unit || "").trim();
    const baseUnitValue = (mat.unit_baku || "").trim();
    const hasBasePrice =
        mat.price_per_unit_baku !== null &&
        mat.price_per_unit_baku !== undefined;
    const baseUnitConfig = getBaseUnitConfig(unitValue);
    const shouldDeriveBase =
        !hasBasePrice ||
        baseUnitValue === "" ||
        baseUnitValue.toLowerCase() === unitValue.toLowerCase();

    let displayUnit = baseUnitValue || unitValue;
    let displayPrice = hasBasePrice
        ? mat.price_per_unit_baku
        : mat.price_per_unit;

    if (shouldDeriveBase && baseUnitConfig) {
        displayUnit = baseUnitConfig.unit;
        displayPrice = (mat.price_per_unit || 0) * baseUnitConfig.factor;
    }

    return { displayUnit, displayPrice };
}

function getEditConfig(mat) {
    const unitValue = (mat.unit || "").trim();
    if (!unitValue) {
        return { isEditable: false };
    }

    const baseUnitConfig = getBaseUnitConfig(unitValue);
    const baseUnitValue = (mat.unit_baku || "").trim();
    let editUnit = baseUnitValue || unitValue;
    let basePrice = Number(mat.price_per_unit_baku ?? 0);

    if (baseUnitConfig) {
        editUnit = baseUnitConfig.unit;
        if (
            !mat.price_per_unit_baku &&
            mat.price_per_unit !== null &&
            mat.price_per_unit !== undefined
        ) {
            basePrice = Number(mat.price_per_unit) * baseUnitConfig.factor;
        }
    } else if (
        mat.price_per_unit_baku === null ||
        mat.price_per_unit_baku === undefined
    ) {
        basePrice = Number(mat.price_per_unit ?? 0);
    }

    return {
        isEditable: true,
        basePrice,
        editUnit,
    };
}

function buildPriceCellHtml(mat) {
    const { displayUnit, displayPrice } = resolveDisplayPrice(mat);
    const editConfig = getEditConfig(mat);
    const editButton = editConfig.isEditable
        ? `<button type="button" class="btn btn-sm btn-link text-primary text-decoration-none p-0 btn-edit-price" data-material-id="${mat.id}" title="Ubah harga"><i class="bi bi-pencil-square"></i></button>`
        : "";

    return `
        <span class="price-display-group">
            <span class="price-display">Rp ${priceFormatter.format(displayPrice)}/${displayUnit}</span>
            ${editButton}
        </span>
    `;
}

// Load inventory data on page initialization
document.addEventListener("DOMContentLoaded", () => {
    loadMaterials();
    loadHistory();
    loadPriceHistory();
    attachPriceEditHandler();
});

/**
 * Load material inventory table and restock modal dropdown.
 */
async function loadMaterials() {
    try {
        const response = await fetch(apiMaterials, {
            headers: {
                ...getAuthHeaders(),
            },
        });
        if (response.status === 401) {
            alert("Sesi login telah berakhir. Silakan login kembali.");
            window.location.href = "/login";
            return;
        }
        let materials = await response.json();

        // Handle both array and object with .data property (Resource format)
        if (!Array.isArray(materials)) {
            if (materials.data && Array.isArray(materials.data)) {
                materials = materials.data;
            } else {
                materials = [];
            }
        }

        let htmlTabel = "";
        let htmlOption =
            '<option value="" disabled selected>-- Select Material --</option>';

        materialMap.clear();

        materials.forEach((mat) => {
            materialMap.set(String(mat.id), mat);

            // Determine status indicator
            let statusIcon =
                '<i class="bi bi-check-circle-fill text-success opacity-75"></i>';
            let statusText = '<span class="text-muted ms-1">Optimal</span>';

            if (mat.current_stock < mat.min_stock_level) {
                statusIcon = '<i class="bi bi-x-circle-fill text-danger"></i>';
                statusText =
                    '<span class="text-danger fw-medium ms-1">Critical</span>';
            } else if (mat.current_stock < mat.min_stock_level * 2) {
                statusIcon =
                    '<i class="bi bi-exclamation-circle-fill text-warning"></i>';
                statusText = '<span class="text-muted ms-1">Low</span>';
            }

            htmlTabel += `
                <tr data-material-id="${mat.id}">
                    <td><span class="fw-medium text-dark">${mat.name}</span></td>
                    <td class="col-price" data-material-id="${mat.id}">${buildPriceCellHtml(mat)}</td>
                    <td>${mat.current_stock}</td>
                    <td>${mat.unit}</td>
                    <td class="d-flex align-items-center">${statusIcon} ${statusText}</td>
                </tr>
            `;

            htmlOption += `<option value="${mat.id}">${mat.name} (${mat.unit})</option>`;
        });

        document.getElementById("tabelStok").innerHTML = htmlTabel;
        document.getElementById("selectBahan").innerHTML = htmlOption;
    } catch (error) {
        console.error(error);
    }
}

/**
 * Load stock transaction history log.
 */
async function loadHistory() {
    try {
        const response = await fetch(apiHistory, {
            headers: {
                ...getAuthHeaders(),
            },
        });
        if (response.status === 401) {
            alert("Sesi login telah berakhir. Silakan login kembali.");
            window.location.href = "/login";
            return;
        }
        let logs = await response.json();

        // Handle both array and object with .data property (Resource format)
        if (!Array.isArray(logs)) {
            if (logs.data && Array.isArray(logs.data)) {
                logs = logs.data;
            } else {
                logs = [];
            }
        }

        const list = document.getElementById("listLog");

        if (logs.length === 0) {
            list.innerHTML =
                '<li class="list-group-item text-center text-muted">No transaction history.</li>';
            return;
        }

        let html = "";
        logs.forEach((log) => {
            let textClass = log.type === "in" ? "text-success" : "text-danger";
            let sign = log.type === "in" ? "+" : "-";

            let date = new Date(log.created_at).toLocaleString("id-ID", {
                day: "numeric",
                month: "short",
                hour: "2-digit",
                minute: "2-digit",
            });

            html += `
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">${log.material.name || log.material}</div>
                        <small class="text-muted">${log.description || "-"}</small>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold ${textClass}">${sign}${log.amount}</span> <br>
                        <span style="font-size: 0.75rem" class="text-muted">${date}</span>
                    </div>
                </li>
            `;
        });
        list.innerHTML = html;
    } catch (error) {
        console.error(error);
    }
}

/**
 * Handle restock form submission.
 */
const formRestock = document.getElementById("formRestock");
if (formRestock) {
    formRestock.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = {
            material_id: document.getElementById("selectBahan").value,
            amount: document.getElementById("inputJumlah").value,
            description:
                document.getElementById("inputKet").value || "Manual Restock",
        };

        try {
            const response = await fetch(apiAddStock, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    ...getAuthHeaders(),
                },
                body: JSON.stringify(data),
            });
            if (response.status === 401) {
                alert("Sesi login telah berakhir. Silakan login kembali.");
                window.location.href = "/login";
                return;
            }

            const result = await response.json();

            if (response.ok) {
                alert("Stock added successfully!");
                formRestock.reset();
                const modalEl = document.getElementById("modalRestock");
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();

                loadMaterials();
                loadHistory();
            } else {
                alert(
                    "Failed to add stock: " +
                        (result.message || JSON.stringify(result)),
                );
            }
        } catch (error) {
            console.error(error);
            alert(
                "System error occurred. Please check the console for details.",
            );
        }
    });
}

function attachPriceEditHandler() {
    const tableBody = document.getElementById("tabelStok");
    if (!tableBody || window.priceEditHandlerAttached) {
        return;
    }

    window.priceEditHandlerAttached = true;

    tableBody.addEventListener("click", async (event) => {
        const editButton = event.target.closest(".btn-edit-price");
        const saveButton = event.target.closest(".btn-save-price");
        const cancelButton = event.target.closest(".btn-cancel-price");

        if (editButton) {
            const materialId = editButton.getAttribute("data-material-id");
            const cell = editButton.closest(".col-price");
            const material = materialMap.get(String(materialId));
            const editConfig = material ? getEditConfig(material) : null;

            if (!cell || !material || !editConfig || !editConfig.isEditable) {
                return;
            }

            cell.innerHTML = `
                <div class="d-flex align-items-center gap-2 price-edit-row">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control price-input" min="0" step="0.01" value="${editConfig.basePrice}">
                        <span class="input-group-text">/${editConfig.editUnit}</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-success btn-save-price" data-material-id="${materialId}" title="Simpan">
                        <i class="bi bi-check-lg"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-cancel-price" data-material-id="${materialId}" title="Batal">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            `;

            return;
        }

        if (cancelButton) {
            const materialId = cancelButton.getAttribute("data-material-id");
            const cell = cancelButton.closest(".col-price");
            const material = materialMap.get(String(materialId));

            if (cell && material) {
                cell.innerHTML = buildPriceCellHtml(material);
            }

            return;
        }

        if (saveButton) {
            const materialId = saveButton.getAttribute("data-material-id");
            const cell = saveButton.closest(".col-price");
            const input = cell ? cell.querySelector(".price-input") : null;

            if (!cell || !input) {
                return;
            }

            const rawValue = input.value.trim();
            const pricePerBaku = Number(rawValue);

            if (!rawValue || Number.isNaN(pricePerBaku) || pricePerBaku <= 0) {
                alert("Harga harus berupa angka dan lebih dari 0.");
                return;
            }

            input.disabled = true;
            saveButton.disabled = true;

            try {
                const response = await fetch(
                    `${apiMaterialPrice}/${materialId}/price`,
                    {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/json",
                            ...getAuthHeaders(),
                        },
                        body: JSON.stringify({
                            price_per_unit_baku: pricePerBaku,
                        }),
                    },
                );
                if (response.status === 401) {
                    alert("Sesi login telah berakhir. Silakan login kembali.");
                    window.location.href = "/login";
                    return;
                }

                const result = await response.json();

                if (!response.ok) {
                    const message =
                        result.message || "Gagal memperbarui harga.";
                    alert(message);
                    const material = materialMap.get(String(materialId));
                    if (material) {
                        cell.innerHTML = buildPriceCellHtml(material);
                    }
                    return;
                }

                const updatedMaterial = result.data || result;
                materialMap.set(String(materialId), updatedMaterial);
                cell.innerHTML = buildPriceCellHtml(updatedMaterial);
                loadPriceHistory();
            } catch (error) {
                console.error(error);
                alert("Terjadi kesalahan saat memperbarui harga.");
                const material = materialMap.get(String(materialId));
                if (material) {
                    cell.innerHTML = buildPriceCellHtml(material);
                }
            }
        }
    });
}

async function loadPriceHistory() {
    const list = document.getElementById("listPriceLog");
    if (!list) {
        return;
    }

    try {
        const response = await fetch(apiPriceHistory, {
            headers: {
                ...getAuthHeaders(),
            },
        });
        if (response.status === 401) {
            alert("Sesi login telah berakhir. Silakan login kembali.");
            window.location.href = "/login";
            return;
        }
        if (!response.ok) {
            list.innerHTML =
                '<li class="list-group-item text-center text-muted">Riwayat harga belum tersedia.</li>';
            return;
        }

        let logs = await response.json();

        if (!Array.isArray(logs)) {
            if (logs.data && Array.isArray(logs.data)) {
                logs = logs.data;
            } else {
                logs = [];
            }
        }

        if (logs.length === 0) {
            list.innerHTML =
                '<li class="list-group-item text-center text-muted">Belum ada perubahan harga.</li>';
            return;
        }

        let html = "";
        logs.forEach((log) => {
            const unitBaku = log.unit_baku || "";
            const oldPrice = log.old_price_per_unit_baku ?? 0;
            const newPrice = log.new_price_per_unit_baku ?? 0;
            const date = new Date(log.created_at).toLocaleString("id-ID", {
                day: "numeric",
                month: "short",
                hour: "2-digit",
                minute: "2-digit",
            });

            html += `
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">${log.material?.name || "-"}</div>
                        <small class="text-muted">Rp ${priceFormatter.format(oldPrice)}/${unitBaku} → Rp ${priceFormatter.format(newPrice)}/${unitBaku}</small>
                    </div>
                    <div class="text-end">
                        <span style="font-size: 0.75rem" class="text-muted">${date}</span>
                    </div>
                </li>
            `;
        });

        list.innerHTML = html;
    } catch (error) {
        console.error(error);
        list.innerHTML =
            '<li class="list-group-item text-center text-danger">Gagal memuat riwayat harga.</li>';
    }
}
