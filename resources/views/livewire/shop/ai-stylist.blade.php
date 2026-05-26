<?php

use Livewire\Volt\Component;
use App\Services\AIShstylistService;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $message = '';
    public $chatHistory = [];
    public $isTyping = false;

    public function mount()
    {
        $this->chatHistory[] = [
            'role' => 'assistant',
            'content' => "Hello! I'm your Sustainability Concierge. How can I help you build a more ethical wardrobe today?"
        ];
    }

    public function sendMessage(AIShstylistService $aiService)
    {
        if (empty(trim($this->message))) return;

        $userMessage = $this->message;
        $this->chatHistory[] = ['role' => 'user', 'content' => $userMessage];
        $this->message = '';
        $this->isTyping = true;

        // Note: In a real gpt-4o integration, we'd use a background job or stream.
        // For MVP, we'll do a direct call.
        $response = $aiService->getRecommendation($userMessage, Auth::user());
        
        $this->chatHistory[] = ['role' => 'assistant', 'content' => $response];
        $this->isTyping = false;
    }
};
?>

<div class="fixed bottom-8 right-8 z-[60]" x-data="{ open: false }">
    <!-- Chat Toggle Button -->
    <button @click="open = !open" class="bg-black text-white w-16 h-16 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition transform active:scale-95">
        <svg x-show="!open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        <svg x-show="open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <!-- Chat Window -->
    <div x-show="open" x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         class="absolute bottom-20 right-0 w-[400px] max-w-[90vw] h-[600px] bg-white rounded-3xl shadow-2xl border border-stone-100 flex flex-col overflow-hidden">
        
        <!-- Header -->
        <div class="bg-stone-900 p-6 text-white">
            <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <h3 class="font-black uppercase tracking-tighter text-lg">Sustainability Concierge</h3>
            </div>
            <p class="text-stone-400 text-xs mt-1 uppercase tracking-widest font-bold">AI Stylist Online</p>
        </div>

        <!-- Messages -->
        <div class="flex-grow overflow-y-auto p-6 space-y-6 bg-stone-50" id="chat-messages">
            @foreach($chatHistory as $msg)
            <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[85%] p-4 rounded-2xl text-sm leading-relaxed {{ $msg['role'] === 'user' ? 'bg-black text-white rounded-tr-none' : 'bg-white text-stone-800 border border-stone-200 rounded-tl-none shadow-sm' }}">
                    {!! nl2br(e($msg['content'])) !!}
                </div>
            </div>
            @endforeach

            @if($isTyping)
            <div class="flex justify-start">
                <div class="bg-white border border-stone-200 p-4 rounded-2xl rounded-tl-none shadow-sm">
                    <div class="flex space-x-1">
                        <div class="w-1.5 h-1.5 bg-stone-300 rounded-full animate-bounce"></div>
                        <div class="w-1.5 h-1.5 bg-stone-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-1.5 h-1.5 bg-stone-300 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Input -->
        <div class="p-6 bg-white border-t border-stone-100">
            <form wire:submit.prevent="sendMessage" class="relative">
                <input type="text" wire:model="message" placeholder="Ask about fit, style, or impact..." 
                       class="w-full bg-stone-50 border-stone-200 rounded-xl px-4 py-4 pr-12 text-sm focus:ring-black focus:border-black transition">
                <button type="submit" class="absolute right-2 top-2 bottom-2 px-4 text-stone-400 hover:text-black transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            <p class="text-[10px] text-stone-400 mt-4 text-center uppercase tracking-widest font-bold">Powered by Eco-Styling AI</p>
        </div>
    </div>
</div>
