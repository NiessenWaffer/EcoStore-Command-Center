<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sustainable Fashion Store</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-stone-50 text-stone-900 font-sans antialiased" x-data="{ mobileMenuOpen: false }">
        <div class="min-h-screen flex flex-col">
            <header class="bg-white border-b border-stone-200 sticky top-0 z-50">
                <div class="container mx-auto px-4 py-4 flex justify-between items-center gap-4 md:gap-8">
                    <div class="flex items-center gap-4">
                        <!-- Hamburger Trigger -->
                        <button @click="mobileMenuOpen = true" class="sm:hidden p-2 -ml-2 text-stone-500 hover:text-stone-900 transition-colors">
                            <x-lucide-menu class="h-6 w-6" />
                        </button>
                        <a href="/" class="text-xl md:text-2xl font-black tracking-tighter text-stone-900 uppercase shrink-0">EcoStore</a>
                    </div>
                    
                    <nav class="hidden md:flex flex-1 items-center space-x-8 text-sm font-bold uppercase tracking-widest text-stone-500">
                        <a href="{{ route('shop') }}" class="hover:text-stone-900 py-2">Shop All</a>
                        
                        <x-nav.mega-menu label="Circularity" :items="[
                            ['title' => 'Resale Portal', 'url' => route('resale.index'), 'icon' => 'refresh-cw', 'description' => 'Trade-in your past items for store credit.'],
                            ['title' => 'Traceability', 'url' => '/passports', 'icon' => 'shield-check', 'description' => 'View unforgeable product passports.'],
                            ['title' => 'Circular Logistics', 'url' => '#', 'icon' => 'truck', 'description' => 'Hyper-local fulfillment centers.'],
                        ]" />

                        <x-nav.mega-menu label="Community" :items="[
                            ['title' => 'Governance', 'url' => route('governance.index'), 'icon' => 'vote', 'description' => 'Vote on brand impact & fund allocation.'],
                            ['title' => 'Ambassador Portal', 'url' => route('referral.mission', ['referral_code' => auth()->user()->referral_code ?? 'join']), 'icon' => 'users', 'description' => 'Grow your network and earn rewards.'],
                            ['title' => 'Our Mission', 'url' => route('mission'), 'icon' => 'globe', 'description' => 'Radical transparency & sustainability.'],
                        ]" />
                    </nav>

                    <div class="flex items-center space-x-2 md:space-x-6 shrink-0">
                        <x-nav.impact-ticker class="hidden sm:block" />

                        <button @click="$dispatch('open-search')" class="p-3 text-stone-500 hover:text-stone-900 transition-colors">
                            <x-lucide-search class="h-5 w-5" />
                        </button>
                        <button @click="$dispatch('open-cart')" class="p-3 text-stone-500 hover:text-stone-900 relative group transition-colors">
                            <x-lucide-shopping-bag class="h-5 w-5" />
                            <span class="absolute top-1 right-1 bg-black text-white text-[9px] font-black h-4 w-4 flex items-center justify-center rounded-full shadow-lg group-hover:scale-110 transition">
                                {{ app(App\Services\CartService::class)->getTotals()['total_items'] }}
                            </span>
                        </button>
                        <a href="{{ route('dashboard') }}" class="p-3 text-stone-500 hover:text-stone-900 transition-colors hidden sm:block">
                            <x-lucide-user class="h-5 w-5" />
                        </a>
                    </div>
                </div>
            </header>

            <main class="flex-grow">
                {{ $slot }}
            </main>

            <livewire:shop.cart-drawer />
            <livewire:shop.ai-stylist />
            <livewire:shop.global-search />

            <!-- Mobile Navigation Drawer -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-0 z-[100] bg-white flex flex-col"
                 style="display: none;">
                
                <div class="p-4 border-b border-stone-100 flex justify-between items-center">
                    <span class="text-xl font-black uppercase tracking-tighter">Menu</span>
                    <button @click="mobileMenuOpen = false" class="p-2 text-stone-500">
                        <x-lucide-x class="h-6 w-6" />
                    </button>
                </div>

                <nav class="flex-1 overflow-y-auto p-8 space-y-12">
                    <div class="space-y-6">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Shop</p>
                        <a href="{{ route('shop') }}" class="block text-2xl font-black uppercase tracking-tight text-stone-900">All Collections</a>
                    </div>

                    <div class="space-y-6">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Circularity</p>
                        <div class="space-y-4">
                            <a href="{{ route('resale.index') }}" class="block text-lg font-bold text-stone-600">Resale Portal</a>
                            <a href="/passports" class="block text-lg font-bold text-stone-600">Traceability</a>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Community</p>
                        <div class="space-y-4">
                            <a href="{{ route('governance.index') }}" class="block text-lg font-bold text-stone-600">Governance</a>
                            <a href="{{ route('mission') }}" class="block text-lg font-bold text-stone-600">Our Mission</a>
                        </div>
                    </div>
                </nav>

                <div class="p-8 border-t border-stone-100 bg-stone-50">
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-between w-full bg-black text-white p-4 rounded-xl font-bold uppercase tracking-widest text-xs">
                        My Account
                        <x-lucide-chevron-right class="h-4 w-4" />
                    </a>
                </div>
            </div>

            <x-layouts.admin-dock />

            <footer class="bg-stone-950 text-stone-400 py-24 border-t border-white/5">
                <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16">
                    <div class="col-span-1 md:col-span-2">
                        <h2 class="text-2xl font-black text-white mb-6 uppercase tracking-tighter">EcoStore</h2>
                        <p class="max-w-md text-stone-500 leading-relaxed mb-8">
                            Radically transparent apparel for the conscious generation. We believe every garment should tell its own story of impact—verified, unforgeable, and community-led.
                        </p>
                        <div class="flex items-center gap-6">
                            <span class="text-xs font-black uppercase tracking-widest text-stone-700">Follow the Impact</span>
                            <!-- Social Icons could go here -->
                        </div>
                    </div>
                    <div>
                        <h3 class="text-white font-bold uppercase tracking-widest text-xs mb-8">Ecosystem</h3>
                        <ul class="space-y-4 text-xs font-bold uppercase tracking-[0.15em]">
                            <li><a href="{{ route('shop') }}" class="hover:text-white transition">Shop Full Collection</a></li>
                            <li><a href="{{ route('resale.index') }}" class="hover:text-white transition">Resale & Trade-In</a></li>
                            <li><a href="{{ route('governance.index') }}" class="hover:text-white transition">Community Governance</a></li>
                            <li><a href="/passports" class="hover:text-white transition">Product Traceability</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-bold uppercase tracking-widest text-xs mb-8">Customer Care</h3>
                        <ul class="space-y-4 text-xs font-bold uppercase tracking-[0.15em]">
                            <li><a href="#" class="hover:text-white transition">Delivery Tracking</a></li>
                            <li><a href="{{ route('return.deterrent') }}" class="hover:text-white transition">Initiate Return</a></li>
                            <li><a href="{{ route('fit.wizard') }}" class="hover:text-white transition">Fit Finder</a></li>
                            <li><a href="{{ route('mission') }}" class="hover:text-white transition">Sustainability Grade</a></li>
                        </ul>
                    </div>
                </div>
                <div class="container mx-auto px-4 mt-24 pt-8 border-t border-white/5 text-[10px] font-bold uppercase tracking-[0.2em] text-stone-700 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex flex-col md:flex-row items-center gap-4">
                        <p>&copy; {{ date('Y') }} EcoStore Inc. All Rights Reserved.</p>
                        <span class="hidden md:inline text-stone-900">•</span>
                        <p class="text-stone-800 opacity-30 hover:opacity-100 transition-opacity cursor-default uppercase">Created by Ronie R. Pactol</p>
                    </div>
                    <p class="text-stone-500">Built for a cooler planet.</p>
                </div>
            </footer>
        </div>
        @livewireScripts
    </body>
</html>
