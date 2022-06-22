<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\GenreRelease;
use App\Models\Release;
use Carbon\Carbon;
use Exception;
use Livewire\Component;


class Edit extends Component
{
    public $release;
    public $allGenres;
    public $genre;
    public $genres;
    public $full_image;
    private $originalShelfOrder;
    public bool $newRelease;

    protected function getListeners()
    {
        return [
            'genreAdded' => 'newGenre',
            'changeImage' => 'changeImage',
            'editRelease' => 'refreshComponent'
        ];
    }
    public function mount()
    {
        $this->allGenres = Genre::all();
    }

    public function changeImage($newImage, $newThumbnail)
    {
        $this->full_image = $newImage;
        $this->release->full_image = $newImage;
        $this->release->thumbnail = $newThumbnail;
    }

    public function loadImages()
    {
        $this->dispatchBrowserEvent('open-image-modal');
        $this->dispatchBrowserEvent('load-images', ['artist' => $this->release->artist, 'title' => $this->release->title]);
    }

    public function removeGenre($id)
    {
        $key = $this->genres->search(function ($genre) use ($id) {
            return $genre->id === $id;
        });
        $this->genres->forget($key);
    }

    public function refreshComponent($releaseId = null)
    {
        $this->newRelease = false;
        if ($releaseId) {
            $release = Release::query()->where('id', $releaseId)->first();
            $this->full_image = $release->full_image;
            $this->genres = $release->genres;
        } else {
            $release = Release::query()->make();
            $this->newRelease = true;
            $this->full_image = null;
        }
        $this->release = $release;
        $this->originalShelfOrder = $release->shelf_order;
        $this->genre = null;
        $this->render();
    }

    public function render()
    {
        return view('livewire.edit');
    }

    public function updatedGenre()
    {
        if ($this->genre === "add-modal") {
            $this->dispatchBrowserEvent('add-genre');
        } else {
            $this->genres->push($this->allGenres[$this->genre]);
        }
        $this->release->genre = null;
    }

    public function submit()
    {
        $this->validate();
        try {
            if ($this->newRelease) {
                $this->release = Release::query()->create(
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
            } else {
                $this->release->update([
                    'artist' => $this->release->artist,
                    'title' => $this->release->title,
                    'release_year' => $this->release->release_year,
                    'thumbnail' => $this->release->thumbnail,
                    'full_image' => $this->full_image,
                    'shelf_order' => $this->release->shelf_order,
                ]);
            }
            $this->release->genres->each(function ($currentGenre) {
                $key = $this->genres->search(function ($updatedGenre) use ($currentGenre) {
                    return $updatedGenre->id === $currentGenre;
                });
                if (!$key) {
                    GenreRelease::query()
                        ->where('release_id', $this->release->id)
                        ->where('genre_id', $currentGenre->id)
                        ->delete();
                }
            });
            $this->genres->each(function ($genre) {
                GenreRelease::query()->updateOrCreate([
                    'release_id' => $this->release->id,
                    'genre_id' => $genre->id
                ]);
            });
        } catch
        (Exception $e) {
            session()->flash('error', 'Release could not be updated.');
            return false;
        }
        session()->flash('message', 'Release successfully updated.');
        $this->dispatchBrowserEvent('new-release-updated', ['id' => $this->release->id]);
        $this->reset(
            [
                'full_image',
                'genre',
                'release',
            ]);
        return true;
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
            'release.thumbnail' => ['required', 'url'],
            'release.full_image' => ['required', 'url'],
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

