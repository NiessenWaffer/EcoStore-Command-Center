<x-layouts.app>
<div class="bg-stone-50 min-h-screen py-16">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center p-3 bg-green-100 rounded-full mb-4">
                <x-lucide-check-circle class="w-8 h-8 text-green-600" />
            </div>
            <h1 class="text-4xl font-black uppercase tracking-tighter text-stone-900">Verify Your Ownership</h1>
            <p class="text-stone-500 mt-2">Review the digital provenance of this item before claiming your passport.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-stone-100 overflow-hidden mb-8">
            <div class="p-8 border-b border-stone-100 bg-stone-50/50">
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 bg-stone-200 rounded-2xl overflow-hidden flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=300&q=80" alt="Product Thumbnail" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="bg-stone-200 text-stone-600 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest rounded">Claiming Item</span>
                        <h2 class="text-2xl font-black text-stone-900 uppercase tracking-tight mt-1">Organic Cotton Essential Tee</h2>
                        <p class="text-stone-500 text-sm">Batch: #TRANS-992-X</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <x-lucide-scroll-text class="w-5 h-5 text-stone-400" />
                    Immutable History
                </h3>
                
                <!-- Reusing the verification timeline (Mocked data in Volt component) -->
                {{-- <livewire:passports.verification-timeline :passport="$passport" /> --}}
                <div class="space-y-6 opacity-60 pointer-events-none">
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <div class="w-0.5 h-full bg-stone-200"></div>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Product Created</p>
                            <p class="text-xs text-stone-400">May 12, 2026</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <div class="w-0.5 h-full bg-stone-200"></div>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Quality Inspected</p>
                            <p class="text-xs text-stone-400">May 14, 2026</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 p-6 bg-stone-900 text-white rounded-2xl">
                    <div class="flex items-start gap-4 mb-6">
                        <x-lucide-info class="w-6 h-6 text-blue-400 flex-shrink-0" />
                        <p class="text-sm text-stone-300">
                            By claiming this passport, you become the legal digital owner of this item. Your ownership will be permanently recorded in the immutable audit log.
                        </p>
                    </div>
                    
                    <livewire:passports.claim-form />
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-stone-400 hover:text-stone-600 text-sm font-medium">
                Cancel and return home
            </a>
        </div>
    </div>
</div>
</x-layouts.app>
