<?php

namespace App\Http\Livewire;

use App\Models\Release;
use Livewire\Component;

class LatestRelease extends Component
{
    public $release;

    public function getLatest()
    {
        $this->release = Release::query()->latest('id')->first();
    }

    public function render()
    {
        return view('livewire.latest-release', ['release' => $this->release]);
    }
}
