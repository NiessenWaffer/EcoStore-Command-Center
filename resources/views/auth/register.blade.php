<x-layouts.app>
<div class="container mx-auto px-4 py-16">
    <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-sm border border-stone-200">
        <h1 class="text-3xl font-bold mb-2 text-center">Join the Mission</h1>
        <p class="text-stone-500 text-center mb-8">Save your impact history and become a brand ambassador.</p>

        @if($token)
            <div class="bg-green-50 p-4 rounded-lg mb-8 border border-green-100 flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm text-green-800 font-medium">Impact History Detected! Register to save it to your permanent profile.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label for="name" class="block text-sm font-bold text-stone-700 mb-1">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-4 py-2 border rounded-lg focus:ring-stone-500 focus:border-stone-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-bold text-stone-700 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-stone-500 focus:border-stone-500">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-bold text-stone-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required class="w-full px-4 py-2 border rounded-lg focus:ring-stone-500 focus:border-stone-500">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8">
                <label for="password_confirmation" class="block text-sm font-bold text-stone-700 mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-4 py-2 border rounded-lg focus:ring-stone-500 focus:border-stone-500">
            </div>

            <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold hover:bg-stone-800 transition duration-300">
                Create Account & Save Impact
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-stone-500">
            Already have an account? <a href="{{ route('login') }}" class="font-bold text-black underline">Log in</a>
        </p>
    </div>
</div>
</x-layouts.app>
