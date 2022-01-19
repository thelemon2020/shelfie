<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Plays;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $mostPlayedGenres = Plays::query()
            ->join('genres', 'plays.genre_id', '=', 'genres.id')
            ->select('genres.name', DB::raw("count(*) as times_played"))
            ->groupBy('plays.genre_id')
            ->orderBy('times_played', 'DESC')
            ->get();
        $labels = $mostPlayedGenres->pluck('name');
        $count = $mostPlayedGenres->pluck('times_played');
        return Chartisan::build()
            ->labels($labels->toArray())
            ->dataset('Times Chosen', $count->toArray());
    }
}
