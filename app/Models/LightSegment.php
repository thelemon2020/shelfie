<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(Release::class);
    }
}