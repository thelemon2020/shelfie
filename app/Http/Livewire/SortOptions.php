<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\LightSegment;
use App\Models\Release;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class SortOptions extends Component
{

    protected $rules = [
        'userSettings.sort_method' => 'required|in:artist,title,genre_id,release_year',
        'userSettings.sort_order' => 'required|in:asc,desc,custom'
    ];

    public function mount()
    {
        $this->userSettings = User::all()->first()->userSettings;
    }

    public function render()
    {
        return view('livewire.sort-options');
    }

    public function submit()
    {
        $this->validate();
        $this->userSettings->save();
        $sort_method = $this->userSettings->sort_method;
        $sort_order = $this->userSettings->sort_order;
        $segments = LightSegment::all();
        $segments->each(fn($segment) => $segment->delete());
        if ($sort_method != 'custom') {
            $this->reorderCollection($sort_method, $sort_order);
        }
        $this->emit('refreshSegments');
    }

    public function generateAlphabet()
    {
        if ($this->userSettings->sort_order != 'desc') {
            $range = array_merge(range('0', '9'), range('A', 'Z'));
        } else {
            $range = array_merge(range('Z', 'A'), range('9', '0'));
        }
        return array_map(function ($range) {
            return
                [
                    'name' => $range,
                    'sortBy' => "$range%",
                    'needsLike' => true,
                ];
        }, $range);
    }

    public function reorderCollection($sort_method, $sort_order): void
    {
        $i = 1;
        $releases = Release::all()->sortBy($sort_method, SORT_REGULAR, !($sort_order === 'asc'));
        $releases->each(function ($release) use (&$i) {
            $release->update([
                'shelf_order' => $i++,
            ]);
        });
        $segmentsToGenerate = null;
        if ($sort_method === 'artist' || $sort_method === 'title') {
            $segmentsToGenerate = $this->generateAlphabet();
        } else if ($sort_method === 'genre_id') {
            $segmentsToGenerate = Genre::all()->map(function ($genre) {
                return [
                    'name' => $genre->name,
                    'sortBy' => $genre->id,
                    'needsLike' => false,
                ];
            });
        } else if ($sort_method === 'release_year') {
            $segmentsToGenerate = Release::query()
                ->groupBy('release_year')
                ->orderBy('release_year', $sort_order)
                ->pluck('release_year')
                ->map(function ($releaseYear) {
                    return [
                        'name' => $releaseYear,
                        'sortBy' => $releaseYear,
                        'needsLike' => false,
                    ];
                });
        }
        $this->generateNewLightSegments($segmentsToGenerate, $sort_method);
    }

    private function generateNewLightSegments(array|Collection|null $segmentsToGenerate, $sort_method)
    {
        $i = 1;
        foreach ($segmentsToGenerate as $segment) {
            $releasesInSegment = Release::query()->where($sort_method, $segment['needsLike'] ? 'LIKE' : '=', $segment['sortBy'])->get();
            $newSegment = LightSegment::query()->create([
                'name' => $segment['name'],
                'shelf_order' => $i++,
                'size' => $releasesInSegment->count(),
            ]);
            $releasesInSegment->each(function ($release) use ($newSegment) {
                $release->update([
                    'segment_id' => $newSegment->id,
                ]);
            });
        }
    }
}
