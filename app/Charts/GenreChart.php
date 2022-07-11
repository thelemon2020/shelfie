<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Plays;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenreChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        try {
            $mostPlayedGenres = Plays::query()
                ->join('releases', 'plays.release_id', '=', 'releases.id')
                ->join('genre_release', 'releases.id', '=', 'genre_release.release_id')
                ->join('genres', 'genre_release.genre_id', '=', 'genres.id')
                ->select('genres.name', DB::raw("count(*) as times_played"))
                ->groupBy('genres.name')
                ->orderBy('times_played', 'DESC')
                ->get();
            $labels = $mostPlayedGenres->pluck('name');
            $count = $mostPlayedGenres->pluck('times_played');
            return Chartisan::build()
                ->labels($labels->toArray())
                ->dataset('Times Chosen', $count->toArray());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return Chartisan::build();
    }
}
