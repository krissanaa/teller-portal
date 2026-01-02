<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\TellerPortal\OnboardingRequest;

class AdminStats extends Component
{
    public $total_pos = 0;
    public $approved = 0;
    public $pending = 0;
    public $rejected = 0;
    public $pending_users = 0;

    public function mount()
    {
        $this->loadStats();
    }

    #[On('echo:admin-channel,NewOnboardingRequest')]
    public function refreshStats()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $user = Auth::user();

        $counts = OnboardingRequest::visibleTo($user)
            ->selectRaw("
                COUNT(*) as total_pos,
                SUM(CASE WHEN approval_status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN approval_status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN approval_status = 'rejected' THEN 1 ELSE 0 END) as rejected
            ")->first();

        $this->total_pos = (int) ($counts->total_pos ?? 0);
        $this->approved  = (int) ($counts->approved ?? 0);
        $this->pending   = (int) ($counts->pending ?? 0);
        $this->rejected  = (int) ($counts->rejected ?? 0);

        // Count pending users
        $this->pending_users = \App\Models\User::where('status', 'pending')->count();
    }

    public function render()
    {
        return view('livewire.admin-stats');
    }
}
