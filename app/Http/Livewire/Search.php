<?php

namespace App\Http\Livewire;

use App\Models\Release;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use withPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sort = 'artist';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->sort == 'genre') {
            $releases = Release::query()
                ->join('genres', 'releases.genre_id', '=', 'genres.id')
                ->where('genres.name', "LIKE", "%$this->search%")
                ->orderBy('genres.name', 'ASC')
                ->paginate();
        } else {
            $releases = Release::query()->where($this->sort, "LIKE", "%$this->search%")->orderBy($this->sort, 'ASC')->paginate();
        }
        return view('livewire.search', [
            'releases' => $releases
        ]);
    }
}
