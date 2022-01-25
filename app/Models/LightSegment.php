<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
