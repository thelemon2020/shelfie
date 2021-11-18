<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\LightSegment;
use App\Models\Release;
use App\Models\User;
use Livewire\Component;

class UserSettings extends Component
{
    public \App\Models\UserSettings $userSettings;
    public $originalSortMethod;

    protected $rules = [
        'userSettings.wled_ip' => 'sometimes|ip',
        'userSettings.sort_method' => 'required|in:artist,title,genre,release_year',
        'userSettings.sort_order' => 'required|in:asc,desc,custom'
    ];

    public function mount()
    {
        $this->userSettings = User::all()->first()->userSettings;
        $this->originalSortMethod = $this->userSettings->sort_method;
    }

    public function render()
    {
        return view('livewire.user-settings', ['userSettings' => $this->userSettings]);
    }

    public function submit()
    {
        $this->validate();
        $this->userSettings->save();
        $sort_method = $this->userSettings->sort_method;
        if ($sort_method != $this->originalSortMethod) {
            $segments = LightSegment::all();
            $segments->each(fn($segment) => $segment->delete());
            if ($sort_method != 'custom') {
                $this->generateNewLightSegments($sort_method);
            }
        }
    }

    public function generateAlphabet()
    {
        if ($this->userSettings->sort_method === 'asc' || $this->userSettings->sort_method === 'custom') {
            return range('A', 'Z');
        }
        return range('Z', 'A');

    }

    public function generateNewLightSegments($sort_method): void
    {
        if ($sort_method === 'artist' || $sort_method === 'title') {
            $alphabet = $this->generateAlphabet();
            foreach ($alphabet as $key => $letter) {
                LightSegment::query()->create([
                    'name' => $letter,
                    'shelf_order' => $key,
                    'size' => Release::query()->where($sort_method, 'LIKE', $letter . '%')->count(),
                ]);
            }
            $segments = LightSegment::all();
            $segments->each(function ($segment) use ($sort_method) {
                $releases = Release::query()->where($sort_method, 'LIKE', $segment->name . '%');
                $releases->update(['segment_id' => $segment->id]);
            });
        } else if ($sort_method === 'genre_id') {
            $genres = Genre::all();
            foreach ($genres as $key => $genre) {
                LightSegment::query()->create([
                    'name' => $genre->name,
                    'shelf_order' => $key,
                    'size' => Release::query()->where($sort_method, $genre->id)->count(),
                ]);
            }
            $segments = LightSegment::all();
            $segments->each(function ($segment) use ($sort_method) {
                $releases = Release::query()->where($sort_method, $segment->name);
                $releases->update(['segment_id' => $segment->id]);
            });
        } else if ($sort_method === 'release_year') {
            $releaseYears = Release::query()->groupBy('release_year')->pluck('release_year', 'release_year');
            foreach ($releaseYears as $key => $releaseYear) {
                LightSegment::query()->create([
                    'name' => $releaseYear,
                    'shelf_order' => $key,
                    'size' => Release::query()->where($sort_method, $releaseYear)->count(),
                ]);
            }
            $segments = LightSegment::all();
            $segments->each(function ($segment) use ($sort_method) {
                $releases = Release::query()->where($sort_method, $segment->name);
                $releases->update(['segment_id' => $segment->id]);
            });
        }


    }
}
