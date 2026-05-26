@props(['event'])

<div x-data="{ open: false }" class="inline-block">
    <button @click="open = true" class="p-2 bg-gray-50 rounded border border-gray-100 flex items-center justify-between group cursor-pointer hover:bg-gray-100 transition-colors w-full">
        <div class="flex flex-col text-left">
            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-tight">Cryptographic Hash</span>
            <code class="text-[11px] text-gray-600 font-mono truncate max-w-[150px]">{{ $event['hash'] }}</code>
        </div>
        <x-lucide-external-link class="w-3 h-3 text-gray-300 group-hover:text-green-500 ml-2" />
    </button>

    <!-- Modal -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div @click="open = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <x-lucide-shield-check class="h-6 w-6 text-green-600" />
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                            Technical Verification Details
                        </h3>
                        <div class="mt-4 text-left space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Event Type</label>
                                <p class="text-sm font-semibold text-gray-800">{{ $event['type'] }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">SHA-256 Hash</label>
                                <div class="mt-1 p-3 bg-gray-900 rounded-md">
                                    <code class="text-xs text-green-400 font-mono break-all">{{ $event['hash'] }}</code>
                                </div>
                            </div>
                            @if(isset($event['signature']))
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Digital Signature</label>
                                <div class="mt-1 p-3 bg-gray-900 rounded-md">
                                    <code class="text-xs text-amber-400 font-mono break-all">{{ $event['signature'] }}</code>
                                </div>
                                <p class="mt-1 text-[10px] text-gray-500 italic">Signed by authorized brand auditor via OpenSSL.</p>
                            </div>
                            @endif
                            <div class="p-3 bg-blue-50 border border-blue-100 rounded-md flex gap-3">
                                <x-lucide-info class="w-5 h-5 text-blue-500 shrink-0" />
                                <p class="text-[11px] text-blue-700 leading-normal">
                                    This hash is recursively generated using the previous event's hash, ensuring the entire product history is immutable. Any change to past data would invalidate this signature.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button @click="open = false" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm transition-colors">
                        Close Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
