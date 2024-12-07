<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    {{-- <x-bread-crumbs :routes="[
        ['label'=>'Select Loan','name'=>null]
    ]"/> --}}
    <x-header title="Loan Application" subtitle="Choose the type of loan that best fits your needs" separator />
    <div class="max-w-5xl mx-auto space-y-6">


        <div class="grid gap-6 sm:grid-cols-2">
            <!-- Regular Loan Card -->
            <div class="relative overflow-hidden transition-all bg-white border border-gray-200 rounded-lg hover:shadow-lg">
                <div class="absolute inset-0 pointer-events-none bg-gradient-to-r from-blue-500/10 to-blue-500/5"></div>
                <div class="p-6">
                    <h2 class="flex items-center gap-2 mb-2 text-xl font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                        Regular Loan
                    </h2>
                    <p class="mb-4 text-gray-600">Traditional loan with competitive interest rates</p>
                    <div class="space-y-4">
                        <div>
                            <span class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full">Features</span>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <li>Fixed monthly payments</li>
                                <li>Flexible loan terms</li>
                                <li>No prepayment penalties</li>
                            </ul>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Processing time: 2-3 business days
                        </div>
                    </div>
                </div>
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('user.loan-regular') }}" class="inline-block w-full px-4 py-2 font-semibold text-center text-white transition duration-300 ease-in-out bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Proceed
                    </a>
                </div>
            </div>

            <!-- Cash Advance Card -->
            <div class="relative overflow-hidden transition-all bg-white border border-gray-200 rounded-lg hover:shadow-lg">
                <div class="absolute inset-0 pointer-events-none bg-gradient-to-r from-teal-500/10 to-teal-500/5"></div>
                <div class="p-6">
                    <h2 class="flex items-center gap-2 mb-2 text-xl font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cash Advance
                    </h2>
                    <p class="mb-4 text-gray-600">Quick access to funds for immediate needs</p>
                    <div class="space-y-4">
                        <div>
                            <span class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full">Features</span>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <li>Same-day approval possible</li>
                                <li>Minimal documentation</li>
                                <li>Short-term financing</li>
                            </ul>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Processing time: Same day
                        </div>
                    </div>
                </div>
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    {{-- <a href="{{ route('user.loan-cash-advance') }}" class="inline-block w-full px-4 py-2 font-semibold text-center text-white transition duration-300 ease-in-out bg-teal-600 rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                        Proceed
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

</div>
