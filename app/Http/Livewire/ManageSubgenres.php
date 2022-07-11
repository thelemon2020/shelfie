<?php

namespace App\Http\Livewire;

use App\Models\Subgenre;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ManageSubgenres extends Component
{

    public $subgenres;

    protected $listeners = [
        'subgenreUpdated' => 'subgenreUpdated',
        'subgenreDeleted' => 'subgenreDeleted',
        'refreshPage' => '$refresh'
    ];

    public function mount()
    {
        $this->subgenres = Subgenre::all()->sortBy('shelf_order');
    }

    public function render()
    {
        return view('livewire.manage-subgenres');
    }

    public function subgenreUpdated($subgenre)
    {
        $subgenreToUpdate = $this->subgenres->where('id', $subgenre['id'])->first();
        $subgenreToUpdate->name = $subgenre['name'];
    }

    public function submit()
    {
        foreach ($this->subgenres as $subgenre) {
            $subgenre->save();
        }
        Http::get(route('api.lights.genres'));
        $this->dispatchBrowserEvent('reloadPage');
    }

    protected function rules()
    {
        return [
            'subgenres.*.name' => 'required|string',
        ];
    }

    public function subgenreDeleted($genreToDelete)
    {
        $genreToUpdate = $this->subgenres->where('id', $genreToDelete)->first();
        $genreToUpdate->delete();
        $this->emitSelf('refreshPage');
    }

    public function createSubgenre()
    {
        $newGenre = Subgenre::query()->create([
            'name' => '',
        ]);
        $this->subgenres->push($newGenre);
    }
}
