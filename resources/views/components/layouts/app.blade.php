<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>

        <x-nav sticky full-width>

            <x-slot:brand>
                {{-- Drawer toggle for "main-drawer" --}}
                <label for="main-drawer" class="lg:hidden mr-3">
                    <x-icon name="o-bars-3" class="cursor-pointer" />
                </label>

                {{-- Brand --}}
                <div><b>PEEMCO-COOP</b></div>
            </x-slot:brand>

            {{-- Right side actions --}}
            <x-slot:actions>
                <x-button label="Messages" icon="o-envelope" link="###" class="btn-ghost btn-sm" responsive />
                <x-button label="Notifications" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive />
            </x-slot:actions>
        </x-nav>

        <x-side-bar>
            {{ $slot }}

        </x-side-bar>


        {{-- The main content with `full-width` --}}

        {{--  TOAST area --}}
        <x-toast />

    </body>
</html>
