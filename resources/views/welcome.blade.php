<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickLoan - Fast and Easy Lending</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#fef9c3',
                        secondary: '#bbf7d0',
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-primary">
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-yellow-500">QuickLoan</a>
            <div class="space-x-4">
                <a href="#mission-vision" class="text-gray-600 hover:text-yellow-500">About Us</a>
                <a href="#features" class="text-gray-600 hover:text-yellow-500">Features</a>
                <a href="#how-it-works" class="text-gray-600 hover:text-yellow-500">How It Works</a>
                <a href="#testimonials" class="text-gray-600 hover:text-yellow-500">Testimonials</a>
            </div>
            <a href="#apply-now" class="bg-green-400 text-white px-4 py-2 rounded-md hover:bg-green-500 transition duration-300">Apply Now</a>
        </nav>
    </header>

    <main>
        <section class="bg-yellow-200 text-gray-800 py-20">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Get the Funds You Need, Fast and Easy</h1>
                <p class="text-xl mb-8">QuickLoan provides hassle-free personal and business loans with competitive rates.</p>
                <a href="#apply-now" class="bg-green-400 text-white px-6 py-3 rounded-md text-lg font-semibold hover:bg-green-500 transition duration-300">Start Your Application</a>
            </div>
        </section>

        <section id="mission-vision" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Our Mission & Vision</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-2xl font-semibold mb-4 text-yellow-600">Our Mission</h3>
                        <p class="text-gray-700">At QuickLoan, our mission is to empower individuals and businesses by providing accessible, fast, and fair financial solutions. We strive to simplify the lending process, making it transparent and stress-free for our clients.</p>
                    </div>
                    <div class="bg-green-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-2xl font-semibold mb-4 text-green-600">Our Vision</h3>
                        <p class="text-gray-700">We envision a world where financial opportunities are within reach for everyone. QuickLoan aims to be the leading innovative lending platform, known for its customer-centric approach, cutting-edge technology, and commitment to financial inclusion.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Why Choose QuickLoan?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Fast Approval</h3>
                        <p class="text-gray-600">Get approved in as little as 24 hours with our streamlined application process.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Competitive Rates</h3>
                        <p class="text-gray-600">Enjoy some of the lowest interest rates in the industry, tailored to your credit profile.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Flexible Terms</h3>
                        <p class="text-gray-600">Choose from a variety of repayment options that fit your financial situation.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="bg-green-100 py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
                <div class="flex flex-col md:flex-row justify-center items-center space-y-8 md:space-y-0 md:space-x-12">
                    <div class="text-center">
                        <div class="bg-yellow-400 text-white rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold mb-4 mx-auto">1</div>
                        <h3 class="text-xl font-semibold mb-2">Apply Online</h3>
                        <p class="text-gray-600">Fill out our simple online application in minutes.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-yellow-400 text-white rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold mb-4 mx-auto">2</div>
                        <h3 class="text-xl font-semibold mb-2">Get Approved</h3>
                        <p class="text-gray-600">Receive a decision quickly, often within 24 hours.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-yellow-400 text-white rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold mb-4 mx-auto">3</div>
                        <h3 class="text-xl font-semibold mb-2">Receive Funds</h3>
                        <p class="text-gray-600">Get your money deposited directly into your bank account.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonials" class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">What Our Customers Say</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 mb-4">"QuickLoan made it incredibly easy to get the funds I needed for my small business. The process was smooth, and the customer service was excellent!"</p>
                        <p class="font-semibold">- Sarah T., Small Business Owner</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 mb-4">"I was impressed by how quickly I was approved for my personal loan. The rates were better than I expected, and the repayment terms are very manageable."</p>
                        <p class="font-semibold">- Michael R., Personal Loan Recipient</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="apply-now" class="bg-yellow-200 text-gray-800 py-16">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
                <p class="text-xl mb-8">Apply now and get the funds you need in as little as 24 hours.</p>
                <a href="#" class="bg-green-400 text-white px-6 py-3 rounded-md text-lg font-semibold hover:bg-green-500 transition duration-300">Start Your Application</a>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <a href="#" class="text-2xl font-bold text-yellow-400">QuickLoan</a>
                    <p class="text-sm mt-2">Fast and easy lending solutions</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-yellow-400">Terms of Service</a>
                    <a href="#" class="hover:text-yellow-400">Privacy Policy</a>
                    <a href="#" class="hover:text-yellow-400">Contact Us</a>
                </div>
            </div>
            <div class="mt-8 text-center text-sm">
                <p>&copy; 2024 QuickLoan. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>