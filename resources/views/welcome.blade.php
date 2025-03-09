<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peemco</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #4f46e5, #6366f1);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .mobile-menu {
            max-height: 0;
            transition: max-height 0.3s ease-out;
            overflow: hidden;
        }
        .mobile-menu.active {
            max-height: 500px;
            transition: max-height 0.3s ease-in;
        }
        .process-step {
            position: relative;
            padding-left: 2rem;
        }
        .process-step::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 1.5rem;
            height: 1.5rem;
            background: #4f46e5;
            border-radius: 50%;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/80 backdrop-blur-md">
        <nav class="container px-4 mx-auto">
            <div class="flex items-center justify-between h-16">
                <a href="#" class="text-xl font-bold gradient-text">
                    <x-brand hasName="true" size="12" class="flex items-center space-x-4 text-3xl font-bold text-gray-800" />
                    
                </a>

                <!-- Desktop Nav -->
                <div class="items-center hidden space-x-6 md:flex">
                    <a href="#features" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Features</a>
                    <a href="#process" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Process</a>
                    <a href="#testimonials" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Reviews</a>
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-indigo-600 rounded-lg hover:bg-indigo-50">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Get Started</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="p-2 rounded-lg md:hidden hover:bg-gray-100" id="menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu md:hidden" id="mobile-menu">
                <div class="flex flex-col pb-4 space-y-4">
                    <a href="#features" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50">Features</a>
                    <a href="#process" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50">Process</a>
                    <a href="#testimonials" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50">Reviews</a>
                    <div class="pt-4 border-t">
                        @auth
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-indigo-600 rounded-lg hover:bg-indigo-50">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-indigo-600 rounded-lg hover:bg-indigo-50">Login</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-indigo-600 rounded-lg hover:bg-indigo-50">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <main>
        <section class="px-4 pt-20 pb-16">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="mb-6 text-4xl font-bold text-gray-900 md:text-5xl">
                    Financial Freedom,<br>
                    <span class="gradient-text">Simplified</span>
                </h1>
                <p class="mb-8 text-lg text-gray-600">Smart lending solutions for personal and business growth</p>
                <a href="{{ route('user.dashboard') }}" class="inline-block px-8 py-3 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    Apply Now →
                </a>
            </div>
        </section>

        <!-- Features Grid -->
        <section class="px-4 py-16 bg-white" id="features">
            <div class="max-w-6xl mx-auto">
                <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Why Choose QuickLoan</h2>
                <div class="grid gap-8 md:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="p-6 transition-colors rounded-xl bg-gray-50 hover:bg-white">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Instant Approval</h3>
                        <p class="text-gray-600">Get loan decisions in minutes with our AI-powered approval system.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="p-6 transition-colors rounded-xl bg-gray-50 hover:bg-white">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Competitive Rates</h3>
                        <p class="text-gray-600">Enjoy some of the most competitive interest rates in the market.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="p-6 transition-colors rounded-xl bg-gray-50 hover:bg-white">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Flexible Terms</h3>
                        <p class="text-gray-600">Choose repayment plans that fit your financial situation.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="px-4 py-16 bg-gray-50" id="process">
            <div class="max-w-6xl mx-auto">
                <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">How It Works</h2>
                <div class="grid gap-8 md:grid-cols-4">
                    <div class="process-step">
                        <h3 class="mb-2 text-xl font-semibold">1. Apply Online</h3>
                        <p class="text-gray-600">Complete our simple online application in minutes.</p>
                    </div>
                    <div class="process-step">
                        <h3 class="mb-2 text-xl font-semibold">2. Get Approved</h3>
                        <p class="text-gray-600">Receive instant approval decision with our AI system.</p>
                    </div>
                    <div class="process-step">
                        <h3 class="mb-2 text-xl font-semibold">3. Sign Documents</h3>
                        <p class="text-gray-600">E-sign your loan documents securely online.</p>
                    </div>
                    <div class="process-step">
                        <h3 class="mb-2 text-xl font-semibold">4. Receive Funds</h3>
                        <p class="text-gray-600">Get your money as fast as the same day.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="px-4 py-16 bg-white" id="testimonials">
            <div class="max-w-6xl mx-auto">
                <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">What Our Customers Say</h2>
                <div class="grid gap-8 md:grid-cols-3">
                    <div class="p-6 rounded-lg bg-gray-50">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full"></div>
                            <div class="ml-4">
                                <h4 class="font-semibold">John Doe</h4>
                                <p class="text-sm text-gray-500">Small Business Owner</p>
                            </div>
                        </div>
                        <p class="text-gray-600">"QuickLoan helped me expand my business with their fast and reliable service. Highly recommended!"</p>
                    </div>
                    <!-- Add more testimonials -->
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="px-4 py-16 bg-indigo-600">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="mb-6 text-3xl font-bold text-white">Ready to Get Started?</h2>
                <p class="mb-8 text-lg text-indigo-100">Take the first step towards your financial goals today.</p>
                <a href="{{ route('user.dashboard') }}" class="inline-block px-8 py-3 font-medium text-indigo-600 bg-white rounded-lg hover:bg-indigo-50">
                    Apply Now →
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="px-4 py-12 text-gray-300 bg-gray-900">
        <div class="max-w-6xl mx-auto">
            <div class="grid gap-8 text-sm md:grid-cols-4">
                <div>
                    <h4 class="mb-4 font-medium text-white">QuickLoan</h4>
                    <p class="mb-4">Empowering financial futures through innovation</p>
                </div>
                <div>
                    <h4 class="mb-4 font-medium text-white">Products</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-indigo-400">Personal Loans</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Business Loans</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Credit Lines</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-medium text-white">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-indigo-400">About Us</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Careers</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-medium text-white">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-indigo-400">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 mt-12 text-center border-t border-gray-800">
                <p>&copy; 2024 QuickLoan. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });
    </script>
</body>
</html>
