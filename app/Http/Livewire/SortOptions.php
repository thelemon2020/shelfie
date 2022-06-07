<?php

namespace App\Http\Livewire;

use App\Models\LightSegment;
use App\Models\Release;
use App\Models\User;
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
            $this->reorderCollection();
        }
        $this->emit('refreshSegments');
    }

    public function reorderCollection(): void
    {
        Release::sort();
        if ($this->userSettings->wled_ip) {
            LightSegment::generateSegments();
        }
    }


}
