<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickLoan - Modern Financial Solutions</title>
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
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/80 backdrop-blur-md">
        <nav class="container px-4 mx-auto">
            <div class="flex items-center justify-between h-16">
                <a href="#" class="text-xl font-bold gradient-text">QuickLoan</a>

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
                <a href="#apply" class="inline-block px-8 py-3 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    Apply Now →
                </a>
            </div>
        </section>

        <!-- Features Grid -->
        <section class="px-4 py-16 bg-white" id="features">
            <div class="max-w-6xl mx-auto">
                <div class="grid gap-8 md:grid-cols-3">
                    <div class="p-6 transition-colors rounded-xl bg-gray-50 hover:bg-white">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Instant Approval</h3>
                        <p class="text-gray-600">AI-powered decisions in under 5 minutes</p>
                    </div>

                    <!-- Repeat similar blocks for other features -->
                </div>
            </div>
        </section>

        <!-- Other Sections ... -->
    </main>

    <!-- Footer -->
    <footer class="px-4 py-12 text-gray-300 bg-gray-900">
        <div class="max-w-6xl mx-auto">
            <div class="grid gap-8 text-sm md:grid-cols-4">
                <div>
                    <h4 class="mb-4 font-medium text-white">QuickLoan</h4>
                    <p class="mb-4">Empowering financial futures through innovation</p>
                </div>
                <!-- Repeat similar blocks for footer columns -->
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
