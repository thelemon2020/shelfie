<?php

namespace App\Http\Livewire;

use App\Models\Subgenre;
use Livewire\Component;

class Subgenres extends Component
{
    public $subgenre;

    public function render()
    {
        return view('livewire.subgenres');
    }

    public $rules = [
        'subgenre' => 'required|unique:subgenres,name'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();
        Subgenre::query()->create([
            'name' => $this->subgenre,
        ]);
        $this->emitUp('subgenreAdded');
    }

}
