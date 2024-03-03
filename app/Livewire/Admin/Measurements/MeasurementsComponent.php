<?php

namespace App\Livewire\Admin\Measurements;

use Livewire\Component;
use App\Models\Measurement;
use Livewire\WithPagination;

class MeasurementsComponent extends Component
{
    use WithPagination;
    public $sortingValue = 10, $searchTerm;
    public $edit_id, $delete_id;
    public function render()
    {
        $measurements = Measurement::where('name', 'like', '%' . $this->searchTerm . '%')->orderBy('id', 'DESC')->paginate($this->sortingValue);
        return view('livewire.admin.measurements.measurements-component', ['measurements'=>$measurements])->layout('livewire.admin.layouts.base');
    }
}
