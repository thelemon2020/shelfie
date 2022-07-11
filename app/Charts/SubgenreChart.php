<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Plays;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubgenreChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $mostPlayedSubGenres = Plays::query()
            ->join('releases', 'plays.release_id', '=', 'releases.id')
            ->join('release_subgenre', 'releases.id', '=', 'release_subgenre.release_id')
            ->join('subgenres', 'release_subgenre.subgenre_id', '=', 'subgenres.id')
            ->select('subgenres.name', DB::raw("count(*) as times_played"))
            ->groupBy('subgenres.name')
            ->orderBy('times_played', 'DESC')
            ->get();
        $labels = $mostPlayedSubGenres->pluck('name');
        $count = $mostPlayedSubGenres->pluck('times_played');
        return Chartisan::build()
            ->labels($labels->toArray())
            ->dataset('Times Chosen', $count->toArray());
    }
}
