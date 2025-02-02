<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>




        {{-- Rich Text Editor --}}
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
        <script src="{{ asset('js/sweet-alert.min.js') }}"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script src="https://unpkg.com/flatpickr/dist/plugins/monthSelect/index.js"></script>
        <link href="https://unpkg.com/flatpickr/dist/plugins/monthSelect/style.css" rel="stylesheet">

        <link rel="icon" href="{{ asset('system-logo.png') }}" type="image/x-icon">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body x-data>
        {{-- {{ env('TINY_MCE') }} --}}
        <x-nav sticky full-width>

            <x-slot:brand>
                {{-- Drawer toggle for "main-drawer" --}}
                <label for="main-drawer" class="mr-3 lg:hidden">
                    <x-icon name="o-bars-3" class="cursor-pointer" />
                </label>

                {{-- Brand --}}
                <div>

                    <x-brand hasName="true" size="20" class="flex items-center space-x-4 text-3xl font-bold"/>
                </div>
            </x-slot:brand>

            {{-- Right side actions --}}
            <x-slot:actions>

            <div
            role="button"
            x-data
            @click.stop="$dispatch('mary-search-open')"
            @keydown.window.ctrl.k.prevent="$dispatch('mary-search-open')"
            class="flex items-center p-1.5 md:p-2 rounded-full shadow-inner bg-slate-100 hover:text-blue-600 transition-colors duration-200"
        >
            <!-- Search icon for mobile -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>

            <!-- Text for desktop -->
            <span class="hidden md:inline-block px-2 md:px-3 text-sm">Search</span>

            <!-- Keyboard shortcut for desktop -->
            <div class="hidden md:flex items-center gap-1">
                <x-kbd class="kbd-sm hover:text-blue-600">ctrl</x-kbd>
                <x-kbd class="kbd-sm hover:text-blue-600">K</x-kbd>
            </div>
        </div>


            </x-slot:actions>
        </x-nav>

        <x-side-bar>
        {{ $slot }}

        </x-side-bar>


        {{-- The main content with `full-width` --}}

        {{--  TOAST area --}}
        <x-toast />
        <x-spotlight />
    </body>
</html>
