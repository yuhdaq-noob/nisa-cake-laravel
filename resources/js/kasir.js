/**
 * Point of Sale (POS) module.
 * Handles product selection, shopping cart, and order processing.
 */

import "./bootstrap";
import "./api.js";
import { getAuthHeaders, formatRupiah, showError, hideError } from "./utils.js";

const apiProducts = "/api/products";
const apiOrder = "/api/buat-pesanan";
const apiCompleteOrder = "/api/orders";

let cart = [];
let productsDB = [];
let lastOrderId = null;

document.addEventListener("DOMContentLoaded", async () => {
    if (!document.getElementById("product_list")) return;
    try {
        const response = await fetch(apiProducts, {
            headers: {
                ...getAuthHeaders(),
            },
        });
        if (response.status === 401) {
            alert("Sesi login telah berakhir. Silakan login kembali.");
            window.location.href = "/login";
            return;
        }
        const rawData = await response.json();
        if (Array.isArray(rawData)) {
            productsDB = rawData;
        } else if (rawData.data && Array.isArray(rawData.data)) {
            productsDB = rawData.data;
        } else {
            productsDB = [];
        }

        const datalist = document.getElementById("product_list");
        datalist.innerHTML = "";

        if (productsDB.length === 0) {
            showError("error_product_input", "No products available.");
        }

        productsDB.forEach((p) => {
            const option = document.createElement("option");
            option.value = `${p.name} - ${formatRupiah(p.selling_price)}`;
            datalist.appendChild(option);
        });
    } catch (error) {
        console.error("Error:", error);
        showError(
            "error_product_input",
            "Failed to load products. Check your connection.",
        );
    }

    // Clear error messages on user input
    document
        .getElementById("customer_name")
        ?.addEventListener("input", () => hideError("error_customer_name"));
    document
        .getElementById("product_input")
        ?.addEventListener("input", () => hideError("error_product_input"));
    document
        .getElementById("quantity")
        ?.addEventListener("input", () => hideError("error_product_input"));
});

function tambahKeKeranjang() {
    hideError("error_product_input");

    const inputVal = document.getElementById("product_input").value;
    const qty = parseInt(document.getElementById("quantity").value);

    if (!inputVal || isNaN(qty) || qty < 1) {
        showError(
            "error_product_input",
            "Select a product and valid quantity.",
        );
        return;
    }

    // Find product by input string format
    const product = productsDB.find(
        (p) => `${p.name} - ${formatRupiah(p.selling_price)}` === inputVal,
    );

    if (!product) {
        showError(
            "error_product_input",
            "Product not found. Select from the available list.",
        );
        return;
    }

    const productId = product.id;
    const existingItem = cart.find((item) => item.product_id == productId);

    if (existingItem) {
        existingItem.quantity += qty;
    } else {
        cart.push({
            product_id: productId,
            name: product.name,
            price: product.selling_price,
            quantity: qty,
        });
    }
    renderCart();

    // Reset input for next product
    document.getElementById("product_input").value = "";
    document.getElementById("quantity").value = "1";
}

function renderCart() {
    const tbody = document.getElementById("tabelKeranjang");
    const totalDisplay = document.getElementById("totalDisplay");

    if (cart.length === 0) {
        tbody.innerHTML = `<tr>
                <td colspan="5" class="text-center py-6 text-slate-500">
                    <span class="block mb-1 font-semibold">Cart is empty</span>
                    <small class="text-xs text-slate-400">Select products to begin.</small>
                </td>
            </tr>`;
        totalDisplay.innerText = "Rp 0";
        return;
    }

    let html = "";
    let grandTotal = 0;

    cart.forEach((item, index) => {
        const priceNum = Number(item.price) || 0;
        const qtyNum = Number(item.quantity) || 0;
        const subtotal = priceNum * qtyNum;
        grandTotal += subtotal;

        html += `
                <tr class="hover:bg-slate-50">
                    <td class="font-semibold text-slate-900">${item.name}</td>
                    <td class="text-right text-slate-500">${formatRupiah(priceNum)}</td>
                    <td class="text-center">${item.quantity}</td>
                    <td class="text-right font-semibold text-slate-900">${formatRupiah(subtotal)}</td>
                    <td class="text-center"><button class="text-rose-600 hover:text-rose-700" onclick="hapusItem(${index})"><i class="bi bi-trash"></i></button></td>
                </tr>
        `;
    });

    tbody.innerHTML = html;
    totalDisplay.innerText = formatRupiah(grandTotal);
}

function hapusItem(index) {
    cart.splice(index, 1);
    renderCart();
}

async function prosesTransaksi() {
    hideError("error_customer_name");
    hideError("error_checkout");

    const customerName = document.getElementById("customer_name").value;
    if (!customerName) {
        showError("error_customer_name", "Customer name is required.");
        return;
    }
    if (cart.length === 0) {
        showError("error_checkout", "Cart is empty. Add products first.");
        return;
    }

    const payload = { customer_name: customerName, items: cart };

    try {
        const response = await fetch(apiOrder, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                ...getAuthHeaders(),
            },
            body: JSON.stringify(payload),
        });
        if (response.status === 401) {
            showError(
                "error_checkout",
                "Sesi login telah berakhir. Silakan login kembali.",
            );
            window.location.href = "/login";
            return;
        }
        const result = await response.json();

        if (response.ok) {
            const profitValue =
                result?.data?.profit ??
                result?.profit ??
                result?.data?.total_profit;
            const createdOrderId = result?.data?.id ?? result?.id ?? null;

            if (createdOrderId) {
                lastOrderId = createdOrderId;
                showCompleteBox(createdOrderId);
            }

            alert(
                "Order processed successfully.\nEstimated Profit: " +
                    formatRupiah(Number(profitValue) || 0),
            );
            location.reload();
        } else {
            showError(
                "error_checkout",
                "Failed: " + (result.message || "An error occurred."),
            );
        }
    } catch (error) {
        showError(
            "error_checkout",
            "System error occurred during transaction. Please check the console.",
        );
        console.error(error);
    }
}

function showCompleteBox(orderId) {
    const box = document.getElementById("orderCompleteBox");
    const label = document.getElementById("lastOrderId");
    if (label) label.innerText = `#${orderId}`;
    if (box) box.classList.remove("hidden");
}

async function completeLastOrder() {
    if (!lastOrderId) return;

    try {
        const response = await fetch(
            `${apiCompleteOrder}/${lastOrderId}/complete`,
            {
                method: "PATCH",
                headers: {
                    ...getAuthHeaders(),
                },
            },
        );
        if (response.status === 401) {
            alert("Sesi login telah berakhir. Silakan login kembali.");
            window.location.href = "/login";
            return;
        }
        if (response.ok) {
            alert(`Pesanan #${lastOrderId} berhasil ditandai selesai.`);
            lastOrderId = null;
            const box = document.getElementById("orderCompleteBox");
            if (box) box.classList.add("hidden");
        } else {
            const result = await response.json().catch(() => ({}));
            alert(result.message || "Gagal menandai pesanan selesai.");
        }
    } catch (error) {
        console.error(error);
        alert("Terjadi kesalahan saat memperbarui status pesanan.");
    }
}

const completeButton = document.getElementById("btnCompleteOrder");
if (completeButton) {
    completeButton.addEventListener("click", completeLastOrder);
}

// Expose functions to global scope so inline onclick in Blade works when bundled by Vite
window.tambahKeKeranjang = tambahKeKeranjang;
window.hapusItem = hapusItem;
window.prosesTransaksi = prosesTransaksi;
