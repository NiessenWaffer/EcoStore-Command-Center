@auth
    @if(auth()->user()->is_admin || auth()->user()->id === 1) 
        <div x-data="{ open: false }" class="fixed left-0 top-1/2 -translate-y-1/2 z-[100] group pointer-events-none">
            <!-- Trigger -->
            <button @click="open = !open" class="bg-black text-white p-3 rounded-r-2xl shadow-2xl border-y border-r border-white/10 hover:bg-stone-800 transition-all flex items-center gap-3 pointer-events-auto">
                <x-lucide-shield-check class="w-5 h-5" />
                <span x-show="open" x-transition class="text-[10px] font-black uppercase tracking-widest">Admin Dock</span>
            </button>

            <!-- Sidebar -->
            <div x-show="open" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="absolute left-0 top-12 bg-black text-white w-64 rounded-r-3xl shadow-2xl border border-white/10 p-8 space-y-12 pointer-events-auto"
                 style="display: none;"
                 @click.away="open = false">
                
                <x-nav.admin-links 
                    group-class="space-y-6"
                    label-class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-600 mb-6"
                    link-class="flex items-center gap-4 text-xs font-bold uppercase tracking-widest text-stone-400 hover:text-white transition"
                    active-class="text-white"
                    icon-class="w-4 h-4"
                />

                <div class="pt-6 border-t border-white/10">
                    <p class="text-[10px] text-stone-600 italic leading-tight">Secure session active. Changes are cryptographically signed where applicable.</p>
                </div>
            </div>
        </div>
    @endif
@endauth
