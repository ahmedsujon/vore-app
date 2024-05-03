<?php

namespace App\Livewire\App\Pages;

use Livewire\Component;

class AboutComponent extends Component
{
    public function render()
    {
        return view('livewire.app.pages.about-component')->layout('livewire.app.layouts.base');
    }
}
