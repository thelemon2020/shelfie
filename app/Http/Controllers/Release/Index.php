<?php

namespace App\Http\Controllers\Release;

use App\Models\Release;
use Illuminate\Http\Request;

class Index extends \Illuminate\Routing\Controller
{
    public function __invoke(Request $request)
    {
        $params = $request->collect();
        $search = $params['search'];
        if ($params['sort'] == 'Genre') {
            return Release::query()
                ->join('genre_release', 'releases.id', '=', 'genre_release.release_id')
                ->join('genres', 'genres.id', '=', 'genre_release.genre_id')
                ->join('release_subgenre', 'releases.id', '=', 'release_subgenre.release_id')
                ->join('subgenres', 'subgenres.id', '=', 'release_subgenre.subgenre_id')
                ->where('genres.name', 'LIKE', "%$search%")
                ->orWhere('subgenres.name', 'LIKE', "%$search%")
                ->select(['releases.*', 'genres.name', 'subgenres.name'])
                ->distinct()
                ->orderBy('genres.name')
                ->orderBy('subgenres.name')
                ->orderBy('releases.artist')
                ->with(['genres:name', 'subgenres:name'])
                ->paginate($params['paginate']);
        }
        return Release::query()
            ->with(['genres:name', 'subgenres:name'])
            ->where($params['sort'], 'LIKE', '%' . $params['search'] . '%')
            ->orderBy($params['sort'])->paginate($params['paginate']);
    }
}
