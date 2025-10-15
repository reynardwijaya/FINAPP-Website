@extends('layouts.app')

@section('content')
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
  <title>Financial Planner - UMKM Helm &amp; Cuci Helm</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
 </head>
 <body class="min-h-screen bg-gradient-to-tr from-[#4a6a5a] via-[#5a7a6a] to-[#6a8a7a] flex">
  <!-- Sidebar -->
  <aside class="fixed top-0 left-0 h-full bg-[#e6eee7] p-8 md:pt-12 md:pb-12 md:px-8 flex flex-col select-none transform -translate-x-full z-50" id="sidebar">
   <h1 class="text-[#1a2a1a] font-semibold text-lg mb-8 select-none">UMKM Helm &amp; Cuci Helm</h1>
   <nav class="flex flex-col gap-4 text-[#6b7a6b] text-sm font-medium">
    <button class="flex items-center gap-3 bg-[#1a2a1a] text-white rounded-lg py-2 px-6 w-full cursor-pointer" id="navDashboard">
     <i class="fas fa-th-large text-xs"></i> Dashboard
    </button>
    <button class="flex items-center gap-3 hover:text-[#a0b0a0] rounded-lg py-2 px-6 w-full cursor-pointer" id="navReport">
     <i class="fas fa-file-alt text-xs"></i> Report
    </button>
    <button class="flex items-center gap-3 hover:text-[#a0b0a0] rounded-lg py-2 px-6 w-full cursor-pointer" id="navStatistics">
     <i class="fas fa-chart-bar text-xs"></i> Statistics
    </button>
    <button class="flex items-center gap-3 hover:text-[#a0b0a0] rounded-lg py-2 px-6 w-full cursor-pointer" id="navArticles">
     <i class="fas fa-newspaper text-xs"></i> Articles
    </button>
   </nav>
   <div class="mt-auto bg-[#1a2a1a] rounded-none p-6 text-white flex flex-col items-center text-center" style="border-bottom-right-radius: 1rem;">
    <div class="text-sm font-semibold mb-1 flex items-center justify-center gap-1">Get Premium <i class="fas fa-star text-yellow-400"></i></div>
    <div class="text-[10px] mb-3 leading-[1.1]">Unlimited transfer and <br/> statistics memory</div>
    <button class="bg-[#f9fdf8] text-[#1a2a1a] text-[10px] font-semibold rounded-full py-1 px-6 w-[90px] hover:bg-[#d9e6d9] transition">Upgrade</button>
   </div>
  </aside>
  <!-- Overlay -->
  <div class="fixed inset-0 bg-black bg-opacity-30 hidden z-40 md:hidden" id="overlay"></div>
  <!-- Main content container -->
  <div class="flex-1 w-full min-h-screen bg-[#f9fdf8] rounded-none p-6 md:p-10 flex flex-col gap-6 max-w-full overflow-auto relative z-10 transition-filter duration-300 ease-in-out" id="contentWrapper">
   <!-- Single toggle button for all pages -->
   <button aria-label="Toggle sidebar" class="mb-4 bg-[#1a2a1a] text-white p-2 rounded-md w-10 h-10 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#a0b0a0]" id="sidebarToggleMain" title="Toggle Sidebar">
    <i class="fas fa-bars"></i>
   </button>
   <!-- Articles Section -->
   <section class="hidden max-w-6xl mx-auto w-full" id="sectionArticles">
    <h2 class="text-[#1a2a1a] font-semibold text-2xl mb-8 select-none text-center">Financial Management Articles for UMKM Helm &amp; Cuci Helm</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
     <article class="bg-white rounded-lg shadow-md p-6 flex flex-col border-2 border-[#4a5a4a]">
     <img alt="Illustration of a small business owner planning finances with charts and notes on a desk" class="rounded-lg mb-4 w-full object-cover h-48" height="300" src="https://storage.googleapis.com/a1aa/image/92431ef4-afe5-46df-7c1c-8dee7a0538ec.jpg" width="600"/>
      <h3 class="text-xl font-semibold mb-2 text-[#1a2a1a]">Financial Planning for UMKM Helm &amp; Cuci Helm</h3>
      <p class="text-gray-700 flex-grow">Pelajari cara membuat perencanaan keuangan yang efektif untuk bisnis helm dan jasa cuci helm Anda agar dapat mengelola arus kas dan investasi dengan baik.</p>
      <a class="mt-4 text-green-700 font-semibold hover:underline self-start" href="#">Read More</a>
     </article>
     <article class="bg-white rounded-lg shadow-md p-6 flex flex-col border-2 border-[#4a5a4a]">
      <img alt="Illustration of cash flow management with money and calendar icons" class="rounded-lg mb-4 w-full object-cover h-48" height="300" src="https://storage.googleapis.com/a1aa/image/6c73bbad-3cc8-4f45-b868-fcf9add7d953.jpg" width="600"/>
      <h3 class="text-xl font-semibold mb-2 text-[#1a2a1a]">Managing Cash Flow in Your Helm Business</h3>
      <p class="text-gray-700 flex-grow">Tips dan trik mengelola arus kas agar bisnis helm dan cuci helm Anda tetap sehat dan mampu menghadapi tantangan keuangan sehari-hari.</p>
      <a class="mt-4 text-green-700 font-semibold hover:underline self-start" href="#">Read More</a>
     </article>
     <article class="bg-white rounded-lg shadow-md p-6 flex flex-col border-2 border-[#4a5a4a]">
      <img alt="Illustration of cost control with calculator and budget sheets" class="rounded-lg mb-4 w-full object-cover h-48" height="300" src="https://storage.googleapis.com/a1aa/image/b983eac8-f7a7-4c09-41ba-0df39fc8a894.jpg" width="600"/>
      <h3 class="text-xl font-semibold mb-2 text-[#1a2a1a]">Cost Control Strategies for UMKM</h3>
      <p class="text-gray-700 flex-grow">Pelajari strategi pengendalian biaya yang dapat membantu bisnis helm dan cuci helm Anda meningkatkan profitabilitas tanpa mengurangi kualitas layanan.</p>
      <a class="mt-4 text-green-700 font-semibold hover:underline self-start" href="#">Read More</a>
     </article>
     <article class="bg-white rounded-lg shadow-md p-6 flex flex-col border-2 border-[#4a5a4a]">
      <img alt="Illustration of marketing budget planning with charts and money" class="rounded-lg mb-4 w-full object-cover h-48" height="300" src="https://storage.googleapis.com/a1aa/image/4dde4880-7185-4aa0-96e2-00dc16b05486.jpg" width="600"/>
      <h3 class="text-xl font-semibold mb-2 text-[#1a2a1a]">Marketing Budget Tips for Small Businesses</h3>
      <p class="text-gray-700 flex-grow">Cara mengalokasikan anggaran pemasaran secara efektif untuk meningkatkan penjualan helm dan jasa cuci helm Anda tanpa membebani keuangan.</p>
      <a class="mt-4 text-green-700 font-semibold hover:underline self-start" href="#">Read More</a>
     </article>
     <article class="bg-white rounded-lg shadow-md p-6 flex flex-col border-2 border-[#4a5a4a]">
      <img alt="Illustration of saving and investment with piggy bank and coins" class="rounded-lg mb-4 w-full object-cover h-48" height="300" src="https://storage.googleapis.com/a1aa/image/86dec276-86d9-4b27-31ab-9dba883557f4.jpg" width="600"/>
      <h3 class="text-xl font-semibold mb-2 text-[#1a2a1a]">Saving and Investment for UMKM Owners</h3>
      <p class="text-gray-700 flex-grow">Panduan menabung dan berinvestasi untuk pemilik UMKM helm dan cuci helm agar bisnis dan keuangan pribadi tetap berkembang.</p>
      <a class="mt-4 text-green-700 font-semibold hover:underline self-start" href="#">Read More</a>
     </article>
     <article class="bg-white rounded-lg shadow-md p-6 flex flex-col border-2 border-[#4a5a4a]">
      <img alt="Illustration of debt management with documents and calculator" class="rounded-lg mb-4 w-full object-cover h-48" height="300" src="https://storage.googleapis.com/a1aa/image/e89870a2-710d-4dae-9d82-9a556dad39c7.jpg" width="600"/>
      <h3 class="text-xl font-semibold mb-2 text-[#1a2a1a]">Effective Debt Management for Small Businesses</h3>
      <p class="text-gray-700 flex-grow">Tips mengelola hutang usaha agar bisnis helm dan cuci helm Anda tetap sehat dan terhindar dari masalah keuangan.</p>
      <a class="mt-4 text-green-700 font-semibold hover:underline self-start" href="#">Read More</a>
     </article>
    </div>
   </section>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/theme.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize articles section
      const sectionArticles = document.getElementById('sectionArticles');
      if (sectionArticles) {
        // Make sure the section is visible when articles nav is clicked
        const navArticles = document.getElementById('navArticles');
        if (navArticles) {
          navArticles.addEventListener('click', function() {
            sectionArticles.classList.remove('hidden');
          });
        }
      }

      // Initialize any article categories if needed
      const articles = document.querySelectorAll('#sectionArticles article');
      articles.forEach((article, index) => {
        // Add category-specific handling
        const categoryNum = (index % 6) + 1; // Cycle through categories 1-6
        const category = `category${categoryNum}`;
        article.dataset.category = category;
        
        // Apply category-specific styling
        const currentTheme = getCurrentTheme();
        const categoryColor = themeColors[currentTheme].chart[category];
        if (categoryColor) {
          article.style.borderColor = categoryColor;
          const readMoreLink = article.querySelector('a');
          if (readMoreLink) {
            readMoreLink.style.color = categoryColor;
          }
        }
      });

      // Initialize any charts if needed
      const chartElements = document.querySelectorAll('[data-chart]');
      chartElements.forEach(element => {
        const chartType = element.dataset.chart;
        const category = element.dataset.category || 'category1';
        const currentTheme = getCurrentTheme();
        
        if (Chart && element.getContext) {
          new Chart(element.getContext('2d'), {
            type: chartType,
            data: {
              // Your chart data here
              datasets: [{
                backgroundColor: themeColors[currentTheme].chart[category],
                // ... other dataset properties
              }]
            },
            options: {
              // Your chart options here
            }
          });
        }
      });
    });
  </script>
 </body>
</html>
@endsection