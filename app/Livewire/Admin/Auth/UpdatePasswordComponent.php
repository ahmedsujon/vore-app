<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;

class UpdatePasswordComponent extends Component
{
    #[Title('Update Password')]
    public function render()
    {
        return view('livewire.admin.auth.update-password-component')->layout('livewire.admin.auth.layouts.base');
    }
}
