const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const toggleSidebarMain = document.getElementById("sidebarToggleMain");
const contentWrapper = document.getElementById("contentWrapper");

const navDashboard = document.getElementById("navDashboard");
const navReport = document.getElementById("navReport");
const navStatistics = document.getElementById("navStatistics");
const navArticles = document.getElementById("navArticles");
const sectionDashboard = document.getElementById("sectionDashboard");
const sectionReport = document.getElementById("sectionReport");
const sectionStatistics = document.getElementById("sectionStatistics");
const sectionArticles = document.getElementById("sectionArticles");

let transactions = [];

const transactionForm = document.getElementById("transactionForm");
const transactionsTableBody = document.getElementById("transactionsTableBody");
const totalIncomeEl = document.getElementById("totalIncome");
const totalExpenseEl = document.getElementById("totalExpense");
const balanceEl = document.getElementById("balance");

const dashboardIncomeEl = document.getElementById("dashboardIncome");
const dashboardOutcomeEl = document.getElementById("dashboardOutcome");
const dashboardTransactionList = document.getElementById("dashboardTransactionList");

const statIncome = document.getElementById("statIncome");
const statExpense = document.getElementById("statExpense");
const statBalance = document.getElementById("statBalance");
const incomeOutcomeChartCanvas = document.getElementById("incomeOutcomeChartCanvas");
const timeRangeSelect = document.getElementById("timeRange");

let expenseChart, incomeChart, incomeOutcomeChart;

// Format number to Indonesian Rupiah currency string
function formatRupiah(value) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
}

// Sidebar toggle functions
function openSidebar() {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
    contentWrapper.classList.add("sidebar-open");
}

function closeSidebar() {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
    contentWrapper.classList.remove("sidebar-open");
}

function toggleSidebar() {
    if (sidebar.classList.contains("-translate-x-full")) {
        openSidebar();
    } else {
        closeSidebar();
    }
}

toggleSidebarMain.addEventListener("click", toggleSidebar);
overlay.addEventListener("click", closeSidebar);

// Navigation between pages
function setActiveNav(activeNav) {
    [navDashboard, navReport, navStatistics, navArticles].forEach((nav) => {
        nav.classList.remove("bg-[#1a2a1a]", "text-white");
    });
    activeNav.classList.add("bg-[#1a2a1a]", "text-white");
}

function navClickHandler(navButton, showSection) {
    navButton.addEventListener("click", () => {
        setActiveNav(navButton);
        sectionDashboard.classList.add("hidden");
        sectionReport.classList.add("hidden");
        sectionStatistics.classList.add("hidden");
        sectionArticles.classList.add("hidden");
        showSection.classList.remove("hidden");
        closeSidebar();
    });
}

navClickHandler(navDashboard, sectionDashboard);
navClickHandler(navReport, sectionReport);
navClickHandler(navStatistics, sectionStatistics);
navClickHandler(navArticles, sectionArticles);

// Initialize with Dashboard active
navDashboard.click();

// Add transaction handler
transactionForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const type = transactionForm.type.value;
    const category = transactionForm.category.value;
    const amount = parseFloat(transactionForm.amount.value);
    const date = transactionForm.date.value;

    if (!category || !date || isNaN(amount) || amount <= 0) {
        alert("Please fill all fields correctly.");
        return;
    }

    transactions.push({ type, category, amount, date });
    transactionForm.reset();
    updateReportTable();
    updateStatistics();
    updateDashboard();
});

// Update report table and totals
function updateReportTable() {
    transactionsTableBody.innerHTML = "";
    let totalIncome = 0;
    let totalExpense = 0;

    // Sort transactions by date descending
    const sorted = [...transactions].sort(
        (a, b) => new Date(b.date) - new Date(a.date)
    );

    for (const t of sorted) {
        const tr = document.createElement("tr");
        tr.classList.add("border-b", "border-gray-300");
        tr.innerHTML = `
          <td class="py-2 px-3">${t.date}</td>
          <td class="py-2 px-3 capitalize">${t.type}</td>
          <td class="py-2 px-3">${t.category}</td>
          <td class="py-2 px-3 ${t.type === "income" ? "text-green-600" : "text-red-600"} font-semibold">${formatRupiah(t.amount)}</td>
        `;
        transactionsTableBody.appendChild(tr);

        if (t.type === "income") totalIncome += t.amount;
        else totalExpense += t.amount;
    }

    totalIncomeEl.textContent = formatRupiah(totalIncome);
    totalExpenseEl.textContent = formatRupiah(totalExpense);
    balanceEl.textContent = formatRupiah(totalIncome - totalExpense);
}

