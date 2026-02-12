/**
 * Reports and Dashboard module.
 * Handles report generation, filtering, and data visualization.
 */

const apiUrl = "/api/reports";
let allData = [];
let myChart = null;

const formatRupiah = (angka) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(angka);
};

const isToday = (dateString) => {
    const date = new Date(dateString);
    const today = new Date();
    return (
        date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
    );
};

const isLast7Days = (dateString) => {
    const date = new Date(dateString);
    const today = new Date();
    date.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);

    const diffTime = Math.abs(today - date);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays <= 7 && date <= today;
};

const isThisMonth = (dateString) => {
    const date = new Date(dateString);
    const today = new Date();
    return (
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
    );
};

const isLastMonth = (dateString) => {
    const date = new Date(dateString);
    const today = new Date();
    let targetMonth = today.getMonth() - 1;
    let targetYear = today.getFullYear();
    if (targetMonth < 0) {
        targetMonth = 11;
        targetYear = targetYear - 1;
    }
    return date.getMonth() === targetMonth && date.getFullYear() === targetYear;
};

const isThisYear = (dateString) => {
    const date = new Date(dateString);
    const today = new Date();
    return date.getFullYear() === today.getFullYear();
};

// Load and initialize report data on page load
document.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await fetch(apiUrl);
        let data = await response.json();

        // Handle both array and object with .data property (Resource format)
        if (!Array.isArray(data)) {
            if (data.data && Array.isArray(data.data)) {
                allData = data.data;
            } else {
                allData = [];
            }
        } else {
            allData = data;
        }

        hitungKartuRekap(allData);
        renderChart(allData);
        renderTable(allData);

        // Export event listeners
        document
            .getElementById("btnExportExcel")
            ?.addEventListener("click", (e) => {
                e.preventDefault();
                exportLaporan("excel");
            });
        document
            .getElementById("btnExportPdf")
            ?.addEventListener("click", (e) => {
                e.preventDefault();
                exportLaporan("pdf");
            });
    } catch (error) {
        console.error(error);
        alert("Failed to load report data.");
    }
});

// Filter and search event listeners
document
    .getElementById("filterWaktu")
    ?.addEventListener("change", applyFilters);
document.getElementById("searchInput")?.addEventListener("input", applyFilters);

function applyFilters() {
    const timeFilter = document.getElementById("filterWaktu").value;
    const searchText = document
        .getElementById("searchInput")
        .value.toLowerCase();

    const filteredData = allData.filter((item) => {
        // Check date filter
        let dateMatch = true;
        const itemDate = item.date;
        if (timeFilter === "today") dateMatch = isToday(itemDate);
        else if (timeFilter === "last7") dateMatch = isLast7Days(itemDate);
        else if (timeFilter === "month") dateMatch = isThisMonth(itemDate);
        else if (timeFilter === "last_month") dateMatch = isLastMonth(itemDate);
        else if (timeFilter === "year") dateMatch = isThisYear(itemDate);

        // Check text search filter (customer name or product)
        const textMatch =
            (item.customer || "").toLowerCase().includes(searchText) ||
            (item.products || "").toLowerCase().includes(searchText);

        return dateMatch && textMatch;
    });

    renderTable(filteredData);
    renderChart(filteredData);
}

function hitungKartuRekap(data) {
    let omzetToday = 0;
    let profitToday = 0;
    let profitMonth = 0;

    data.forEach((item) => {
        if (isToday(item.date)) {
            omzetToday += Number(item.total_omzet) || 0;
            profitToday += Number(item.profit) || 0;
        }
        if (isThisMonth(item.date)) {
            profitMonth += Number(item.profit) || 0;
        }
    });

    document.getElementById("cardOmzetToday").innerText =
        formatRupiah(omzetToday);
    document.getElementById("cardProfitToday").innerText =
        formatRupiah(profitToday);
    document.getElementById("cardProfitMonth").innerText =
        formatRupiah(profitMonth);
}

