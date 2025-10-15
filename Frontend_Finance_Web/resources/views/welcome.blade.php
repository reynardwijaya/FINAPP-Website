<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finapp - Smart Financial Planning for UMKM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'gradient-y': 'gradient-y 15s ease infinite',
                        'gradient-xy': 'gradient-xy 15s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        'gradient-y': {
                            '0%, 100%': {
                                'background-size': '400% 400%',
                                'background-position': 'center top'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'center center'
                            }
                        },
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'gradient-xy': {
                            '0%, 100%': {
                                'background-size': '400% 400%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #4F46E5, #7C3AED);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% 200%;
            animation: gradient-xy 15s ease infinite;
        }
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dark .glass-effect {
            background: rgba(17, 24, 39, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .feature-card {
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        .feature-card:hover {
            border-color: #4F46E5;
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.1), 0 10px 10px -5px rgba(79, 70, 229, 0.04);
        }
        .dark .feature-card {
            background: rgba(17, 24, 39, 0.7);
            border-color: rgba(255, 255, 255, 0.1);
        }
        .dark .feature-card:hover {
            border-color: #7C3AED;
            box-shadow: 0 20px 25px -5px rgba(124, 58, 237, 0.1), 0 10px 10px -5px rgba(124, 58, 237, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-lg fixed w-full z-50 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logoF-Photoroom.png') }}" alt="Finapp Logo" class="h-20 w-auto">
                        <h1 class="text-2xl font-bold gradient-text">Finapp</h1>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Features</a>
                        <a href="#about" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">About</a>
                        <a href="#testimonials" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Testimonials</a>
                        <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-sun text-yellow-500 dark:hidden"></i>
                            <i class="fas fa-moon text-blue-300 hidden dark:block"></i>
                        </button>
                        <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg dark:bg-indigo-500 dark:hover:bg-indigo-600">Register</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="pt-32 pb-20 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-900 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center" data-aos="fade-up">
                    <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white sm:text-6xl sm:tracking-tight lg:text-7xl mb-6">
                        Smart Financial Planning for 
                        <span class="gradient-text">UMKM</span>
                    </h1>
                    <p class="mt-5 max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                        Transform your helmet cleaning business with AI-powered financial insights. 
                        Track, analyze, and optimize your finances with our comprehensive suite of tools.
                    </p>
                    <div class="mt-10 flex justify-center space-x-4">
                        <a href="{{ route('register') }}" class="group bg-indigo-600 text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-indigo-700 transition-all shadow-lg hover:shadow-xl hover-scale dark:bg-indigo-500 dark:hover:bg-indigo-600">
                            Start Free Trial
                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="#features" class="group bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 px-8 py-4 rounded-full text-lg font-semibold border-2 border-indigo-600 dark:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl hover-scale">
                            Learn More
                            <i class="fas fa-chevron-down ml-2 transform group-hover:translate-y-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                <div class="mt-16 relative" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 dark:from-indigo-500/10 dark:to-purple-500/10 rounded-2xl blur-3xl"></div>
                    <img src="/images/dashboard.png" alt="Dashboard Preview" class="rounded-lg shadow-2xl mx-auto max-w-4xl w-full animate-float relative z-10">
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="py-20 bg-white dark:bg-gray-800 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white">Powerful Features for Your Business</h2>
                    <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">Everything you need to manage your finances effectively</p>
                </div>
                <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="feature-card bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-chart-line text-2xl text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Smart Financial Tracking</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Automatically categorize and track all your income and expenses. Get real-time insights into your business performance with detailed analytics and customizable reports.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-robot text-2xl text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">AI-Powered Insights</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Leverage advanced AI algorithms to predict trends, identify opportunities, and receive personalized recommendations for business growth and financial optimization.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-16 h-16 bg-pink-100 dark:bg-pink-900/50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-graduation-cap text-2xl text-pink-600 dark:text-pink-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Financial Education Hub</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Access a comprehensive library of resources, articles, and guides to improve your financial literacy and make informed business decisions.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div id="about" class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div data-aos="fade-right">
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">Why Choose Finapp?</h2>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                            Finapp is specifically designed for UMKM owners who want to take control of their business finances. Our platform combines powerful financial tools with user-friendly interfaces to help you make better business decisions.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-center space-x-3 group">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-check-circle text-green-500 dark:text-green-400"></i>
                                </div>
                                <span class="text-gray-600 dark:text-gray-300">Easy-to-use interface designed for non-financial experts</span>
                            </li>
                            <li class="flex items-center space-x-3 group">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-check-circle text-green-500 dark:text-green-400"></i>
                                </div>
                                <span class="text-gray-600 dark:text-gray-300">Real-time financial monitoring and reporting</span>
                            </li>
                            <li class="flex items-center space-x-3 group">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-check-circle text-green-500 dark:text-green-400"></i>
                                </div>
                                <span class="text-gray-600 dark:text-gray-300">Secure cloud-based platform accessible anywhere</span>
                            </li>
                            <li class="flex items-center space-x-3 group">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-check-circle text-green-500 dark:text-green-400"></i>
                                </div>
                                <span class="text-gray-600 dark:text-gray-300">Dedicated support team for UMKM owners</span>
                            </li>
                        </ul>
                    </div>
                    <div class="relative" data-aos="fade-left">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 dark:from-indigo-500/10 dark:to-purple-500/10 rounded-2xl blur-3xl"></div>
                        <img src="/images/about-illustration.svg" alt="About Finapp" class="rounded-lg shadow-xl relative z-10">
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div id="testimonials" class="py-20 bg-white dark:bg-gray-800 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white">What Our Users Say</h2>
                    <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">Join hundreds of satisfied UMKM owners</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="glass-effect p-8 rounded-2xl shadow-lg hover-scale" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Budi Santoso</h4>
                                <p class="text-gray-600 dark:text-gray-300">Helmet Cleaning Business Owner</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 italic">"Finapp has transformed how I manage my business finances. The AI insights have helped me make better decisions and grow my business."</p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="glass-effect p-8 rounded-2xl shadow-lg hover-scale" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Siti Rahayu</h4>
                                <p class="text-gray-600 dark:text-gray-300">Small Business Owner</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 italic">"The financial tracking features are incredibly easy to use. I can now focus on growing my business instead of worrying about finances."</p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="glass-effect p-8 rounded-2xl shadow-lg hover-scale" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/50 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-pink-600 dark:text-pink-400"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Ahmad Rizki</h4>
                                <p class="text-gray-600 dark:text-gray-300">Entrepreneur</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 italic">"The AI-powered insights have helped me identify new opportunities and optimize my business operations. Highly recommended!"</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-700 dark:to-purple-700">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <div class="text-center lg:text-left" data-aos="fade-right">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        <span class="block">Ready to transform your business?</span>
                        <span class="block text-indigo-200 dark:text-indigo-100 mt-2">Start your free trial today.</span>
                </h2>
                    <p class="mt-4 text-lg text-indigo-100 dark:text-indigo-200">
                        Join hundreds of UMKM owners who are already using Finapp to grow their businesses.
                    </p>
                </div>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0 justify-center lg:justify-end" data-aos="fade-left">
                    <div class="inline-flex rounded-full shadow">
                        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-full text-indigo-600 bg-white hover:bg-indigo-50 transition-colors hover-scale">
                            Get Started Now
                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="{{ asset('images/logoF-Photoroom.png') }}" alt="Finapp Logo" class="h-16 w-auto">
                            <h3 class="text-xl font-bold">Finapp</h3>
                        </div>
                        <p class="text-gray-400">Smart financial planning for UMKM owners.</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Features</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Financial Tracking</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">AI Analysis</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Reports</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Education Hub</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Company</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Connect</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors hover:scale-110 transform">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors hover:scale-110 transform">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors hover:scale-110 transform">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors hover:scale-110 transform">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-400">
                    <p>&copy; 2024 Finapp. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Dark mode toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        // Check for saved theme preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        // Toggle theme
        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html> 