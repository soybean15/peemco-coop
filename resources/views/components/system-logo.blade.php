<div>


    {{-- {{ $hasName }} --}}
    <div class="{{ $class }}">
        <img src="{{ $settings->logo ?? '/default/default-logo.png' }}" class="rounded-lg w-{{ $size }}" />

        @if($hasName)
            <div>
                {{ $settings->company_name }}
            </div>
        @endif


    </div>
</div>
