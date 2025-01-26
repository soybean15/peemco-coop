<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickLoan - Modern Financial Solutions</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            --primary: #4f46e5;
            --secondary: #f59e0b;
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gradient-text {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hover-tilt {
            transition: transform 0.3s ease;
        }
        .hover-tilt:hover {
            transform: rotate(-2deg) scale(1.02);
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">
    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/80 backdrop-blur-md">
        <nav class="container flex items-center justify-between px-6 py-4 mx-auto">
            <a href="#" class="text-2xl font-bold gradient-text">QuickLoan</a>
            <div class="items-center hidden space-x-8 md:flex">
                <a href="#mission-vision" class="font-medium text-gray-600 transition-all duration-300 hover:text-indigo-600">About</a>
                <a href="#features" class="font-medium text-gray-600 transition-all duration-300 hover:text-indigo-600">Features</a>
                <a href="#how-it-works" class="font-medium text-gray-600 transition-all duration-300 hover:text-indigo-600">Process</a>
                <a href="#testimonials" class="font-medium text-gray-600 transition-all duration-300 hover:text-indigo-600">Reviews</a>
                @if(!auth()->user())
                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-lg font-medium hover:shadow-lg transition-all duration-300">Get Started</a>
                @else
                <a href="{{ route('user.dashboard') }}" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-lg font-medium hover:shadow-lg transition-all duration-300">Dashboard</a>
                @endif
            </div>
        </nav>
    </header>

    <main>
        <section class="relative py-24 overflow-hidden">
            <div class="container px-6 mx-auto text-center">
                <div class="max-w-3xl mx-auto animate-fade-in">
                    <h1 class="mb-6 text-5xl font-bold text-gray-900">Financial Freedom,<br><span class="gradient-text">Simplified</span></h1>
                    <p class="mb-8 text-xl text-gray-600">Smart lending solutions for personal and business growth</p>
                    <div class="flex justify-center space-x-4">
                        <a href="#apply-now" class="px-8 py-4 font-medium text-white transition-all duration-300 bg-gradient-to-r from-indigo-600 to-indigo-500 rounded-xl hover:shadow-xl hover:-translate-y-1">
                            Apply Now →
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="mission-vision" class="py-20 bg-white">
            <div class="container px-6 mx-auto">
                <div class="grid grid-cols-1 gap-12 md:grid-cols-2">
                    <div class="p-8 shadow-sm bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl hover-tilt">
                        <div class="flex items-center justify-center mb-6 bg-indigo-100 rounded-lg w-14 h-14">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-2xl font-bold text-gray-900">Our Mission</h3>
                        <p class="leading-relaxed text-gray-600">Redefining financial accessibility through innovative technology and customer-centric solutions.</p>
                    </div>

                    <div class="p-8 shadow-sm bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl hover-tilt">
                        <div class="flex items-center justify-center mb-6 rounded-lg w-14 h-14 bg-amber-100">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-2xl font-bold text-gray-900">Our Vision</h3>
                        <p class="leading-relaxed text-gray-600">Creating a world where financial empowerment is accessible to all through transparent digital solutions.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="py-20 bg-gray-50">
            <div class="container px-6 mx-auto">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 text-4xl font-bold text-gray-900">Why Choose QuickLoan</h2>
                    <p class="max-w-2xl mx-auto text-gray-600">Modern financial solutions designed for your success</p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="p-8 transition-all duration-300 bg-white shadow-sm rounded-2xl hover:shadow-md">
                        <div class="flex items-center justify-center mb-6 bg-green-100 rounded-lg w-14 h-14">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-semibold">Instant Approval</h3>
                        <p class="text-gray-600">AI-powered approval process with 95% decisions under 5 minutes</p>
                    </div>

                    <div class="p-8 transition-all duration-300 bg-white shadow-sm rounded-2xl hover:shadow-md">
                        <div class="flex items-center justify-center mb-6 bg-purple-100 rounded-lg w-14 h-14">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-semibold">Smart Rates</h3>
                        <p class="text-gray-600">Dynamic pricing optimized for your unique financial profile</p>
                    </div>

                    <div class="p-8 transition-all duration-300 bg-white shadow-sm rounded-2xl hover:shadow-md">
                        <div class="flex items-center justify-center mb-6 bg-blue-100 rounded-lg w-14 h-14">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-semibold">Flexible Terms</h3>
                        <p class="text-gray-600">Customizable repayment plans that adapt to your cash flow</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Additional sections with similar modern styling -->

    </main>

    <footer class="py-12 text-gray-300 bg-gray-900">
        <div class="container px-6 mx-auto">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div>
                    <h4 class="mb-4 font-semibold text-white">QuickLoan</h4>
                    <p class="text-sm">Empowering financial futures through innovative lending solutions.</p>
                </div>
                <div>
                    <h4 class="mb-4 font-semibold text-white">Products</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="transition-colors hover:text-indigo-400">Personal Loans</a></li>
                        <li><a href="#" class="transition-colors hover:text-indigo-400">Business Funding</a></li>
                        <li><a href="#" class="transition-colors hover:text-indigo-400">Credit Lines</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-semibold text-white">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="transition-colors hover:text-indigo-400">About Us</a></li>
                        <li><a href="#" class="transition-colors hover:text-indigo-400">Careers</a></li>
                        <li><a href="#" class="transition-colors hover:text-indigo-400">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-semibold text-white">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="transition-colors hover:text-indigo-400">Privacy Policy</a></li>
                        <li><a href="#" class="transition-colors hover:text-indigo-400">Terms of Service</a></li>
                        <li><a href="#" class="transition-colors hover:text-indigo-400">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 mt-12 text-sm text-center border-t border-gray-800">
                <p>&copy; 2024 QuickLoan. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
