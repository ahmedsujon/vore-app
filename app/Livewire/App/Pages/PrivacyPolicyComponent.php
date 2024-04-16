<?php

namespace App\Livewire\App\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;

class PrivacyPolicyComponent extends Component
{
    #[Title('Privacy Policy')]
    public function render()
    {
        return view('livewire.app.pages.privacy-policy-component')->layout('livewire.app.layouts.base');
    }
}
