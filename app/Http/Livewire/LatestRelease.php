<?php

namespace App\Http\Livewire;

use App\Models\Release;
use Livewire\Component;

class LatestRelease extends Component
{
    public function render()
    {
        $release = Release::query()->latest()->first();
        return view('livewire.latest-release', ['release' => $release]);
    }
}
