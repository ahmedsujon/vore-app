<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;

class DashboardComponent extends Component
{
    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.admin.dashboard-component')->layout('livewire.admin.layouts.base');
    }
}
