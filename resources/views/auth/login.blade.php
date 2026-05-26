<x-layouts.app>
<div class="container mx-auto px-4 py-16">
    <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-sm border border-stone-200">
        <h1 class="text-3xl font-bold mb-2 text-center uppercase tracking-tighter">Welcome Back</h1>
        <p class="text-stone-500 text-center mb-8">Access your impact dashboard and mission history.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-xs font-black uppercase tracking-widest text-stone-400 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-lg focus:ring-black focus:border-black">
                @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-xs font-black uppercase tracking-widest text-stone-400 mb-2">Password</label>
                <input id="password" type="password" name="password" required class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-lg focus:ring-black focus:border-black">
                @error('password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center mb-8">
                <input id="remember" type="checkbox" name="remember" class="rounded border-stone-300 text-black focus:ring-black">
                <label for="remember" class="ml-2 text-sm text-stone-500 font-bold uppercase tracking-widest">Remember me</label>
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 rounded-lg font-black uppercase tracking-widest hover:bg-stone-800 transition shadow-xl">
                Login
            </button>
        </form>

        <div class="mt-8 pt-8 border-t border-stone-100 text-center">
            <p class="text-sm text-stone-500 font-bold uppercase tracking-widest">New to the mission?</p>
            <a href="{{ route('register') }}" class="mt-2 inline-block font-black text-black border-b-2 border-black hover:text-stone-600 hover:border-stone-600 transition">Create Account</a>
        </div>
    </div>
</div>
</x-layouts.app>
