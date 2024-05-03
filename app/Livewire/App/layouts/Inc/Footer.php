<?php

namespace App\Livewire\App\Layouts\Inc;

use Livewire\Component;

class Footer extends Component
{
    public $subscription;
    
    public function render()
    {
        return view('livewire.app.layouts.inc.footer');
    }
}
