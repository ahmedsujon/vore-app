<?php

namespace App\Livewire\Admin\Partials;

use Carbon\Carbon;
use App\Models\Admin;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class ProfileComponent extends Component
{
    use WithFileUploads;
    public $name, $email, $phone, $password, $avatar, $uploadedAvatar;

    public function mount()
    {
        $admin = Admin::find(admin()->id);
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->phone = $admin->phone;
        $this->uploadedAvatar = $admin->avatar;
    }

    public function updated($fields)
    {
        if ($this->password) {
            $this->validateOnly($fields, [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'password' => 'min:8|max:25',
            ]);
        } else {
            $this->validateOnly($fields, [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric',
            ]);
        }
    }

    public function updateProfile()
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

        $user = Admin::find(admin()->id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }
        if($this->avatar){
            $imageName = Carbon::now()->timestamp. '_favicon' . $this->avatar->extension();
            $this->avatar->storeAs('profile_images',$imageName);
            $user->avatar = 'uploads/profile_images/'.$imageName;
        }
        $user->save();

        $this->dispatch('closeModal');
        $this->dispatch('success', ['message' => 'Profile updated successfully']);
    }


    public function render()
    {
        return view('livewire.admin.partials.profile-component');
    }
}
