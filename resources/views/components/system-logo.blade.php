<div class="flex items-center space-x-4">
    <!-- Logo Section -->
    <div class="flex items-center space-x-3">
        <img src="{{ $settings->logo ?? '/default/default-logo.png' }}" class="w-{{ $size }} h-auto rounded-lg shadow-md" alt="Logo" />

        <!-- Company Name Section -->
        @if($hasName)
            <div class="text-xl font-semibold text-gray-800">
                {{ $settings->company_name }}
            </div>
        @endif
    </div>
</div>
