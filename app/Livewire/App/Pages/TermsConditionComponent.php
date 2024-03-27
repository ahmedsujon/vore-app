<?php

namespace App\Livewire\App\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;

class TermsConditionComponent extends Component
{
    #[Title('Terms and Conditions')]
    public function render()
    {
        return view('livewire.app.pages.terms-condition-component')->layout('livewire.app.layouts.base');
    }
}
