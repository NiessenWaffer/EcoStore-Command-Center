<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommandCenter extends Component
{
    public $activeTab = 'overview';
    public $user;

    protected $queryString = ['activeTab'];

    public function mount($tab = 'overview')
    {
        $this->user = Auth::user();
        $this->activeTab = $tab;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.dashboard.command-center', [
            'orders' => $this->user->orders()->latest()->get(),
            'challenges' => \App\Models\CommunityChallenge::where('is_active', true)->get(),
        ]);
    }
}
