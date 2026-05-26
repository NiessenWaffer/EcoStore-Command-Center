@php
    $links = [
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'layout-dashboard',
            'group' => 'Management'
        ],
        [
            'label' => 'Product Inventory',
            'route' => 'admin.products',
            'icon' => 'package',
            'group' => 'Management'
        ],
        [
            'label' => 'Governance Rounds',
            'route' => 'admin.governance',
            'icon' => 'vote',
            'group' => 'Management'
        ],
        [
            'label' => 'Impact Metrics',
            'route' => 'admin.metrics',
            'icon' => 'line-chart',
            'group' => 'Management'
        ],
        [
            'label' => 'Correction Queue',
            'route' => 'admin.corrections.index',
            'icon' => 'shield-alert',
            'group' => 'Management'
        ],
        [
            'label' => 'Local Hubs',
            'route' => 'admin.hub.index',
            'icon' => 'truck',
            'group' => 'Logistics'
        ],
        [
            'label' => 'Trade-In Verification',
            'route' => 'admin.hub.index', // Placeholder
            'icon' => 'refresh-cw',
            'group' => 'Logistics'
        ],
    ];

    $groupedLinks = collect($links)->groupBy('group');
@endphp

@foreach($groupedLinks as $group => $items)
    <div class="{{ $attributes->get('group-class') }}">
        <p class="{{ $attributes->get('label-class') }}">{{ $group }}</p>
        <div class="space-y-4">
            @foreach($items as $link)
                <a href="{{ Route::has($link['route']) ? route($link['route']) : '#' }}" 
                   class="{{ $attributes->get('link-class') }} {{ request()->routeIs($link['route']) ? $attributes->get('active-class') : '' }}">
                    @php $iconComponent = "lucide-" . $link['icon']; @endphp
                    <x-dynamic-component :component="$iconComponent" class="{{ $attributes->get('icon-class') }}" />
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>
@endforeach
