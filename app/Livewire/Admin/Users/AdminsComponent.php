<?php

namespace App\Livewire\Admin\Users;

use Carbon\Carbon;
use App\Models\Admin;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class AdminsComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $sortingValue = 10, $searchTerm;
    public $edit_id, $delete_id;
    public $name, $email, $phone, $password, $avatar, $uploadedAvatar, $permissions = [];

    public function storeData()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:8|max:25',
        ]);

        $data = new Admin();
        $data->added_by = admin()->id;
        $data->name = $this->name;
        $data->email = $this->email;
        $data->phone = $this->phone;
        $data->password = Hash::make($this->password);
        $data->type = 'admin';
        $data->permissions = json_encode($this->permissions);

        if ($this->avatar) {
            $fileName = uniqid() . Carbon::now()->timestamp . '.' . $this->avatar->extension();
            $this->avatar->storeAs('profile_images', $fileName);
            $data->avatar = 'uploads/profile_images/' . $fileName;
        } else {
            $data->avatar = 'assets/images/placeholder.jpg';
        }

        $data->save();
        $this->dispatch('closeModal');
        $this->dispatch('success', ['message' => 'New admin added successfully']);
        $this->resetInputs();
    }

    public function editData($id)
    {
        $data = Admin::find($id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->uploadedAvatar = $data->avatar;
        $this->permissions = json_decode($data->permissions);
        $this->edit_id = $data->id;

        $this->dispatch('showEditModal');
    }

    public function updateData()
    {
        if ($this->password) {
            $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'password' => 'min:8|max:25',
            ]);
        } else {
            $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric',
            ]);
        }

        $user = Admin::find($this->edit_id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->permissions = json_encode($this->permissions);

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }
        if ($this->avatar) {
            $imageName = Carbon::now()->timestamp . '_favicon' . $this->avatar->extension();
            $this->avatar->storeAs('profile_images', $imageName);
            $user->avatar = 'uploads/profile_images/' . $imageName;
        }
        $user->save();

        $this->dispatch('closeModal');
        $this->dispatch('success', ['message' => 'Admin updated successfully']);
        $this->resetInputs();
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->password = null;
        $this->avatar = null;
        $this->uploadedAvatar = null;
        $this->permissions = [];
        $this->edit_id = null;
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show_delete_confirmation');
    }

    public function deleteData()
    {
        $admin = Admin::find($this->delete_id);
        $admin->delete();
        $this->dispatch('admin_deleted');
        $this->delete_id = '';
    }

    #[Title('Admin List')]
    public function render()
    {
        $allPermissions = Permission::all();
        $admins = Admin::where('name', 'like', '%' . $this->searchTerm . '%')->where('type', '!=', 'super_admin')->orderBy('id', 'DESC')->paginate($this->sortingValue);
        $this->dispatch('reload_scripts');
        return view('livewire.admin.users.admins-component', ['admins' => $admins, 'allPermissions' => $allPermissions])->layout('livewire.admin.layouts.base');
    }
}
