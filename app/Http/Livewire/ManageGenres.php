<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use Livewire\Component;

class ManageGenres extends Component
{

    public $genres;

    protected $listeners = ['genreUpdated'];

    public function mount()
    {
        $this->genres = Genre::all()->sortBy('shelf_order');
    }

    public function render()
    {
        return view('livewire.manage-genres', ['genres' => $this->genres]);
    }

    public function genreUpdated($genre)
    {
        $this->genres[$genre['shelf_order'] - 1]->name = $genre['name'];
        $this->genres[$genre['shelf_order'] - 1]->colour = $genre['colour'];
        $this->genres[$genre['shelf_order'] - 1]->shelf_order = $genre['shelf_order'];
    }

    public function submit()
    {
        foreach ($this->genres as $genre) {
            $genre->save();
        }
    }

    protected function rules()
    {
        return [
            'genres.*.name' => 'required|string',
            'genres.*.shelf_order' => ['required', 'integer', 'max:' . Genre::query()->count() + 1],
            'genres.*.colour' => ['required', 'string', 'regex:/#([a-f0-9]{3}){1,2}\b/i']
        ];
    }
}
