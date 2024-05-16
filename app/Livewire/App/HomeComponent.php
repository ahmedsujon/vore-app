<?php

namespace App\Livewire\App;

use Livewire\Component;
use Livewire\Attributes\Title;

class HomeComponent extends Component
{
    #[Title('Vore - Home')]
    public function render()
    {
        return view('livewire.app.home-component')->layout('livewire.app.layouts.base');
    }
}
