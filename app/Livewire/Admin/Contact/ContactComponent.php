<?php

namespace App\Livewire\Admin\Contact;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class ContactComponent extends Component
{
    use WithPagination;
    public $sortingValue = 10, $searchTerm;
    public $edit_id, $delete_id;
    public $name, $email, $phone, $description;

    public function editData($id)
    {
        $data = Contact::find($id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->description = $data->description;
        $this->edit_id = $data->id;

        $this->dispatch('showEditModal');
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show_delete_confirmation');
    }

    #[Title('Contact Message List')]
    public function render()
    {
        $contacts = Contact::where('name', 'like', '%' . $this->searchTerm . '%')->orderBy('id', 'DESC')->paginate($this->sortingValue);
        $this->dispatch('reload_scripts');
        return view('livewire.admin.contact.contact-component', ['contacts'=>$contacts])->layout('livewire.admin.layouts.base');
    }
}