// Update statistics charts and summary
function updateStatistics() {
    // Calculate totals
    let totalIncome = 0;
    let totalExpense = 0;
    const incomeByCategory = {};
    const expenseByCategory = {};

    for (const t of transactions) {
        if (t.type === "income") {
            totalIncome += t.amount;
            incomeByCategory[t.category] = (incomeByCategory[t.category] || 0) + t.amount;
        } else {
            totalExpense += t.amount;
            expenseByCategory[t.category] = (expenseByCategory[t.category] || 0) + t.amount;
        }
    }

    statIncome.textContent = formatRupiah(totalIncome);
    statExpense.textContent = formatRupiah(totalExpense);
    statBalance.textContent = formatRupiah(totalIncome - totalExpense);

    // Prepare data for charts
    const expenseLabels = Object.keys(expenseByCategory);
    const expenseData = Object.values(expenseByCategory);

    const incomeLabels = Object.keys(incomeByCategory);
    const incomeData = Object.values(incomeByCategory);

    // Clear previous charts if exist
    if (expenseChart) expenseChart.destroy();
    if (incomeChart) incomeChart.destroy();

    // Create expense category chart
    const ctxExpense = document.getElementById("expenseChartCanvas").getContext("2d");
    expenseChart = new Chart(ctxExpense, {
        type: "doughnut",
        data: {
            labels: expenseLabels,
            datasets: [{
                label: "Expenses",
                data: expenseData,
                backgroundColor: ["#f87171", "#fbbf24", "#34d399", "#60a5fa", "#a78bfa", "#f472b6"],
                borderColor: "#fff",
                borderWidth: 3,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "70%",
            plugins: {
                legend: { position: "bottom", labels: { padding: 20, boxWidth: 22, font: { size: 15, weight: "700" } } },
                title: { display: true, text: "Expenses by Category", font: { size: 20, weight: "800" }, padding: { bottom: 25 } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            return label + ': ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
                        }
                    }
                }
            },
            animation: { animateRotate: true, animateScale: true }
        }
    });

    // Create income category chart
    const ctxIncome = document.getElementById("incomeChartCanvas").getContext("2d");
    incomeChart = new Chart(ctxIncome, {
        type: "doughnut",
        data: {
            labels: incomeLabels,
            datasets: [{
                label: "Income",
                data: incomeData,
                backgroundColor: ["#34d399", "#60a5fa", "#a78bfa", "#fbbf24", "#f87171", "#f472b6"],
                borderColor: "#fff",
                borderWidth: 3,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "70%",
            plugins: {
                legend: { position: "bottom", labels: { padding: 20, boxWidth: 22, font: { size: 15, weight: "700" } } },
                title: { display: true, text: "Income by Category", font: { size: 20, weight: "800" }, padding: { bottom: 25 } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            return label + ': ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
                        }
                    }
                }
            },
            animation: { animateRotate: true, animateScale: true }
        }
    });

    updateIncomeOutcomeChart();
}

// Update income/outcome over time chart
function updateIncomeOutcomeChart() {
    const range = timeRangeSelect.value;
    const { labels, incomeData, expenseData } = prepareIncomeOutcomeData(range);

    if (incomeOutcomeChart) incomeOutcomeChart.destroy();

    incomeOutcomeChart = new Chart(incomeOutcomeChartCanvas.getContext("2d"), {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Income",
                    data: incomeData,
                    borderColor: "#34d399",
                    backgroundColor: "rgba(52, 211, 153, 0.3)",
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 3,
                },
                {
                    label: "Outcome",
                    data: expenseData,
                    borderColor: "#f87171",
                    backgroundColor: "rgba(248, 113, 113, 0.3)",
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'nearest', intersect: false },
            plugins: {
                legend: { position: "top", labels: { font: { size: 14, weight: "600" }, padding: 20 } },
                title: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: { display: true, text: range === "month" ? "Month (YYYY-MM)" : "Year (YYYY)", font: { size: 14, weight: "600" } },
                    ticks: { maxRotation: 45, minRotation: 45, maxTicksLimit: 12, font: { size: 12 } },
                    grid: { display: false },
                },
                y: {
                    title: { display: true, text: "Amount (Rp)", font: { size: 14, weight: "600" } },
                    ticks: {
                        font: { size: 12 },
                        callback: function(value) {
                            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
                        }
                    },
                    grid: { color: "#e0e0e0", borderDash: [5, 5] },
                    beginAtZero: true,
                }
            }
        }
    });
}

// Prepare data for income/outcome over time chart
function prepareIncomeOutcomeData(range) {
    const grouped = {};
    transactions.forEach(t => {
        const dateObj = new Date(t.date);
        let key;
        if (range === "month") {
            const month = (dateObj.getMonth() + 1).toString().padStart(2, "0");
            key = `${dateObj.getFullYear()}-${month}`;
        } else {
            key = `${dateObj.getFullYear()}`;
        }
        if (!grouped[key]) {
            grouped[key] = { income: 0, expense: 0 };
        }
        if (t.type === "income") {
            grouped[key].income += t.amount;
        } else {
            grouped[key].expense += t.amount;
        }
    });

    const keys = Object.keys(grouped).sort();
    const labels = keys;
    const incomeData = keys.map(k => grouped[k].income);
    const expenseData = keys.map(k => grouped[k].expense);

    return { labels, incomeData, expenseData };
}

// Initialize sidebar state on load
handleResize();
updateDashboard();