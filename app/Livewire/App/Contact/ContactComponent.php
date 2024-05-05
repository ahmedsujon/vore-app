<?php

namespace App\Livewire\App\Contact;

use App\Models\Contact;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ContactComponent extends Component
{
    public $name, $email, $phone, $description;

    public function storeData()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ]);

        $data = new Contact();
        $data->name = $this->name;
        $data->email = $this->email;
        $data->phone = $this->phone;
        $data->description = $this->description;

        $mailData['name'] = $this->name;
        $mailData['email'] = $this->email;
        $mailData['phone'] = $this->phone;
        $mailData['description'] = $this->description;
 
        $data->save();
        session()->flash('message', 'Thank you for your message. We will contact with you soon !');
    }

    public function render()
    {
        return view('livewire.app.contact.contact-component')->layout('livewire.app.layouts.base');
    }
}
