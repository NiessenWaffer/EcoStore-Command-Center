<?php

namespace App\Livewire\Partner;

use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $brand;

    public function mount()
    {
        // For simulation, we assume the user's name matches a brand if they are a partner
        // In production, we'd have a brand_user pivot or user.brand_id
        $this->brand = Brand::where('name', Auth::user()->name)->first() ?? Brand::first();
    }

    public function render()
    {
        return view('livewire.partner.dashboard', [
            'products' => $this->brand ? $this->brand->products()->withCount('passports')->get() : [],
            'totalImpact' => [
                'water' => 25000, // Simulated aggregate
                'carbon' => 120,
            ]
        ]);
    }
}
