<?php

namespace App\Models;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Release extends Model
{
    use HasFactory;
    use EloquentJoin;

    protected $guarded = [];
    protected $casts = [
        'release_year' => 'integer'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function segment()
    {
        return $this->belongsTo(LightSegment::class, 'segment_id', 'id');
    }

    public function turnOnLight()
    {
        $selectRecord = [
            "seg" => [
                'id' => $this->segment?->shelf_order - 1 ?? 0,
                "i" =>
                    [
                        (int)floor($this->shelf_order / 2),
                        [255, 255, 255]
                    ]
            ]];
        Cache::put('selected-record', $selectRecord);
        Http::timeout(2)->post(User::all()->first()->userSettings->wled_ip . '/json', $selectRecord);
    }

    public static function sort()
    {
        $user = User::query()->first()->get()[0];
        $i = 1;
        $sortOptions = [
            [$user->userSettings->sort_method, $user->userSettings->sort_order],
        ];
        if ($user->userSettings->sort_method != 'artist') {
            $sortOptions[] = ['artist', $user->userSettings->sort_order];
        }
        //todo: sort genre properly
        $releases = Release::all()->sortBy($sortOptions);
        $releases->each(function ($release) use (&$i) {
            $release->update([
                'shelf_order' => $i++,
            ]);
        });
    }
}
