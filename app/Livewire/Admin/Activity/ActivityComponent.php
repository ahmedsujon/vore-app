<?php

namespace App\Livewire\Admin\Activity;

use App\Models\Activity;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityComponent extends Component
{
    use WithPagination;
    public $sortingValue = 10, $searchTerm;
    public $edit_id, $delete_id;

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show_delete_confirmation');
    }

    public function deleteData()
    {
        $admin = Activity::find($this->delete_id);
        $admin->delete();
        $this->dispatch('activity_deleted');
        $this->delete_id = '';
    }

    public function render()
    {
        $activities = Activity::where('name', 'like', '%' . $this->searchTerm . '%')->orderBy('id', 'DESC')->paginate($this->sortingValue);
        $this->dispatch('reload_scripts');
        return view('livewire.admin.activity.activity-component', ['activities'=>$activities])->layout('livewire.admin.layouts.base');
    }
}
