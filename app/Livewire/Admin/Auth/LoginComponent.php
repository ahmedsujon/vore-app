<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Admin;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginComponent extends Component
{
    public $email, $password;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    public function adminLogin()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $getAdmin = Admin::where('email', $this->email)->first();

        if ($getAdmin) {
            if (Hash::check($this->password, $getAdmin->password)) {
                Auth::guard('admin')->attempt(['email' => $this->email, 'password' => $this->password]);

                session()->flash('success', 'Login Successful');
                return redirect()->route('admin.dashboard');
            } else {
                session()->flash('error', 'Incorrect email or password');
            }
        } else {
            session()->flash('error', 'Incorrect email or password');
        }
    }
    
    #[Title('Login')]
    public function render()
    {
        return view('livewire.admin.auth.login-component')->layout('livewire.admin.auth.layouts.base');
    }
}
