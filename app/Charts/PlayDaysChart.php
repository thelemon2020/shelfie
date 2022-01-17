<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Release;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class PlayDaysChart extends BaseChart
{

    public function handler(Request $request): Chartisan
    {
        $playDays = collect(Release::query()->whereNotNull('last_played_at')->get('last_played_at'))->groupBy(function ($date) {
            return Carbon::parse($date->last_played_at)->format('l');
        })->toArray();

        $daysOfTheWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $releasesPerDay = array_map(function($day) use ($playDays) {
            $numberOfPlays = $playDays[$day] ?? [];
            return count($numberOfPlays);
        }, $daysOfTheWeek);
        return Chartisan::build()
            ->labels($daysOfTheWeek)
            ->dataset('Sample', $releasesPerDay);
    }
}
