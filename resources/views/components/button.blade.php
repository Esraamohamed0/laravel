<div>
    <button type="{{ $type ?? 'x-button' }}" {{ $attributes->merge(['class' => 'btn']) }}>
        {{ $slot }}
    </button>
</div>