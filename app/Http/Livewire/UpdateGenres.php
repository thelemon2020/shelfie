<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use Livewire\Component;

class UpdateGenres extends Component
{
    public $genre;

    protected function rules()
    {
        return [
            'genre.name' => 'required|string',
            'genre.shelf_order' => ['required', 'integer', 'max:' . Genre::query()->count() + 1],
            'genre.colour' => ['required', 'string', 'regex:/#([a-f0-9]{3}){1,2}\b/i']
        ];
    }

    public function mount($genre = null)
    {
        $this->genre = $genre;
    }

    public function updated()
    {
        $this->emitUp('genreUpdated', $this->genre);
    }

    public function createNewGenre()
    {
        $this->emitUp('genreCreated', $this->genre);
    }

    public function render()
    {
        return view('livewire.update-genres', ['genre' => $this->genre]);
    }

    public function deleteGenre()
    {
        $this->emitUp('genreDeleted', $this->genre->id);
    }
}
