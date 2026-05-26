<x-layouts.admin>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black uppercase tracking-tighter">Correction Queue</h2>
            <p class="text-stone-500">Review and approve sensitive history corrections for Product Passports.</p>
        </div>
        <div class="flex gap-4">
            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2">
                <x-lucide-shield-alert class="w-4 h-4" />
                Multi-Sig Required
            </span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-stone-50 border-b border-stone-200">
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-stone-400">Proposal ID</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-stone-400">Target Passport</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-stone-400">Proposed Change</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-stone-400">Proposer</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-stone-400">Approvals</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-stone-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                <!-- Sample Row 1 -->
                <tr>
                    <td class="px-6 py-4 font-mono text-xs text-stone-500">#CORR-8821</td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-stone-900">Batch: #992-X</p>
                        <p class="text-[10px] text-stone-400">Cotton Essential Tee</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-red-500 line-through">42.5 kg CO2</span>
                            <x-lucide-arrow-right class="w-3 h-3 text-stone-300" />
                            <span class="text-green-600 font-bold">12.5 kg CO2</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-stone-600">Admin_Sarah</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-1">
                            <div class="w-2 h-2 bg-green-500 rounded-full" title="Proposer Approved"></div>
                            <div class="w-2 h-2 bg-stone-200 rounded-full" title="Awaiting 2nd Signature"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="bg-stone-900 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-stone-800 transition">
                            Review & Sign
                        </button>
                    </td>
                </tr>
                <!-- Sample Row 2 -->
                <tr>
                    <td class="px-6 py-4 font-mono text-xs text-stone-500">#CORR-9012</td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-stone-900">Batch: #881-Z</p>
                        <p class="text-[10px] text-stone-400">Denim Jacket</p>
                    </td>
                    <td class="px-6 py-4 text-xs text-stone-600">
                        Correction of Factory ID (Factory A -> Factory B)
                    </td>
                    <td class="px-6 py-4 text-sm text-stone-600">System_Bot</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-1">
                            <div class="w-2 h-2 bg-stone-200 rounded-full" title="Awaiting 1st Signature"></div>
                            <div class="w-2 h-2 bg-stone-200 rounded-full" title="Awaiting 2nd Signature"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="bg-stone-900 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-stone-800 transition">
                            Review & Sign
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="p-6 bg-stone-50 border-t border-stone-100 text-center">
            <p class="text-xs text-stone-400 italic">Only Super Admins or assigned Reviewers can finalize high-impact corrections.</p>
        </div>
    </div>
</x-layouts.admin>
