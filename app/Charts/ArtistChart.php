<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Plays;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtistChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {

        $mostPlayedArtists = Plays::query()
            ->join('releases', 'plays.release_id', '=', 'releases.id')
            ->select('releases.artist', DB::raw("count(*) as times_played"))
            ->groupBy('releases.artist')
            ->orderBy('times_played', 'DESC')
            ->take(10)
            ->get();
        $labels = $mostPlayedArtists->pluck('artist');
        $count = $mostPlayedArtists->pluck('times_played');
        return Chartisan::build()
            ->labels($labels->toArray())
            ->dataset('Artists', $count->toArray());
    }
}
