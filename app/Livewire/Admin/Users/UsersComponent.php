<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\Attributes\Title;

class UsersComponent extends Component
{
    #[Title('USer List')]
    public function render()
    {
        return view('livewire.admin.users.users-component')->layout('livewire.admin.layouts.base');
    }
}
