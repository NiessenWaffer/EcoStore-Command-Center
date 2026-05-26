@props(['status' => 'verified'])

@php
    $config = [
        'verified' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'border' => 'border-green-200',
            'icon' => 'lucide-shield-check',
            'label' => 'Trust Verified'
        ],
        'tampered' => [
            'bg' => 'bg-red-100',
            'text' => 'text-red-800',
            'border' => 'border-red-200',
            'icon' => 'lucide-alert-triangle',
            'label' => 'Integrity Alert'
        ],
        'corrected' => [
            'bg' => 'bg-amber-100',
            'text' => 'text-amber-800',
            'border' => 'border-amber-200',
            'icon' => 'lucide-info',
            'label' => 'History Corrected'
        ]
    ][$status] ?? $config['verified'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {$config['bg']} {$config['text']} {$config['border']} transition-all duration-300 shadow-sm"]) }}>
    <x-dynamic-component :component="$config['icon']" class="w-3.5 h-3.5" />
    {{ $config['label'] }}
</span>
