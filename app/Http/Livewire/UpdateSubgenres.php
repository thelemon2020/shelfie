<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UpdateSubgenres extends Component
{
    public $subgenre;

    protected function rules()
    {
        return [
            'subgenre.name' => 'required|string',
        ];
    }

    public function mount($genre = null)
    {
        $this->subgenre = $genre;
    }

    public function updated()
    {
        $this->emitUp('subgenreUpdated', $this->subgenre);
    }

    public function createNewGenre()
    {
        $this->emitUp('subgenreCreated', $this->subgenre);
    }

    public function render()
    {
        return view('livewire.update-subgenres', ['subgenre' => $this->subgenre]);
    }

    public function deleteSubgenre()
    {
        $this->emitUp('subgenreDeleted', $this->subgenre->id);
    }
}
