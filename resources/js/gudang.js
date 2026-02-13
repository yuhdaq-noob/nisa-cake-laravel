/**
 * Inventory Management.
 * Handles material stock tracking, history logs, and restock operations.
 */

import "./bootstrap";
import "./api.js";
import { getAuthHeaders, formatNumber } from "./utils.js";
import { closeModal } from "./ui.js";

const apiMaterials = "/api/materials";
const apiHistory = "/api/stocks/history";
const apiAddStock = "/api/stocks/add";
const apiMaterialPrice = "/api/materials";
const apiPriceHistory = "/api/materials/price-history";

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
        ? `<button type="button" class="btn-edit-price inline-flex items-center gap-1 text-xs font-semibold text-amber-800 hover:text-amber-900" data-material-id="${mat.id}" title="Ubah harga"><i class="bi bi-pencil-square"></i><span>Ubah</span></button>`
        : "";

    return `
        <span class="price-display-group">
            <span class="price-display">Rp ${formatNumber(displayPrice)}/${displayUnit}</span>
            ${editButton}
        </span>
    `;
}

// Load inventory data on page initialization
document.addEventListener("DOMContentLoaded", () => {
    if (!document.getElementById("tabelStok")) return;
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
                '<i class="bi bi-check-circle-fill text-emerald-600"></i>';
            let statusText = '<span class="text-slate-600">Optimal</span>';

            if (mat.current_stock < mat.min_stock_level) {
                statusIcon =
                    '<i class="bi bi-x-circle-fill text-rose-600"></i>';
                statusText =
                    '<span class="text-rose-700 font-semibold">Critical</span>';
            } else if (mat.current_stock < mat.min_stock_level * 2) {
                statusIcon =
                    '<i class="bi bi-exclamation-circle-fill text-amber-600"></i>';
                statusText = '<span class="text-slate-600">Low</span>';
            }

            htmlTabel += `
                <tr data-material-id="${mat.id}" class="hover:bg-slate-50">
                    <td class="font-semibold text-slate-900">${mat.name}</td>
                    <td class="col-price" data-material-id="${mat.id}">${buildPriceCellHtml(mat)}</td>
                    <td class="text-slate-700">${mat.current_stock}</td>
                    <td class="uppercase text-slate-500">${mat.unit}</td>
                    <td class="flex items-center gap-2 text-sm">${statusIcon} ${statusText}</td>
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
                '<li class="px-5 py-4 text-center text-slate-500">Tidak ada riwayat transaksi.</li>';
            return;
        }

        let html = "";
        logs.forEach((log) => {
            let textClass =
                log.type === "in" ? "text-emerald-600" : "text-rose-600";
            let sign = log.type === "in" ? "+" : "-";

            let date = new Date(log.created_at).toLocaleString("id-ID", {
                day: "numeric",
                month: "short",
                hour: "2-digit",
                minute: "2-digit",
            });

            html += `
                <li class="px-5 py-3 flex items-start justify-between gap-3">
                    <div>
                        <div class="font-semibold text-slate-900">${
                            log.material.name || log.material
                        }</div>
                        <p class="text-xs text-slate-500">${
                            log.description || "-"
                        }</p>
                    </div>
                    <div class="text-right text-sm">
                        <span class="font-bold ${textClass}">${sign}${log.amount}</span><br>
                        <span class="text-slate-500 text-xs">${date}</span>
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
                closeModal("modalRestock");
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
                <div class="flex items-center gap-2 flex-wrap">
                    <div class="flex items-center rounded-lg border border-slate-200 overflow-hidden">
                        <span class="px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-100">Rp</span>
                        <input type="number" class="price-input w-24 px-3 py-2 text-sm focus:outline-none" min="0" step="0.01" value="${editConfig.basePrice}">
                        <span class="px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-100">/${editConfig.editUnit}</span>
                    </div>
                    <button type="button" class="btn-save-price px-3 py-2 rounded-lg bg-emerald-600 text-white text-xs font-semibold" data-material-id="${materialId}" title="Simpan">
                        Simpan
                    </button>
                    <button type="button" class="btn-cancel-price px-3 py-2 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700" data-material-id="${materialId}" title="Batal">
                        Batal
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
                '<li class="px-5 py-4 text-center text-slate-500">Riwayat harga belum tersedia.</li>';
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
                '<li class="px-5 py-4 text-center text-slate-500">Belum ada perubahan harga.</li>';
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
                <li class="px-5 py-3 flex items-start justify-between gap-3">
                    <div>
                        <div class="font-semibold text-slate-900">${
                            log.material?.name || "-"
                        }</div>
                        <p class="text-xs text-slate-500">Rp ${formatNumber(
                            oldPrice,
                        )}/${unitBaku} -> Rp ${formatNumber(
                            newPrice,
                        )}/${unitBaku}</p>
                    </div>
                    <div class="text-right text-xs text-slate-500">${date}</div>
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
