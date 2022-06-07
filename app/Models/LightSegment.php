<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class LightSegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'colour',
        'size',
        'shelf_order',
    ];

    public function releases()
    {
        return $this->hasMany(Release::class, 'segment_id', 'id');
    }

    public static function turnOnAllIndividualSegments()
    {
        $segments = LightSegment::all()->sortBy('shelf_order');
        $position = 0;
        $seg = [];
        foreach ($segments as $segment) {
            $size = floor($segment->releases()->count() / 2);
            list($r, $g, $b) = sscanf($segment->colour, "#%02x%02x%02x");
            $segment = [
                'start' => $position,
                'stop' => $position + $size,
                'len' => $size,
                'col' => [[$r, $g, $b], [$r, $g, $b], [$r, $g, $b]],
            ];
            $position += $size;
            $seg[] = $segment;
        }
        $payload = ['seg' => $seg];
        $response = Http::timeout(2)->post(User::all()->first()->userSettings->wled_ip . '/json', $payload);
        return $response;
    }

    public static function turnOnAllLightsSameColour($colour)
    {
        $segments = LightSegment::all()->sortBy('shelf_order');
        $position = 0;
        $seg = [];
        list($r, $g, $b) = sscanf($colour, "#%02x%02x%02x");
        if (count($segments) <= 1) {
            $size = floor(Release::query()->count() / 2);
            $segment = [
                'start' => $position,
                'stop' => $position + $size,
                'len' => $size,
                'col' => [[$r, $g, $b], [$r, $g, $b], [$r, $g, $b]],
            ];
            $seg[] = $segment;
        } else {
            foreach ($segments as $segment) {
                $size = floor($segment->releases()->count() / 2);
                $segment = [
                    'start' => $position,
                    'stop' => $position + $size,
                    'len' => $size,
                    'col' => [[$r, $g, $b], [$r, $g, $b], [$r, $g, $b]],
                ];
                $position += $size;
                $seg[] = $segment;
            }
        }
        $payload = ['seg' => $seg];
        $response = Http::timeout(2)->post(User::all()->first()->userSettings->wled_ip . '/json', $payload);
        return $response;
    }

    public static function toggleLights()
    {
        $response = json_decode(Http::timeout(2)->get(User::all()->first()->userSettings->wled_ip . '/json/state'), true);
        $onOff = $response['on'];
        $onOff = !$onOff;

        $payload = ['on' => $onOff];

        $response = Http::timeout(2)->post(User::all()->first()->userSettings->wled_ip . '/json', $payload);
        return $response;
    }

    private static function generateAlphabet($sortOrder)
    {
        if ($sortOrder != 'desc') {
            $range = array_merge(range('0', '9'), range('A', 'Z'));
        } else {
            $range = array_merge(range('Z', 'A'), range('9', '0'));
        }
        return array_map(function ($range) {
            return
                [
                    'name' => $range,
                    'sortBy' => "$range%",
                    'needsLike' => true,
                ];
        }, $range);
    }

    public static function generateSegments()
    {
        $userSettings = UserSettings::query()->first()->get();
        $segments = LightSegment::all();
        $segments->each(fn($segment) => $segment->delete());
        $segmentsToGenerate = null;
        if ($userSettings->sort_method === 'artist' || $userSettings->sort_method === 'title') {
            $segmentsToGenerate = LightSegment::generateAlphabet($userSettings->sort_order);
        } else if ($userSettings->sort_method === 'genre_id') {
            $segmentsToGenerate = Genre::all()->map(function ($genre) {
                return [
                    'name' => $genre->name,
                    'sortBy' => $genre->id,
                    'needsLike' => false,
                ];
            });
        } else if ($userSettings->sort_method === 'release_year') {
            $segmentsToGenerate = Release::query()
                ->groupBy('release_year')
                ->orderBy('release_year', $userSettings->sort_order)
                ->pluck('release_year')
                ->map(function ($releaseYear) {
                    return [
                        'name' => $releaseYear,
                        'sortBy' => $releaseYear,
                        'needsLike' => false,
                    ];
                });
        }
        LightSegment::generateNewLightSegments($segmentsToGenerate, $userSettings->sort_method);
    }

    private static function generateNewLightSegments(array|Collection|null $segmentsToGenerate, $sort_method)
    {
        $i = 1;
        foreach ($segmentsToGenerate as $segment) {
            $releasesInSegment = Release::query()->where($sort_method, $segment['needsLike'] ? 'LIKE' : '=', $segment['sortBy'])->get();
            $newSegment = LightSegment::query()->create([
                'name' => $segment['name'],
                'shelf_order' => $i++,
                'size' => $releasesInSegment->count(),
            ]);
            $releasesInSegment->each(function ($release) use ($newSegment) {
                $release->update([
                    'segment_id' => $newSegment->id,
                ]);
            });
        }
    }
}
