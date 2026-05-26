<x-layouts.app>
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Ambassador Portal</h1>
        <p class="text-stone-500">Share the mission, grow your network, and earn exclusive sustainability rewards.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Referral Link Card -->
        <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-sm border border-stone-100">
            <h3 class="text-xl font-bold mb-6">Your Personal Referral Mission</h3>
            <div class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
                <div class="bg-stone-50 p-4 rounded-xl border border-stone-100">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('referral.mission', ['referral_code' => $user->referral_code])) }}" alt="Referral QR Code" class="w-32 h-32">
                </div>
                <div class="flex-grow w-full">
                    <label class="block text-xs font-bold uppercase tracking-widest text-stone-400 mb-2">Share your mission link</label>
                    <div class="flex">
                        <input type="text" readonly value="{{ route('referral.mission', ['referral_code' => $user->referral_code]) }}" class="flex-grow bg-stone-50 border border-stone-200 rounded-l-lg px-4 py-3 text-sm font-mono text-stone-600 focus:outline-none">
                        <button onclick="navigator.clipboard.writeText('{{ route('referral.mission', ['referral_code' => $user->referral_code]) }}'); alert('Copied!')" class="bg-black text-white px-6 py-3 rounded-r-lg font-bold hover:bg-stone-800 transition">
                            Copy
                        </button>
                    </div>
                    <div class="flex space-x-4 mt-6">
                        <a href="https://twitter.com/intent/tweet?text=Join%20me%20on%20a%20mission%20to%20save%20the%20planet!%20Check%20out%20my%20sustainability%20impact%20at%20EcoStore.&url={{ urlencode(route('referral.mission', ['referral_code' => $user->referral_code])) }}" target="_blank" class="bg-sky-500 text-white p-2 rounded-lg hover:bg-sky-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <!-- Add other social buttons here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Network Impact Card -->
        <div class="bg-stone-900 text-white p-8 rounded-xl shadow-xl">
            <h3 class="text-lg font-bold mb-6">Network Impact</h3>
            <div class="space-y-6">
                <div>
                    <p class="text-stone-400 text-xs uppercase tracking-widest font-bold mb-1">Friends Joined</p>
                    <p class="text-3xl font-black">{{ $user->referrals()->where('status', 'successful')->count() }}</p>
                </div>
                <div>
                    <p class="text-stone-400 text-xs uppercase tracking-widest font-bold mb-1">Network Water Saved</p>
                    <p class="text-3xl font-black text-blue-400">{{ number_format($user->referrals()->where('status', 'successful')->get()->sum(fn($r) => $r->referee->cumulative_water_saved ?? 0)) }}L</p>
                </div>
                <div>
                    <p class="text-stone-400 text-xs uppercase tracking-widest font-bold mb-1">Pending Rewards</p>
                    <p class="text-xl font-bold text-yellow-500">{{ $user->referrals()->where('status', 'pending')->count() }} Missions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Challenges -->
    <h2 class="text-2xl font-bold mb-6">Community Challenges</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($challenges as $challenge)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-stone-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="text-xl font-bold">{{ $challenge->title }}</h4>
                    <p class="text-sm text-stone-500">Goal: {{ number_format($challenge->target_value) }}{{ $challenge->metric_type === 'water' ? 'L Water' : 'kg CO2' }}</p>
                </div>
                <div class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full uppercase">Active</div>
            </div>
            
            <div class="mb-6">
                <div class="flex justify-between text-xs font-bold uppercase text-stone-400 mb-2">
                    <span>Progress</span>
                    <span>{{ $challenge->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-stone-100 h-3 rounded-full overflow-hidden">
                    <div class="bg-green-500 h-full transition-all duration-1000" style="width: {{ $challenge->progress_percentage }}%"></div>
                </div>
            </div>

            <div class="bg-stone-50 p-4 rounded-lg flex justify-between items-center">
                <span class="text-sm text-stone-600 font-medium">Your Contribution:</span>
                <span class="text-lg font-black text-stone-900">{{ app(App\Services\GlobalImpactService::class)->getUserContribution($user, $challenge) }}%</span>
            </div>
        </div>
        @empty
        <p class="text-stone-500">No active challenges at the moment. Stay tuned!</p>
        @endforelse
    </div>
</div>
</x-layouts.app>
