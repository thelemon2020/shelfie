<?php

namespace App\Http\Livewire;

use App\Models\Release;
use Livewire\Component;

class Search extends Component
{
    public $search = '';
    public $sort ='artist';

    public function render()
    {
        return view('livewire.search', [
            'releases' => Release::query()->where("title", "LIKE", "%$this->search%")->orderBy($this->sort, 'ASC')->paginate()
        ]);
    }
}
