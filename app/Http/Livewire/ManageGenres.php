<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use Livewire\Component;

class ManageGenres extends Component
{

    public $genres;

    protected $listeners = [
        'genreUpdated' => 'genreUpdated',
        'genreDeleted' => 'genreDeleted',
        'refreshPage' => '$refresh'
    ];

    public function mount()
    {
        $this->genres = Genre::all()->sortBy('shelf_order');
    }

    public function render()
    {
        return view('livewire.manage-genres');
    }

    public function genreUpdated($genre)
    {
        $genreToUpdate = $this->genres->where('id', $genre['id'])->first();
        $genreToUpdate->name = $genre['name'];
        $genreToUpdate->colour = $genre['colour'];
        $genreToUpdate->shelf_order = $genre['shelf_order'];
    }

    public function submit()
    {
        foreach ($this->genres as $genre) {
            $genre->save();
        }
        $this->dispatchBrowserEvent('reloadPage');
    }

    protected function rules()
    {
        return [
            'genres.*.name' => 'required|string',
            'genres.*.shelf_order' => ['required', 'integer', 'max:' . Genre::query()->count() + 1],
            'genres.*.colour' => ['required', 'string', 'regex:/#([a-f0-9]{3}){1,2}\b/i']
        ];
    }

    public function genreDeleted($genreToDelete)
    {
        $genreToUpdate = $this->genres->where('id', $genreToDelete)->first();
        $genreToUpdate->delete();
        $this->emit('refreshPage');
    }
}
