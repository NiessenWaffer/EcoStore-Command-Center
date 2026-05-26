<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12" x-data="{ mobileTabsOpen: false }">
    <!-- Mobile Tab Navigation (Horizontal Scroll) -->
    <div class="md:hidden mb-8 -mx-4 px-4 overflow-x-auto no-scrollbar border-b border-stone-100 bg-white/80 backdrop-blur-md sticky top-16 z-30">
        <div class="flex space-x-8 min-w-max">
            @foreach(['overview' => 'layout-grid', 'orders' => 'shopping-bag', 'impact' => 'droplets', 'resale' => 'refresh-cw', 'governance' => 'vote', 'ambassador' => 'users', 'fit' => 'ruler'] as $tab => $icon)
                <button 
                    wire:click="setTab('{{ $tab }}')" 
                    class="flex items-center gap-2 py-4 border-b-2 transition-all {{ $activeTab === $tab ? 'border-black text-black' : 'border-transparent text-stone-400' }}"
                >
                    <x-dynamic-component :component="'lucide-'.$icon" class="w-4 h-4" />
                    <span class="text-[10px] font-black uppercase tracking-widest">{{ $tab }}</span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-12">
        <!-- Sidebar Navigation (Desktop) -->
        <aside class="hidden md:block w-full md:w-64 shrink-0">
            <div class="sticky top-28 space-y-1">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 mb-6 px-4">Command Center</p>
                
                @foreach(['overview' => ['icon' => 'layout-grid', 'label' => 'Overview'], 'orders' => ['icon' => 'shopping-bag', 'label' => 'My Orders'], 'impact' => ['icon' => 'droplets', 'label' => 'Eco Impact'], 'resale' => ['icon' => 'refresh-cw', 'label' => 'My Resales'], 'governance' => ['icon' => 'vote', 'label' => 'Governance'], 'ambassador' => ['icon' => 'users', 'label' => 'Ambassador'], 'fit' => ['icon' => 'ruler', 'label' => 'Fit Profile']] as $tab => $data)
                    <button wire:click="setTab('{{ $tab }}')" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ $activeTab === $tab ? 'bg-stone-900 text-white shadow-xl' : 'text-stone-500 hover:bg-stone-100' }}">
                        <x-dynamic-component :component="'lucide-'.$data['icon']" class="w-4 h-4" />
                        <span class="text-xs font-bold uppercase tracking-widest">{{ $data['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0">
            @if($activeTab === 'overview')
                <div class="space-y-8 md:space-y-12">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                        <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tighter text-stone-900">Welcome Back, <span class="text-stone-400">{{ $user->name }}</span></h2>
                        <div class="bg-stone-100 px-4 py-2 rounded-lg border border-stone-200 text-[10px] font-black uppercase tracking-widest text-stone-600">
                            Tier: {{ $user->eco_tier }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                        <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
                            <p class="text-[10px] font-black uppercase tracking-widest text-stone-400 mb-2">Total Water Saved</p>
                            <p class="text-3xl md:text-4xl font-black text-blue-600">{{ number_format($user->cumulative_water_saved) }}L</p>
                        </div>
                        <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
                            <p class="text-[10px] font-black uppercase tracking-widest text-stone-400 mb-2">Total Carbon Reduced</p>
                            <p class="text-3xl md:text-4xl font-black text-green-600">{{ number_format($user->cumulative_carbon_reduced, 1) }}kg</p>
                        </div>
                        <div class="bg-stone-900 p-8 rounded-3xl shadow-xl">
                            <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-2">Governance Power</p>
                            <p class="text-3xl md:text-4xl font-black text-white">{{ number_format(floor($user->cumulative_water_saved / 100)) }} <span class="text-xs uppercase text-stone-600 ml-1">Votes</span></p>
                        </div>
                    </div>

                    <div class="bg-stone-50 p-6 md:p-8 rounded-3xl border border-stone-100">
                        <h3 class="font-bold text-stone-900 mb-6">Recent Activity</h3>
                        <p class="text-sm text-stone-400 italic">No recent activities to display.</p>
                    </div>
                </div>
            @endif

            @if($activeTab === 'leases')
                <div class="space-y-8">
                    <h2 class="text-3xl font-black uppercase tracking-tighter text-stone-900">Active Leases</h2>
                    
                    <div class="bg-white rounded-3xl border border-stone-100 shadow-sm overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-stone-50 text-[10px] font-black uppercase tracking-widest text-stone-400 border-b border-stone-100">
                                <tr>
                                    <th class="px-8 py-4">Item</th>
                                    <th class="px-8 py-4">Status</th>
                                    <th class="px-8 py-4">Next Billing</th>
                                    <th class="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-50">
                                <!-- Placeholder until backend implementation -->
                                <tr class="text-sm font-medium">
                                    <td class="px-8 py-6 text-stone-900">Organic Cotton Jacket</td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border bg-green-50 text-green-700 border-green-100">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-stone-500">Oct 1, 2026 ($15.00)</td>
                                    <td class="px-8 py-6 text-right">
                                        <button class="bg-stone-900 text-white px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-stone-800 transition">Initiate Return</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if($activeTab === 'orders')
                <div class="space-y-8">
                    <h2 class="text-3xl font-black uppercase tracking-tighter text-stone-900">My Orders</h2>
                    
                    <!-- Desktop Table -->
                    <div class="hidden md:block bg-white rounded-3xl border border-stone-100 shadow-sm overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-stone-50 text-[10px] font-black uppercase tracking-widest text-stone-400 border-b border-stone-100">
                                <tr>
                                    <th class="px-8 py-4">Order</th>
                                    <th class="px-8 py-4">Date</th>
                                    <th class="px-8 py-4">Status</th>
                                    <th class="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-50">
                                @foreach($orders as $order)
                                    <tr class="text-sm font-medium">
                                        <td class="px-8 py-6 text-stone-900">#{{ $order->id }}</td>
                                        <td class="px-8 py-6 text-stone-500">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-8 py-6">
                                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $order->status === 'completed' ? 'bg-green-50 text-green-700 border-green-100' : 'bg-stone-50 text-stone-600 border-stone-100' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <a href="#" class="text-xs font-black uppercase tracking-widest text-stone-400 hover:text-stone-900 transition-colors">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="md:hidden space-y-4">
                        @foreach($orders as $order)
                            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-sm flex justify-between items-center">
                                <div>
                                    <p class="text-xs font-bold text-stone-900">Order #{{ $order->id }}</p>
                                    <p class="text-[10px] text-stone-400 uppercase tracking-widest mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase border {{ $order->status === 'completed' ? 'bg-green-50 text-green-700 border-green-100' : 'bg-stone-50 text-stone-600 border-stone-100' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($activeTab === 'governance')
                <livewire:governance.hub />
            @endif

            @if($activeTab === 'impact')
                <div class="space-y-12">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tighter text-stone-900 leading-none">Impact Pulse</h2>
                            <p class="text-stone-500 mt-2 text-sm">A verified record of your contribution to a cooler planet.</p>
                        </div>
                        <a href="{{ route('dashboard.certificate') }}" class="w-full md:w-auto bg-black text-white px-6 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-stone-800 transition shadow-lg inline-flex items-center justify-center gap-2">
                            <x-lucide-award class="w-4 h-4" />
                            Generate Certificate
                        </a>
                    </div>

                    <livewire:dashboard.impact-timeline />

                    <section>
                        <h3 class="text-xl font-bold text-stone-900 mb-8 flex items-center gap-3">
                            <x-lucide-trophy class="w-6 h-6 text-amber-500" />
                            Milestones
                        </h3>
                        <livewire:dashboard.milestone-badges />
                    </section>
                </div>
            @endif

            @if($activeTab === 'resale')
                <div class="bg-stone-50 p-8 md:p-12 rounded-3xl border border-stone-100 text-center">
                    <x-lucide-refresh-cw class="w-12 h-12 text-stone-300 mx-auto mb-6" />
                    <h3 class="text-2xl font-bold text-stone-900 mb-4 uppercase tracking-tighter">Circular Lifecycle</h3>
                    <p class="text-stone-500 max-w-sm mx-auto mb-8 text-sm">Ready to cycle your style? Trade-in verified past items for store credit and help us build a 100% circular economy.</p>
                    <a href="{{ route('resale.index') }}" class="inline-block bg-black text-white px-8 py-4 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-stone-800 transition shadow-xl">Go to Resale Portal</a>
                </div>
            @endif

            @if($activeTab === 'ambassador')
                <div class="space-y-8 md:space-y-12">
                    <h2 class="text-3xl font-black uppercase tracking-tighter text-stone-900">Ambassador Portal</h2>
                    <div class="bg-white p-8 md:p-10 rounded-3xl border border-stone-100 shadow-sm">
                        <p class="text-stone-500 text-sm mb-8 leading-relaxed">Share your unique mission link with friends. Every new member you bring into the ecosystem increases our collective impact and earns you exclusive rewards.</p>
                        <div class="flex flex-col sm:flex-row items-center gap-4 bg-stone-50 p-4 rounded-2xl border border-stone-100">
                            <code class="flex-1 text-xs md:text-sm font-mono text-stone-600 break-all">{{ route('referral.mission', ['referral_code' => $user->referral_code]) }}</code>
                            <button class="w-full sm:w-auto bg-stone-900 text-white px-6 py-2 rounded-xl text-xs font-bold uppercase tracking-widest active:scale-95 transition-transform">Copy</button>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>
