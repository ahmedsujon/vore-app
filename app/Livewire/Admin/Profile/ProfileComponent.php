<?php

namespace App\Livewire\Admin\Profile;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileComponent extends Component
{
    public $role_id, $name, $email, $password, $confirm_password, $avatar, $new_avatar;

    use WithFileUploads;

    public function mount()
    {
        $getData = User::where('id', Auth::user()->id)->first();
        $this->name = $getData->name;
        $this->email = $getData->email;
        $this->new_avatar = $getData->avatar;
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::user()->id.'',
            'password' => 'min:8|same:confirm_password',
            'confirm_password' => 'min:8'
        ]);

        $profile = User::where('id', Auth::user()->id)->first();
        $profile->name = $this->name;
        $profile->email = $this->email;
        $profile->password = Hash::make($this->password);

        if ($this->avatar) {
            $fileName = uniqid() . Carbon::now()->timestamp . '.' . $this->avatar->extension();
            $this->avatar->storeAs('profile_images', $fileName);
            $profile->avatar = 'uploads/profile_images/' . $fileName;
        } else {
            $profile->avatar = 'assets/images/avatar.png';
        }

        $profile->save();
        $this->dispatch('success', ['message'=>'Profile Updated Successfully']);

    }

    public function render()
    {
        $profile = User::find(Auth::user()->id);
        return view('livewire.admin.profile.profile-component', ['profile'=>$profile])->layout('livewire.admin.layouts.base');
    }
}
