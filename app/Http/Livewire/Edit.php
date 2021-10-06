<?php

namespace App\Http\Livewire;

use App\Models\Release;
use Carbon\Carbon;
use Livewire\Component;
use mysql_xdevapi\Exception;

class Edit extends Component
{
    public $release;

    public function render()
    {
        return view('livewire.edit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();
        try {
            $this->release->save();
        } catch (Exception $e) {
            session()->flash('error', 'Release could not be updated.');
        }

        session()->flash('message', 'Release successfully updated.');
    }

    protected function rules()
    {
        return [
            'release.artist' => 'required',
            'release.title' => 'required',
            'release.release_year' => ['required', 'integer', 'max:' . Carbon::now()->year],
            'release.shelf_order' => ['required', 'integer', 'max:' . Release::query()->count()],
            'release.thumbnail' => ['required', 'url'],
            'release.full_image' => ['required', 'url'],
        ];
    }
}