function renderTable(data) {
    const tbody = document.getElementById("tabelLaporan");
    let html = "";
    let tOmzet = 0,
        tHPP = 0,
        tProfit = 0;

    if (!data || data.length === 0) {
        tbody.innerHTML =
            '<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data transaksi pada periode ini.</td></tr>';
        document.getElementById("tableTotalOmzet").innerText = "Rp 0";
        document.getElementById("tableTotalHPP").innerText = "Rp 0";
        document.getElementById("tableTotalProfit").innerText = "Rp 0";
        return;
    }

    data.forEach((order) => {
        const omzetVal = Number(order.total_omzet) || 0;
        const hppVal = Number(order.total_hpp) || 0;
        const profitVal = Number(order.profit) || 0;

        tOmzet += omzetVal;
        tHPP += hppVal;
        tProfit += profitVal;

        html += `
            <tr>
                <td>#${order.id}</td>
                <td>${order.date}</td>
                <td>${order.customer}</td>
                <td><small class="text-muted">${order.products}</small></td>
                <td class="text-end">${formatRupiah(omzetVal)}</td>
                <td class="text-end">${formatRupiah(hppVal)}</td>
                <td class="fw-bold text-success text-end">${formatRupiah(profitVal)}</td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
    document.getElementById("tableTotalOmzet").innerText = formatRupiah(tOmzet);
    document.getElementById("tableTotalHPP").innerText = formatRupiah(tHPP);
    document.getElementById("tableTotalProfit").innerText =
        formatRupiah(tProfit);
}

function renderChart(data) {
    const ctx = document.getElementById("myChart").getContext("2d");

    let dailyGroups = {};
    data.forEach((item) => {
        if (!item || !item.date) return;
        const d = new Date(item.date);
        if (isNaN(d)) return;

        const dateKey = d.toISOString().slice(0, 10); // YYYY-MM-DD
        const label = d.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "short",
            year: "numeric",
        });

        if (!dailyGroups[dateKey]) {
            dailyGroups[dateKey] = {
                omzet: 0,
                profit: 0,
                rawDate: d,
                label: label,
            };
        }

        dailyGroups[dateKey].omzet += Number(item.total_omzet) || 0;
        dailyGroups[dateKey].profit += Number(item.profit) || 0;
    });

    let sortedKeys = Object.keys(dailyGroups).sort(
        (a, b) => dailyGroups[a].rawDate - dailyGroups[b].rawDate,
    );

    const labels = sortedKeys.map((k) => dailyGroups[k].label);
    const dataOmzet = sortedKeys.map((key) => dailyGroups[key].omzet);
    const dataProfit = sortedKeys.map((key) => dailyGroups[key].profit);

    if (myChart) myChart.destroy();

    myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Omzet",
                    data: dataOmzet,
                    borderColor: "#b0bec5",
                    backgroundColor: "rgba(176, 190, 197, 0.1)",
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                },
                {
                    label: "Profit",
                    data: dataProfit,
                    borderColor: "#5d4037",
                    backgroundColor: "rgba(93, 64, 55, 0.05)",
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#5d4037",
                    pointBorderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "top",
                    align: "end",
                    labels: {
                        boxWidth: 10,
                        usePointStyle: true,
                        font: { size: 11 },
                    },
                },
                tooltip: {
                    mode: "index",
                    intersect: false,
                    backgroundColor: "rgba(255, 255, 255, 0.95)",
                    titleColor: "#333",
                    bodyColor: "#555",
                    borderColor: "#f0f0f0",
                    borderWidth: 1,
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || "";
                            if (label) {
                                label += ": ";
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat("id-ID", {
                                    style: "currency",
                                    currency: "IDR",
                                    minimumFractionDigits: 0,
                                }).format(context.parsed.y);
                            }
                            return label;
                        },
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "#f8f9fa",
                        drawBorder: false,
                    },
                    ticks: {
                        font: { size: 10 },
                        color: "#999",
                        callback: function (value) {
                            if (value >= 1000000)
                                return "Rp " + value / 1000000 + "jt";
                            if (value >= 1000)
                                return "Rp " + value / 1000 + "rb";
                            return value;
                        },
                    },
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 10 },
                        color: "#999",
                    },
                },
            },
            interaction: {
                mode: "nearest",
                axis: "x",
                intersect: false,
            },
        },
    });
}

function exportLaporan(format) {
    const timeFilter = document.getElementById("filterWaktu").value;
    const searchText = document.getElementById("searchInput").value;

    // Build query parameters with current filter settings
    const params = new URLSearchParams({
        format: format,
        period: timeFilter,
        search: searchText,
    });

    window.location.href = `/laporan/export?${params.toString()}`;
}
