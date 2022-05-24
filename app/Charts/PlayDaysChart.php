<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Plays;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class PlayDaysChart extends BaseChart
{
    public function handler(Request $request): Chartisan
    {
        $playDays = collect(Plays::query()->get('created_at'))
            ->each(function ($date) {
                $date->created_at = $date->created_at->setTimeZone('America/Toronto');
            })
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('l');
            })->toArray();
        $daysOfTheWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $releasesPerDay = array_map(function ($day) use ($playDays) {
            $numberOfPlays = $playDays[$day] ?? [];
            return count($numberOfPlays);
        }, $daysOfTheWeek);
        return Chartisan::build()
            ->labels($daysOfTheWeek)
            ->dataset('Sample', $releasesPerDay);
    }
}
