<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;

class ForgotPasswordComponent extends Component
{
    #[Title('Forget Password')]
    public function render()
    {
        return view('livewire.admin.auth.forgot-password-component')->layout('livewire.admin.auth.layouts.base');
    }
}
