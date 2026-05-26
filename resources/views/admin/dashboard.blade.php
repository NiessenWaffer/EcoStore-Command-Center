<x-layouts.admin>
    <div x-data="{ activeTab: 'system' }">
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <h2 class="text-4xl font-black uppercase tracking-tighter text-stone-900">Ecosystem Pulse</h2>
            <p class="text-stone-500 mt-2">Real-time visibility into sustainability impact, system integrity, and partner brands.</p>
        </div>
        <div class="flex bg-stone-100 p-1.5 rounded-xl gap-1">
            <button @click="activeTab = 'system'" :class="activeTab === 'system' ? 'bg-white shadow-sm text-stone-900' : 'text-stone-400 hover:text-stone-600'" class="px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest transition">System</button>
            <button @click="activeTab = 'partners'" :class="activeTab === 'partners' ? 'bg-white shadow-sm text-stone-900' : 'text-stone-400 hover:text-stone-600'" class="px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest transition">Partners</button>
        </div>
    </div>

    <div x-show="activeTab === 'system'" x-cloak>
        <!-- KPI Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
            <livewire:admin.dashboard-stats />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Trust Alert Feed -->
            <div class="lg:col-span-2 space-y-8">
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <x-lucide-shield-alert class="w-6 h-6 text-amber-500" />
                            Trust & Integrity Alerts
                        </h3>
                        <a href="{{ route('admin.corrections.index') }}" class="text-xs font-bold uppercase tracking-widest text-stone-400 hover:text-stone-900 transition">View All Queue</a>
                    </div>
                    
                    <livewire:admin.trust-alert-feed />
                </section>

                <section>
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <x-lucide-activity class="w-6 h-6 text-stone-400" />
                        Recent Activity
                    </h3>
                    
                    <!-- Desktop Table -->
                    <div class="hidden md:block bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-stone-100">
                                @foreach(\App\Models\AdminActivityLog::latest()->take(5)->get() as $log)
                                    <tr class="hover:bg-stone-50 transition-colors">
                                        <td class="px-8 py-4">
                                            <p class="text-sm font-bold text-stone-900">{{ $log->action }}</p>
                                            <p class="text-[10px] text-stone-500 uppercase tracking-widest">{{ $log->timestamp->diffForHumans() }}</p>
                                        </td>
                                        <td class="px-8 py-4 text-xs text-stone-600">
                                            {{ $log->description }}
                                        </td>
                                        <td class="px-8 py-4 text-right">
                                            <x-lucide-chevron-right class="w-4 h-4 text-stone-300 ml-auto" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Activity Card List -->
                    <div class="md:hidden space-y-4">
                        @foreach(\App\Models\AdminActivityLog::latest()->take(5)->get() as $log)
                            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-sm font-bold text-stone-900">{{ $log->action }}</p>
                                    <span class="text-[9px] text-stone-400 font-bold uppercase tracking-widest">{{ $log->timestamp->diffForHumans(null, true) }}</span>
                                </div>
                                <p class="text-xs text-stone-500 leading-relaxed">{{ $log->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <!-- Sidebar Actions (Desktop) -->
            <div class="hidden lg:block space-y-8">
                <div class="bg-stone-900 text-white p-8 rounded-3xl shadow-xl">
                    <h3 class="text-lg font-bold mb-6">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.products.create') }}" class="flex items-center justify-between p-4 bg-white/5 rounded-xl hover:bg-white/10 transition group">
                            <span class="text-sm font-bold uppercase tracking-widest">Add New Product</span>
                            <x-lucide-plus class="w-4 h-4 text-stone-500 group-hover:text-white transition" />
                        </a>
                        <a href="#" class="flex items-center justify-between p-4 bg-white/5 rounded-xl hover:bg-white/10 transition group">
                            <span class="text-sm font-bold uppercase tracking-widest">Launch Proposal</span>
                            <x-lucide-megaphone class="w-4 h-4 text-stone-500 group-hover:text-white transition" />
                        </a>
                        <a href="{{ route('admin.corrections.index') }}" class="flex items-center justify-between p-4 bg-white/5 rounded-xl hover:bg-white/10 transition group">
                            <span class="text-sm font-bold uppercase tracking-widest">Review Corrections</span>
                            <x-lucide-clipboard-check class="w-4 h-4 text-stone-500 group-hover:text-white transition" />
                        </a>
                        <a href="#" class="flex items-center justify-between p-4 bg-white/5 rounded-xl hover:bg-white/10 transition group border border-white/20">
                            <span class="text-sm font-black uppercase tracking-widest text-emerald-400 group-hover:text-emerald-300">Scan Return</span>
                            <x-lucide-scan-line class="w-4 h-4 text-emerald-500 group-hover:text-emerald-400 transition" />
                        </a>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-stone-200 shadow-sm">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-stone-400 mb-6">Infrastructure Status</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-600">Database Cluster</span>
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-600">Redis Cache</span>
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-600">Blockchain Node</span>
                            <span class="w-2 h-2 bg-stone-200 rounded-full"></span>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-stone-100 mt-6 flex flex-col items-center text-center">
                        <x-lucide-award class="w-8 h-8 text-stone-100 mb-2" />
                        <p class="text-[8px] font-black uppercase tracking-[0.2em] text-stone-300 mb-1">Project Architect</p>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-900">Ronie R. Pactol</p>
                    </div>
                </div>

                <!-- Return Scanner Widget -->
                <livewire:admin.lease-return-scanner />

                <!-- IPFS Sync Manager -->
                <livewire:admin.ipfs-sync-manager />
            </div>
        </div>
    </div>

    <div x-show="activeTab === 'partners'" x-cloak>
        <div class="mb-8">
            <h3 class="text-xl font-bold flex items-center gap-2">
                <x-lucide-building-2 class="w-6 h-6 text-emerald-500" />
                Partner Brand Management
            </h3>
            <p class="text-stone-500 text-sm mt-1">Onboard and verify external sustainable brands.</p>
        </div>
        
        <livewire:admin.partner-manager />
    </div>
    </div>

    <!-- Mobile Floating Action Button -->
    <div x-data="{ fabOpen: false }" class="md:hidden fixed bottom-8 right-8 z-50 pointer-events-none">
        <div x-show="fabOpen" x-cloak x-transition class="absolute bottom-20 right-0 space-y-4 mb-4 min-w-[200px] pointer-events-auto" style="display: none;">
            <a href="{{ route('admin.products.create') }}" class="flex items-center justify-end gap-3 group">
                <span class="bg-stone-900 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-xl">Add Product</span>
                <div class="bg-stone-900 text-white p-3 rounded-full shadow-xl"><x-lucide-package class="w-4 h-4" /></div>
            </a>
            <a href="{{ route('admin.corrections.index') }}" class="flex items-center justify-end gap-3 group">
                <span class="bg-stone-900 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-xl">Trust Alerts</span>
                <div class="bg-stone-900 text-white p-3 rounded-full shadow-xl"><x-lucide-shield-alert class="w-4 h-4" /></div>
            </a>
        </div>
        <button @click="fabOpen = !fabOpen" class="bg-stone-900 text-white w-16 h-16 rounded-full shadow-2xl flex items-center justify-center active:scale-90 transition-transform pointer-events-auto">
            <x-lucide-plus x-show="!fabOpen" class="w-8 h-8" />
            <x-lucide-x x-show="fabOpen" class="w-8 h-8" />
        </button>
    </div>
</x-layouts.admin>
