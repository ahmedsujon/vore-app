<?php

namespace App\Livewire\Admin\Team;

use Carbon\Carbon;
use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

class TeamComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $sortingValue = 10, $searchTerm;
    public $edit_id, $delete_id;
    public $name, $designation, $image, $uploadedImage, $status;

    public function storeData()
    {
        $this->validate([
            'name' => 'required',
            'designation' => 'required',
        ]);

        $data = new Team();
        $data->name = $this->name;
        $data->designation = $this->designation;

        if ($this->image) {
            $fileName = uniqid() . Carbon::now()->timestamp . '.' . $this->image->extension();
            $this->image->storeAs('profile_images', $fileName);
            $data->image = 'uploads/profile_images/' . $fileName;
        } else {
            $data->image = 'assets/images/placeholder.jpg';
        }

        $data->save();
        $this->dispatch('closeModal');
        $this->dispatch('success', ['message' => 'New team member added successfully!']);
        $this->resetInputs();
    }

    public function editData($id)
    {
        $data = Team::find($id);
        $this->name = $data->name;
        $this->designation = $data->designation;
        $this->uploadedImage = $data->image;
        $this->edit_id = $data->id;

        $this->dispatch('showEditModal');
    }

    public function updateData()
    {

        $this->validate([
            'name' => 'required',
            'designation' => 'required',
        ]);

        $data = Team::find($this->edit_id);
        $data->name = $this->name;
        $data->designation = $this->designation;

        if ($this->image) {
            $fileName = uniqid() . Carbon::now()->timestamp . '.' . $this->image->extension();
            $this->image->storeAs('profile_images', $fileName);
            $data->image = 'uploads/profile_images/' . $fileName;
        } else {
            $data->image = 'assets/images/placeholder.jpg';
        }
        $data->save();

        $this->dispatch('closeModal');
        $this->dispatch('success', ['message' => 'Team member info updated successfully!']);
        $this->resetInputs();
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->name = null;
        $this->designation = null;
        $this->image = null;
        $this->edit_id = null;
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show_delete_confirmation');
    }

    public function deleteData()
    {
        $admin = Team::find($this->delete_id);
        $admin->delete();
        $this->dispatch('admin_deleted');
        $this->delete_id = '';
    }

    #[Title('Team Member List')]
    public function render()
    {
        $teams = Team::where('name', 'like', '%' . $this->searchTerm . '%')->orderBy('id', 'DESC')->paginate($this->sortingValue);
        $this->dispatch('reload_scripts');
        return view('livewire.admin.team.team-component', ['teams' => $teams])->layout('livewire.admin.layouts.base');
    }
}
