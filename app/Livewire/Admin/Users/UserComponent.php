<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    public $sortingValue = 10, $searchTerm;
    public $edit_id, $delete_id;
    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->searchTerm . '%')->orderBy('id', 'DESC')->paginate($this->sortingValue);
        return view('livewire.admin.users.user-component', ['users'=>$users])->layout('livewire.admin.layouts.base');
    }
}
