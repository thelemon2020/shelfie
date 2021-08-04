<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist',
        'title',
        'release_year',
        'genre',
        'thumbnail',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
