<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\User;
use Livewire\Component;

class Genres extends Component
{
    public $genre;

    public function render()
    {
        return view('livewire.genres');
    }

    public $rules = [
        'genre' => 'required|unique:genres,name'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();
        Genre::query()->create([
            'name' => $this->genre,
            'user_id' => User::all()->first()->id,
        ]);
        $this->emitUp('genreAdded');
    }

}
