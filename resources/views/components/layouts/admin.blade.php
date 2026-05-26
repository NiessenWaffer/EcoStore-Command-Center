<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Ronie R. Pactol">
        <title>Admin - EcoStore Command Center</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>[x-cloak] { display: none !important; }</style>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>
    <body class="bg-stone-50 text-stone-900 font-sans antialiased" x-data="{ adminMenuOpen: false }">
        <div class="min-h-screen flex flex-col relative z-0">
            <header class="bg-white border-b border-stone-200 py-4 sticky top-0 z-50">
                <div class="container mx-auto px-4 flex justify-between items-center gap-4">
                    <div class="flex items-center gap-4">
                        <button @click="adminMenuOpen = true" class="sm:hidden p-2 -ml-2 text-stone-500 hover:text-stone-900 transition-colors">
                            <x-lucide-menu class="h-6 w-6" />
                        </button>
                        <a href="{{ route('home') }}" class="text-xl md:text-2xl font-black tracking-tighter uppercase shrink-0">EcoStore <span class="text-stone-400 hidden sm:inline">Admin</span></a>
                    </div>
                    
                    <nav class="hidden md:flex flex-1 justify-center items-center space-x-8">
                        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('admin.dashboard') ? 'text-stone-900 border-b-2 border-stone-900' : 'text-stone-400 hover:text-stone-600' }} pb-1 transition-all">Pulse</a>
                        <a href="{{ route('admin.products') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('admin.products') ? 'text-stone-900 border-b-2 border-stone-900' : 'text-stone-400 hover:text-stone-600' }} pb-1 transition-all">Inventory</a>
                        <a href="{{ route('admin.corrections.index') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('admin.corrections.index') ? 'text-stone-900 border-b-2 border-stone-900' : 'text-stone-400 hover:text-stone-600' }} pb-1 transition-all">Trust</a>
                        <a href="{{ route('admin.metrics') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('admin.metrics') ? 'text-stone-900 border-b-2 border-stone-900' : 'text-stone-400 hover:text-stone-600' }} pb-1 transition-all">Metrics</a>
                    </nav>

                    <div class="flex items-center gap-4 shrink-0">
                        <div class="hidden sm:flex flex-col items-right text-right">
                            <span class="text-[10px] font-black uppercase tracking-widest text-stone-900">{{ auth()->user()->name }}</span>
                            <span class="text-[9px] text-stone-400 uppercase tracking-widest">Brand Admin</span>
                        </div>
                        <div class="w-8 h-8 bg-stone-200 rounded-full"></div>
                    </div>
                </div>
            </header>

            <!-- Mobile Admin Navigation Drawer -->
            <div x-show="adminMenuOpen" 
                 x-cloak
                 class="fixed inset-0 z-[100] md:hidden pointer-events-none"
                 style="display: none;">
                
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm pointer-events-auto" @click="adminMenuOpen = false"></div>

                <div x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="relative w-80 h-full bg-stone-900 text-white flex flex-col pointer-events-auto shadow-2xl">
                    
                    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-stone-950">
                        <span class="text-xl font-black uppercase tracking-tighter">Admin Menu</span>
                        <button @click="adminMenuOpen = false" class="p-2 text-stone-400 hover:text-white">
                            <x-lucide-x class="h-6 w-6" />
                        </button>
                    </div>

                    <nav class="flex-1 overflow-y-auto p-8 space-y-12">
                        <div class="space-y-6">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-600">Core Management</p>
                            <div class="space-y-4">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 text-xl font-black uppercase tracking-tight {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-stone-500' }}">
                                    <x-lucide-layout-dashboard class="w-5 h-5" />
                                    Ecosystem Pulse
                                </a>
                                <a href="{{ route('admin.products') }}" class="flex items-center gap-4 text-xl font-black uppercase tracking-tight {{ request()->routeIs('admin.products') ? 'text-white' : 'text-stone-500' }}">
                                    <x-lucide-package class="w-5 h-5" />
                                    Product Inventory
                                </a>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-600">Trust & Integrity</p>
                            <div class="space-y-4">
                                <a href="{{ route('admin.corrections.index') }}" class="flex items-center gap-4 text-lg font-bold {{ request()->routeIs('admin.corrections.index') ? 'text-white' : 'text-stone-400' }}">
                                    <x-lucide-shield-alert class="w-5 h-5" />
                                    Correction Queue
                                </a>
                                <a href="{{ route('admin.metrics') }}" class="flex items-center gap-4 text-lg font-bold {{ request()->routeIs('admin.metrics') ? 'text-white' : 'text-stone-400' }}">
                                    <x-lucide-line-chart class="w-5 h-5" />
                                    Sustainability Metrics
                                </a>
                            </div>
                        </div>
                    </nav>

                    <div class="p-8 border-t border-white/5 bg-stone-950">
                        <a href="{{ route('home') }}" class="flex items-center justify-between w-full bg-white text-black p-4 rounded-xl font-bold uppercase tracking-widest text-xs">
                            Back to Store
                            <x-lucide-external-link class="h-4 w-4" />
                        </a>
                    </div>
                </div>
            </div>

            <main class="flex-grow container mx-auto px-4 py-12 relative z-10">
                {{ $slot }}
            </main>

            <footer class="bg-white border-t border-stone-200 py-6 text-center relative z-10">
                <div class="flex flex-col items-center gap-2">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-stone-400">
                        &copy; {{ date('Y') }} EcoStore Administrative Interface &bull; Cryptographic Integrity Guaranteed
                    </p>
                    <div class="flex items-center gap-2">
                        <span class="text-[8px] font-black uppercase tracking-[0.2em] text-stone-300">Lead Developer</span>
                        <span class="text-[9px] font-black uppercase tracking-[0.2em] text-stone-500">Ronie R. Pactol</span>
                    </div>
                </div>
            </footer>
        </div>
        @livewireScripts
        <x-layouts.admin-dock />
    </body>
</html>
