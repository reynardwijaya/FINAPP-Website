<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
  <title>
   Financial Planner - UMKM Helm &amp; Cuci Helm
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: "Inter", sans-serif;
    }
    #sidebar {
      transition: transform 0.3s ease;
      width: 240px;
      flex-shrink: 0;
      border-top-right-radius: 1rem;
      border-bottom-right-radius: 1rem;
    }
    #contentWrapper {
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: 100%;
      margin-left: 0;
      max-width: 100vw;
      box-sizing: border-box;
    }
    #contentWrapper.sidebar-open {
      margin-left: 240px;
      width: calc(100% - 240px);
      max-width: calc(100vw - 240px);
    }
    /* Stronger visible borders for tables and containers */
    table, th, td {
      border: 2px solid #4a5a4a !important;
    }
    table {
      border-collapse: separate !important;
      border-spacing: 0 !important;
      border-radius: 0.75rem;
      overflow: hidden;
    }
    thead tr {
      background-color: #d1e7dd !important;
      border-bottom: 3px solid #4a5a4a !important;
    }
    tbody tr {
      border-bottom: 2px solid #4a5a4a !important;
    }
    tbody tr:last-child {
      border-bottom: none !important;
    }
    /* Cards and sections with distinct borders and shadows */
    section > div.bg-white {
      border: 2px solid #4a5a4a;
      box-shadow: 0 8px 20px rgba(74, 90, 74, 0.25);
      border-radius: 1rem;
    }
    /* Doughnut chart container border */
    #sectionStatistics div.bg-gradient-to-br {
      border: 2px solid #4a5a4a;
      box-shadow: 0 8px 20px rgba(74, 90, 74, 0.25);
      border-radius: 1rem;
    }
    /* Dashboard cards border */
    #sectionDashboard > div.grid > div {
      border: 2px solid rgba(255 255 255 / 0.6);
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }
    /* Recent transactions container border */
    #sectionDashboard > div.bg-white {
      border: 2px solid #4a5a4a;
      box-shadow: 0 8px 20px rgba(74, 90, 74, 0.25);
      border-radius: 1rem;
    }
  </style>
 </head>
 <body class="min-h-screen bg-gradient-to-tr from-[#4a6a5a] via-[#5a7a6a] to-[#6a8a7a] flex">
  <!-- Sidebar -->
  <aside class="fixed top-0 left-0 h-full bg-[#e6eee7] p-8 md:pt-12 md:pb-12 md:px-8 flex flex-col select-none transform -translate-x-full z-50" id="sidebar">
   <h1 class="text-[#1a2a1a] font-semibold text-lg mb-8 select-none">
    UMKM Helm &amp; Cuci Helm
   </h1>
   <nav class="flex flex-col gap-4 text-[#6b7a6b] text-sm font-medium">
    <button class="flex items-center gap-3 bg-[#1a2a1a] text-white rounded-lg py-2 px-6 w-full cursor-pointer" id="navDashboard">
     <i class="fas fa-th-large text-xs">
     </i>
     Dashboard
    </button>
    <button class="flex items-center gap-3 hover:text-[#a0b0a0] rounded-lg py-2 px-6 w-full cursor-pointer" id="navReport">
     <i class="fas fa-file-alt text-xs">
     </i>
     Report
    </button>
    <button class="flex items-center gap-3 hover:text-[#a0b0a0] rounded-lg py-2 px-6 w-full cursor-pointer" id="navStatistics">
     <i class="fas fa-chart-bar text-xs">
     </i>
     Statistics
    </button>
    <button class="flex items-center gap-3 hover:text-[#a0b0a0] rounded-lg py-2 px-6 w-full cursor-pointer" id="navArticles">
     <i class="fas fa-newspaper text-xs">
     </i>
     Articles
    </button>
   </nav>
   <div class="mt-auto bg-[#1a2a1a] rounded-none p-6 text-white flex flex-col items-center text-center" style="border-bottom-right-radius: 1rem;">
    <div class="text-sm font-semibold mb-1 flex items-center justify-center gap-1">
     Get Premium
     <i class="fas fa-star text-yellow-400">
     </i>
    </div>
    <div class="text-[10px] mb-3 leading-[1.1]">
     Unlimited transfer and
     <br/>
     statistics memory
    </div>
    <button class="bg-[#f9fdf8] text-[#1a2a1a] text-[10px] font-semibold rounded-full py-1 px-6 w-[90px] hover:bg-[#d9e6d9] transition">
     Upgrade
    </button>
   </div>
  </aside>
  <!-- Overlay -->
  <div class="fixed inset-0 bg-black bg-opacity-30 hidden z-40 md:hidden" id="overlay">
  </div>
  <!-- Main content container -->
  <div class="flex-1 w-full min-h-screen bg-[#f9fdf8] rounded-none p-6 md:p-10 flex flex-col gap-6 max-w-full overflow-auto relative z-10 transition-filter duration-300 ease-in-out" id="contentWrapper">
   <!-- Single toggle button for all pages -->
   <button aria-label="Toggle sidebar" class="mb-4 bg-[#1a2a1a] text-white p-2 rounded-md w-10 h-10 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#a0b0a0]" id="sidebarToggleMain" title="Toggle Sidebar">
    <i class="fas fa-bars">
    </i>
   </button>
   <!-- Dashboard Section -->
   <section class="block max-w-6xl mx-auto w-full" id="sectionDashboard">
    <h2 class="text-[#1a2a1a] font-semibold text-xl mb-6 select-none text-center">
     Dashboard Overview
    </h2>
    <!-- Accumulation Income & Outcome -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
     <div class="bg-gradient-to-br from-[#0a2a1a] via-[#0f3a2a] to-[#1a4a3a] rounded-[20px] p-6 text-white select-none flex flex-col justify-center items-center shadow-lg shadow-green-900/50 border-2 border-green-700">
      <div class="text-xs font-semibold mb-2 tracking-wide uppercase">
       Total Income
      </div>
      <div class="text-4xl font-extrabold leading-[1.1]" id="dashboardIncome">
       Rp0
      </div>
      <div class="text-[10px] mt-3 text-[#a0b0a0] flex items-center gap-1">
       <i class="fas fa-arrow-down text-green-400 animate-bounce">
       </i>
       Money coming in
      </div>
     </div>
     <div class="bg-gradient-to-br from-[#4a1a1a] via-[#6a1a1a] to-[#8a1a1a] rounded-[20px] p-6 text-white select-none flex flex-col justify-center items-center shadow-lg shadow-red-900/50 border-2 border-red-700">
      <div class="text-xs font-semibold mb-2 tracking-wide uppercase">
       Total Outcome
      </div>
      <div class="text-4xl font-extrabold leading-[1.1]" id="dashboardOutcome">
       Rp0
      </div>
      <div class="text-[10px] mt-3 text-[#a0a0a0] flex items-center gap-1">
       <i class="fas fa-arrow-up text-red-400 animate-pulse">
       </i>
       Money going out
      </div>
     </div>
    </div>
    <!-- Recent Transactions List -->
    <div class="bg-white rounded-lg p-6 shadow-md max-w-full max-h-[400px] overflow-y-auto border-2 border-[#4a5a4a]">
     <h3 class="text-lg font-semibold mb-4 text-[#1a2a1a] border-b-2 border-[#4a5a4a] pb-2">
      Recent Transactions
     </h3>
     <ul class="divide-y divide-gray-300" id="dashboardTransactionList">
     </ul>
    </div>
   </section>
   <!-- Report Section -->
   <section class="hidden max-w-4xl mx-auto w-full" id="sectionReport">
    <h2 class="text-[#1a2a1a] font-semibold text-xl mb-6 select-none text-center">
     Monthly Financial Report
    </h2>
    <form class="bg-gradient-to-r from-green-100 to-green-200 rounded-xl p-8 shadow-lg max-w-md mx-auto mb-8 border-2 border-green-600" id="transactionForm">
     <div class="mb-5">
      <label class="block text-sm font-semibold text-green-900 mb-2" for="type">
       Type
      </label>
      <select class="w-full border border-green-600 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-green-700 bg-green-50 text-green-900" id="type" required="">
       <option value="income">
        Income
       </option>
       <option value="expense">
        Expense
       </option>
      </select>
     </div>
     <div class="mb-5">
      <label class="block text-sm font-semibold text-green-900 mb-2" for="category">
       Category
      </label>
      <select class="w-full border border-green-600 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-green-700 bg-green-50 text-green-900" id="category" required="">
       <optgroup label="Income Categories">
        <option value="Sales">
         Sales
        </option>
        <option value="Other Income">
         Other Income
        </option>
       </optgroup>
       <optgroup label="Expense Categories">
        <option value="Raw Materials">
         Raw Materials
        </option>
        <option value="Labor">
         Labor
        </option>
        <option value="Rent">
         Rent
        </option>
        <option value="Utilities">
         Utilities
        </option>
        <option value="Marketing">
         Marketing
        </option>
        <option value="Other Expenses">
         Other Expenses
        </option>
       </optgroup>
      </select>
     </div>
     <div class="mb-5">
      <label class="block text-sm font-semibold text-green-900 mb-2" for="amount">
       Amount (Rupiah)
      </label>
      <input class="w-full border border-green-600 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-green-700 bg-green-50 text-green-900" id="amount" min="0" required="" step="any" type="number"/>
     </div>
     <div class="mb-5">
      <label class="block text-sm font-semibold text-green-900 mb-2" for="date">
       Date
      </label>
      <input class="w-full border border-green-600 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-green-700 bg-green-50 text-green-900" id="date" required="" type="date"/>
     </div>
     <div class="mb-5">
      <label class="block text-sm font-semibold text-green-900 mb-2" for="description">
       Description (Optional)
      </label>
      <input class="w-full border border-green-600 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-green-700 bg-green-50 text-green-900" id="description" type="text"/>
     </div>
     <button class="w-full bg-green-700 text-white font-semibold py-2 rounded-lg hover:bg-green-800 transition duration-300" type="submit">
      Add Transaction
     </button>
    </form>
    <div class="bg-white rounded-lg p-6 shadow-md max-w-full max-h-[400px] overflow-y-auto border-2 border-[#4a5a4a]">
     <h3 class="text-lg font-semibold mb-4 text-[#1a2a1a] border-b-2 border-[#4a5a4a] pb-2">
      Transaction History
     </h3>
     <table class="min-w-full bg-white rounded-lg overflow-hidden">
      <thead>
       <tr>
        <th class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-[#1a2a1a]">
         Date
        </th>
        <th class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-[#1a2a1a]">
         Type
        </th>
        <th class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-[#1a2a1a]">
         Category
        </th>
        <th class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-[#1a2a1a]">
         Amount
        </th>
        <th class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-[#1a2a1a]">
         Description
        </th>
        <th class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-[#1a2a1a]">
         Actions
        </th>
       </tr>
      </thead>
      <tbody id="transactionTableBody">
      </tbody>
     </table>
    </div>
   </section>
   <!-- Statistics Section -->
   <section class="hidden max-w-4xl mx-auto w-full" id="sectionStatistics">
    <h2 class="text-[#1a2a1a] font-semibold text-xl mb-6 select-none text-center">
     Financial Statistics
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
     <div class="bg-white rounded-lg p-6 shadow-md text-[#1a2a1a]">
      <h3 class="text-lg font-semibold mb-4 border-b-2 border-[#4a5a4a] pb-2">
       Category Distribution
      </h3>
      <canvas id="categoryChart"></canvas>
     </div>
     <div class="bg-white rounded-lg p-6 shadow-md text-[#1a2a1a]">
      <h3 class="text-lg font-semibold mb-4 border-b-2 border-[#4a5a4a] pb-2">
       Monthly Trends
      </h3>
      <canvas id="monthlyChart"></canvas>
     </div>
     <div class="bg-gradient-to-br from-[#0a2a1a] via-[#0f3a2a] to-[#1a4a3a] rounded-[20px] p-6 text-white select-none flex flex-col justify-center items-center shadow-lg shadow-green-900/50 border-2 border-green-700">
      <div class="text-xs font-semibold mb-2 tracking-wide uppercase">
       Total Savings
      </div>
      <div class="text-4xl font-extrabold leading-[1.1]" id="totalSavings">
       Rp0
      </div>
      <div class="text-[10px] mt-3 text-[#a0b0a0] flex items-center gap-1">
       <i class="fas fa-piggy-bank text-green-400">
       </i>
       Your current savings
      </div>
     </div>
     <div class="bg-gradient-to-br from-[#4a1a1a] via-[#6a1a1a] to-[#8a1a1a] rounded-[20px] p-6 text-white select-none flex flex-col justify-center items-center shadow-lg shadow-red-900/50 border-2 border-red-700">
      <div class="text-xs font-semibold mb-2 tracking-wide uppercase">
       Burn Rate
      </div>
      <div class="text-4xl font-extrabold leading-[1.1]" id="burnRate">
       Rp0/month
      </div>
      <div class="text-[10px] mt-3 text-[#a0a0a0] flex items-center gap-1">
       <i class="fas fa-fire text-red-400">
       </i>
       Monthly spending rate
      </div>
     </div>
    </div>
   </section>
   <!-- Articles Section -->
   <section class="hidden max-w-4xl mx-auto w-full" id="sectionArticles">
    <h2 class="text-[#1a2a1a] font-semibold text-xl mb-6 select-none text-center">
     Financial Articles
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="articlesList">
     <!-- Articles will be loaded here by JavaScript -->
    </div>
   </section>
   <!-- Profile Section -->
   <section class="hidden max-w-4xl mx-auto w-full" id="sectionProfile">
    <h2 class="text-[#1a2a1a] font-semibold text-xl mb-6 select-none text-center">
     Profile Settings
    </h2>
    <div class="bg-white rounded-lg p-6 shadow-md border-2 border-[#4a5a4a]">
     <h3 class="text-lg font-semibold mb-4 text-[#1a2a1a] border-b-2 border-[#4a5a4a] pb-2">
      User Information
     </h3>
     <form>
      <div class="mb-4">
       <label class="block text-sm font-medium text-[#1a2a1a] mb-2" for="username">
        Username
       </label>
       <input class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#6b7a6b] bg-gray-50 text-[#1a2a1a]" id="username" type="text" value="User123"/>
      </div>
      <div class="mb-4">
       <label class="block text-sm font-medium text-[#1a2a1a] mb-2" for="email">
        Email
       </label>
       <input class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#6b7a6b] bg-gray-50 text-[#1a2a1a]" id="email" type="email" value="user@example.com"/>
      </div>
      <div class="mb-4">
       <label class="block text-sm font-medium text-[#1a2a1a] mb-2" for="businessName">
        Business Name
       </label>
       <input class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#6b7a6b] bg-gray-50 text-[#1a2a1a]" id="businessName" type="text" value="UMKM Helm Bersih"/>
      </div>
      <button class="bg-[#1a2a1a] text-white font-semibold py-2 px-4 rounded-lg hover:bg-[#2a3a2a] transition duration-300" type="submit">
       Save Changes
      </button>
     </form>
    </div>
    <div class="bg-white rounded-lg p-6 shadow-md mt-6 border-2 border-[#4a5a4a]">
     <h3 class="text-lg font-semibold mb-4 text-[#1a2a1a] border-b-2 border-[#4a5a4a] pb-2">
      Password Settings
     </h3>
     <form>
      <div class="mb-4">
       <label class="block text-sm font-medium text-[#1a2a1a] mb-2" for="currentPassword">
        Current Password
       </label>
       <input class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#6b7a6b] bg-gray-50 text-[#1a2a1a]" id="currentPassword" type="password"/>
      </div>
      <div class="mb-4">
       <label class="block text-sm font-medium text-[#1a2a1a] mb-2" for="newPassword">
        New Password
       </label>
       <input class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#6b7a6b] bg-gray-50 text-[#1a2a1a]" id="newPassword" type="password"/>
      </div>
      <div class="mb-4">
       <label class="block text-sm font-medium text-[#1a2a1a] mb-2" for="confirmPassword">
        Confirm New Password
       </label>
       <input class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#6b7a6b] bg-gray-50 text-[#1a2a1a]" id="confirmPassword" type="password"/>
      </div>
      <button class="bg-[#1a2a1a] text-white font-semibold py-2 px-4 rounded-lg hover:bg-[#2a3a2a] transition duration-300" type="submit">
       Change Password
      </button>
     </form>
    </div>
   </section>
  </div>
  <script>
   const sidebar = document.getElementById('sidebar');
    const sidebarToggleMain = document.getElementById('sidebarToggleMain');
    const overlay = document.getElementById('overlay');
    const contentWrapper = document.getElementById('contentWrapper');

    function toggleSidebar() {
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
      contentWrapper.classList.toggle('sidebar-open');
    }

    // Toggle sidebar on button click
    sidebarToggleMain.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Switch sections based on navigation
    document.getElementById('navDashboard').addEventListener('click', () => showSection('sectionDashboard'));
    document.getElementById('navReport').addEventListener('click', () => showSection('sectionReport'));
    document.getElementById('navStatistics').addEventListener('click', () => showSection('sectionStatistics'));
    document.getElementById('navArticles').addEventListener('click', () => showSection('sectionArticles'));
    document.getElementById('navProfile').addEventListener('click', () => showSection('sectionProfile'));

    function showSection(sectionId) {
      const sections = document.querySelectorAll('section[id^="section"]');
      sections.forEach(section => {
        section.classList.add('hidden');
      });
      document.getElementById(sectionId).classList.remove('hidden');

      // Update active navigation button
      const navButtons = document.querySelectorAll('nav button');
      navButtons.forEach(button => {
        button.classList.remove('bg-[#1a2a1a]', 'text-white');
        button.classList.add('hover:text-[#a0b0a0]');
      });
      document.getElementById('nav' + sectionId.replace('section', '')).classList.add('bg-[#1a2a1a]', 'text-white');
      document.getElementById('nav' + sectionId.replace('section', '')).classList.remove('hover:text-[#a0b0a0]');

      // Close sidebar on mobile after navigation
      if (window.innerWidth < 768 && !sidebar.classList.contains('-translate-x-full')) {
        toggleSidebar();
      }
    }

    // Initialize dashboard data (example data, replace with actual data from backend)
    let transactions = [];
    const dashboardIncomeEl = document.getElementById('dashboardIncome');
    const dashboardOutcomeEl = document.getElementById('dashboardOutcome');
    const dashboardTransactionList = document.getElementById('dashboardTransactionList');
    const totalSavingsEl = document.getElementById('totalSavings');
    const burnRateEl = document.getElementById('burnRate');
    const categoryChartCtx = document.getElementById('categoryChart');
    const monthlyChartCtx = document.getElementById('monthlyChart');

    // Function to format Rupiah
    function formatRupiah(amount) {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
    }

    // Load transactions from local storage or use default
    function loadTransactions() {
      const storedTransactions = localStorage.getItem('transactions');
      if (storedTransactions) {
        transactions = JSON.parse(storedTransactions);
      } else {
        transactions = []; // Default empty array
      }
      updateDashboard();
      updateCharts();
    }

    // Save transactions to local storage
    function saveTransactions() {
      localStorage.setItem('transactions', JSON.stringify(transactions));
    }

    // Add transaction
    document.getElementById('transactionForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const type = document.getElementById('type').value;
      const category = document.getElementById('category').value;
      const amount = parseFloat(document.getElementById('amount').value);
      const date = document.getElementById('date').value;
      const description = document.getElementById('description').value;

      transactions.push({ type, category, amount, date, description });
      saveTransactions();
      updateDashboard();
      updateCharts();
      this.reset(); // Clear form
    });

    // Delete transaction
    function deleteTransaction(index) {
      transactions.splice(index, 1);
      saveTransactions();
      updateDashboard();
      updateCharts();
    }

    // Update dashboard income, outcome, recent transactions
    function updateDashboard() {
      let totalIncome = 0;
      let totalOutcome = 0;

      // Calculate totals
      for (const t of transactions) {
        if (t.type === "income") totalIncome += t.amount;
        else totalOutcome += t.amount;
      }

      dashboardIncomeEl.textContent = formatRupiah(totalIncome);
      dashboardOutcomeEl.textContent = formatRupiah(totalOutcome);

      // Update recent transactions list (show latest 7)
      dashboardTransactionList.innerHTML = "";
      const sorted = [...transactions].sort(
        (a, b) => new Date(b.date) - new Date(a.date)
      );
      const recent = sorted.slice(0, 7);
      for (const t of recent) {
        const li = document.createElement("li");
        li.className = "py-2 flex justify-between items-center";
        li.innerHTML = `
          <div>
            <div class="font-semibold text-sm text-[#1a2a1a]">${t.category}</div>
            <div class="text-[10px] text-gray-500">${t.date}</div>
          </div>
          <div class="${
            t.type === "income" ? "text-green-600" : "text-red-600"
          } font-semibold">${formatRupiah(t.amount)}</div>
        `;
        dashboardTransactionList.appendChild(li);
      }
    }

    let categoryChart, monthlyChart;

    // Update charts
    function updateCharts() {
      const incomeByCategory = {};
      const expenseByCategory = {};
      const monthlyIncome = {};
      const monthlyExpense = {};

      transactions.forEach(t => {
        const month = new Date(t.date).toLocaleString('en-us', { month: 'short', year: 'numeric' });

        if (t.type === 'income') {
          incomeByCategory[t.category] = (incomeByCategory[t.category] || 0) + t.amount;
          monthlyIncome[month] = (monthlyIncome[month] || 0) + t.amount;
        } else {
          expenseByCategory[t.category] = (expenseByCategory[t.category] || 0) + t.amount;
          monthlyExpense[month] = (monthlyExpense[month] || 0) + t.amount;
        }
      });

      // Sort months chronologically
      const sortedMonths = Object.keys({ ...monthlyIncome, ...monthlyExpense }).sort((a, b) => {
        const dateA = new Date(a);
        const dateB = new Date(b);
        return dateA - dateB;
      });

      // Category Chart (Doughnut)
      const categoryLabels = Object.keys(expenseByCategory);
      const categoryData = Object.values(expenseByCategory);

      if (categoryChart) categoryChart.destroy();
      categoryChart = new Chart(categoryChartCtx, {
        type: 'doughnut',
        data: {
          labels: categoryLabels,
          datasets: [{
            data: categoryData,
            backgroundColor: [
              '#FF6384',
              '#36A2EB',
              '#FFCE56',
              '#4BC0C0',
              '#9966FF',
              '#FF9900',
            ],
            hoverBackgroundColor: [
              '#FF6384',
              '#36A2EB',
              '#FFCE56',
              '#4BC0C0',
              '#9966FF',
              '#FF9900',
            ],
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
            },
          },
        },
      });

      // Monthly Chart (Line)
      const incomeData = sortedMonths.map(month => monthlyIncome[month] || 0);
      const expenseData = sortedMonths.map(month => monthlyExpense[month] || 0);
      const netBalanceData = sortedMonths.map(month => (monthlyIncome[month] || 0) - (monthlyExpense[month] || 0));

      if (monthlyChart) monthlyChart.destroy();
      monthlyChart = new Chart(monthlyChartCtx, {
        type: 'line',
        data: {
          labels: sortedMonths,
          datasets: [{
            label: 'Income',
            data: incomeData,
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            fill: true,
            tension: 0.3,
          },
          {
            label: 'Expense',
            data: expenseData,
            borderColor: '#F44336',
            backgroundColor: 'rgba(244, 67, 54, 0.2)',
            fill: true,
            tension: 0.3,
          },
          {
            label: 'Net Balance',
            data: netBalanceData,
            borderColor: '#2196F3',
            backgroundColor: 'rgba(33, 150, 243, 0.2)',
            fill: true,
            tension: 0.3,
          },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return formatRupiah(value);
                },
              },
            },
          },
          plugins: {
            tooltip: {
              callbacks: {
                label: function(context) {
                  return `${context.dataset.label}: ${formatRupiah(context.raw)}`;
                },
              },
            },
          },
        },
      });

      // Calculate total savings and burn rate
      const totalIncome = transactions.filter(t => t.type === 'income').reduce((sum, t) => sum + t.amount, 0);
      const totalExpense = transactions.filter(t => t.type === 'expense').reduce((sum, t) => sum + t.amount, 0);
      const totalSavings = totalIncome - totalExpense;

      totalSavingsEl.textContent = formatRupiah(totalSavings);

      // Simple burn rate: total expense / number of months with transactions
      const monthsWithTransactions = new Set(transactions.map(t => new Date(t.date).toLocaleString('en-us', { month: 'short', year: 'numeric' }))).size;
      const burnRate = monthsWithTransactions > 0 ? totalExpense / monthsWithTransactions : 0;
      burnRateEl.textContent = `${formatRupiah(burnRate)}/month`;
    }

    // Load initial data
    document.addEventListener('DOMContentLoaded', () => {
      loadTransactions();
      showSection('sectionDashboard'); // Default view
    });

    // Articles (example data and rendering)
    const articles = [
      {
        title: "Understanding Cash Flow for UMKM",
        summary: "Learn how to effectively manage your cash flow to ensure business stability and growth.",
        link: "#",
      },
      {
        title: "Importance of Financial Statements",
        summary: "Discover why accurate financial statements are crucial for decision-making and investment.",
        link: "#",
      },
      {
        title: "Tax Tips for Small Businesses",
        summary: "Navigate the complexities of taxation with these essential tips for UMKM owners.",
        link: "#",
      },
      {
        title: "Marketing on a Budget for UMKM",
        summary: "Effective marketing strategies that won't break the bank for your small business.",
        link: "#",
      },
    ];

    const articlesList = document.getElementById('articlesList');

    function renderArticles() {
      articlesList.innerHTML = '';
      articles.forEach(article => {
        const articleCard = document.createElement('div');
        articleCard.className = 'bg-white rounded-lg p-6 shadow-md border-2 border-[#4a5a4a]';
        articleCard.innerHTML = `
          <h3 class="text-lg font-semibold text-[#1a2a1a] mb-2">${article.title}</h3>
          <p class="text-sm text-gray-600 mb-4">${article.summary}</p>
          <a href="${article.link}" class="text-[#1a2a1a] font-semibold hover:underline text-sm">Read More &rarr;</a>
        `;
        articlesList.appendChild(articleCard);
      });
    }

    document.getElementById('navArticles').addEventListener('click', renderArticles);

    // On window resize, reset sidebar and overlay for desktop and adjust content width
    window.addEventListener('resize', function() {
      if (window.innerWidth >= 768) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.add('hidden');
        contentWrapper.classList.add('sidebar-open');
      } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        contentWrapper.classList.remove('sidebar-open');
      }
    });
  </script>
 </body>
</html>