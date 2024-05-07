<?php

namespace App\Livewire\App\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;

class AboutComponent extends Component
{
    #[Title('Vore - About Us')]
    public function render()
    {
        return view('livewire.app.pages.about-component')->layout('livewire.app.layouts.base');
    }
}
