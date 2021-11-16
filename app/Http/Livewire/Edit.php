<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Release;
use Carbon\Carbon;
use Exception;
use Livewire\Component;


class Edit extends Component
{
    public $release;
    public $full_image;
    public $allGenres;
    public $genre;
    private $originalShelfOrder;

    protected function getListeners()
    {
        return [
            'genreAdded' => 'newGenre',
            'changeImage' => 'changeImage',
        ];
    }

    public function changeImage($newImage, $newThumbnail)
    {
        $this->full_image = $newImage;
        $this->release->full_image = $newImage;
        $this->release->thumbnail = $newThumbnail;
    }

    public function loadImages()
    {
        $this->dispatchBrowserEvent('image-modal');
        $this->emitTo('images', 'getImages', $this->release['artist'], $this->release['title']);
    }

    public function mount($release = null)
    {
        if ($release) {
            $this->full_image = $release->full_image;
            $this->genre = Genre::query()->where('id', $release->genre?->id)->first()->id ?? null;
        } else {
            $release = Release::query()->make();
        }
        $this->release = $release;
        $this->originalShelfOrder = $release->shelf_order;
        $this->allGenres = Genre::all();
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
        if ($this->release->genre === "add-modal") {
            $this->dispatchBrowserEvent('add-genre');
            $this->release->genre = null;
        }
    }

    public function submit()
    {
        $this->validate();
        try {
            if (!$this->release->exists) {
                $this->release->create(
                    [
                        'artist' => $this->release->artist,
                        'title' => $this->release->title,
                        'release_year' => $this->release->release_year,
                        'thumbnail' => $this->release->thumbnail,
                        'full_image' => $this->full_image,
                        'shelf_order' => $this->release->shelf_order,
                        'genre_id' => $this->release->genre_id
                    ]);
                $this->changeShelfOrder();
                $this->reset(
                    [
                        'full_image',
                        'genre',
                        'release',
                    ]);
                $this->release = Release::query()->make();
            } else {
                $this->changeExistingShelfOrder();
                $this->release->update([
                    'artist' => $this->release->artist,
                    'title' => $this->release->title,
                    'release_year' => $this->release->release_year,
                    'thumbnail' => $this->release->thumbnail,
                    'full_image' => $this->full_image,
                    'shelf_order' => $this->release->shelf_order,
                    'genre_id' => $this->release->genre_id
                ]);
            }
        } catch
        (Exception $e) {
            session()->flash('error', 'Release could not be updated.');
            return false;
        }
        session()->flash('message', 'Release successfully updated.');
        $this->dispatchBrowserEvent('refreshPage');
    }

    public function newGenre()
    {
        $this->allGenres = Genre::all();
        $this->render();
    }

    protected function rules()
    {
        return [
            'release.artist' => 'required',
            'release.title' => 'required',
            'release.release_year' => ['required', 'integer', 'max:' . Carbon::now()->year],
            'release.shelf_order' => ['required', 'integer', 'max:' . Release::query()->count() + 1],
            'release.thumbnail' => ['required', 'url'],
            'release.full_image' => ['required', 'url'],
            'release.genre_id' => 'required'
        ];
    }

    private function changeShelfOrder()
    {
        $releasesToLowerInOrder = Release::query()->where('shelf_order', '>=', $this->release->shelf_order)->where('id', '!=', $this->release->id)->get();
        $releasesToLowerInOrder->each(fn($release) => $release->update(['shelf_order' => (int)$release->shelf_order + 1]));
    }

    private function changeExistingShelfOrder()
    {
        $releasesToLowerInOrder = Release::query()->whereBetween('shelf_order', [$this->originalShelfOrder + 1, $this->release->shelf_order])->get();
        $releasesToLowerInOrder->each(fn($release) => $release->update(['shelf_order' => (int)$release->shelf_order - 1]));
    }
}

