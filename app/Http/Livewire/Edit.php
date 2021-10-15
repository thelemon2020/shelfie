<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Release;
use Carbon\Carbon;
use Exception;
use Livewire\Component;


class Edit extends Component
{
    protected $release;
    public $artist;
    public $title;
    public $release_year;
    public $shelf_order;
    public $full_image;
    public $thumbnail;
    public $allGenres;
    public $genre;

    protected function getListeners()
    {
        return ['genreAdded' => 'newGenre'];
    }

    public function openImageModal()
    {
        $this->emitTo('images', 'openModal', $this->artist, $this->title);
    }

    public function mount($release = null)
    {
        $this->release = $release;
        $this->allGenres = Genre::all();
        if ($release) {
            $this->artist = $release->artist;
            $this->title = $release->title;
            $this->release_year = $release->release_year;
            $this->shelf_order = $release->shelf_order;
            $this->full_image = $release->full_image;
            $this->thumbnail = $release->thumbnail;
            $this->genre = Genre::query()->where('id', $release->genre->id)->first()->id;
        }
    }

    public function render()
    {
        return view('livewire.edit', ['release' => $this->release]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedGenre()
    {
        if ($this->genre === "add-modal") {
            $this->dispatchBrowserEvent('add-genre');
        }

    }

    public function submit()
    {

        $this->validate();
        if ($this->release === null) {
            $this->release = Release::query()->make();
        }
        try {
            $this->release->updateOrCreate([
                'artist' => $this->artist,
                'title' => $this->title,
                'release_year' => $this->release_year,
            ],
                [
                    'thumbnail' => $this->thumbnail,
                    'full_image' => $this->full_image,
                    'shelf_order' => $this->shelf_order,
                    'genre_id' => Genre::query()->where('id', $this->genre)->first()->id
                ]);
            $this->release->save();
        } catch (Exception $e) {
            session()->flash('error', 'Release could not be updated.');
            return false;
        }
        session()->flash('message', 'Release successfully updated.');
    }

    public function newGenre()
    {
        $this->allGenres = Genre::all();
        $this->render();
    }

    protected function rules()
    {
        return [
            'artist' => 'required',
            'title' => 'required',
            'release_year' => ['required', 'integer', 'max:' . Carbon::now()->year],
            'shelf_order' => ['required', 'integer', 'max:' . Release::query()->count() + 1],
            'thumbnail' => ['required', 'url'],
            'full_image' => ['required', 'url'],
            'genre' => 'required'
        ];
    }
}

