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
}
