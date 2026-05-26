<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;

class PartnerManager extends Component
{
    public function toggleVerification($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        $brand->update(['is_verified' => !$brand->is_verified]);
        
        \App\Models\AdminActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Brand Verification Updated',
            'description' => "Updated verification for {$brand->name}. Now: " . ($brand->is_verified ? 'Verified' : 'Unverified'),
        ]);

        session()->flash('message', "Status updated for {$brand->name}.");
    }

    public function generateToken($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        $token = bin2hex(random_bytes(32));
        $brand->update(['api_token' => hash('sha256', $token)]);

        session()->flash('message', "New API Token generated for {$brand->name}. (Cleartext: {$token})");
    }

    public function render()
    {
        return view('livewire.admin.partner-manager', [
            'brands' => Brand::latest()->get(),
        ]);
    }
}
