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
    public $pagination = 50;

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function updatingPagination()
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
                ->paginate($this->pagination);
        } else {
            $releases = Release::query()->where($this->sort, "LIKE", "%$this->search%")->orderBy($this->sort, 'ASC')->paginate($this->pagination);
        }
        return view('livewire.search', [
            'releases' => $releases
        ]);
    }
}
