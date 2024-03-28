<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class UsersComponent extends Component
{
    use WithPagination;
    public $sortingValue = 10, $searchTerm;
    public $edit_id, $delete_id;
    public $name, $email, $gender, $goal, $avatar, $uploadedAvatar, $daily_activity_level,
        $starting_weight, $starting_weight_unit, $current_weight, $current_weight_unit, $target_weight,
        $target_weight_unit, $height, $height_unit, $birth_date;


    public function editData($id)
    {
        $data = User::find($id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->gender = $data->gender;
        $this->goal = $data->goal;
        $this->daily_activity_level = $data->daily_activity_level;
        $this->starting_weight = $data->starting_weight;
        $this->starting_weight_unit = $data->starting_weight_unit;
        $this->current_weight = $data->current_weight;
        $this->target_weight = $data->target_weight;
        $this->current_weight_unit = $data->current_weight_unit;
        $this->target_weight = $data->target_weight;
        $this->target_weight_unit = $data->target_weight_unit;
        $this->height = $data->height;
        $this->height_unit = $data->height_unit;
        $this->birth_date = $data->birth_date;
        $this->uploadedAvatar = $data->avatar;
        $this->edit_id = $data->id;

        $this->dispatch('showEditModal');
    }


    public function close()
    {
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->name = null;
        $this->email = null;
        $this->gender = null;
        $this->goal = null;
        $this->daily_activity_level = null;
        $this->starting_weight = null;
        $this->current_weight = null;
        $this->target_weight_unit = null;
        $this->height = null;
        $this->height_unit = null;
        $this->birth_date = null;
        $this->avatar = null;
        $this->uploadedAvatar = null;
        $this->edit_id = null;
    }


    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show_delete_confirmation');
    }

    public function deleteData()
    {
        $user = User::find($this->delete_id);
        $user->delete();
        $this->dispatch('customer_deleted');
        $this->delete_id = '';
    }

    #[Title('Customer List')]
    public function render()
    {
        $customers = User::where('name', 'like', '%' . $this->searchTerm . '%')->orderBy('id', 'DESC')->paginate($this->sortingValue);
        $this->dispatch('reload_scripts');
        return view('livewire.admin.users.users-component', ['customers' => $customers])->layout('livewire.admin.layouts.base');
    }
}
