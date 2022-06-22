<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subgenre extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function releases()
    {
        return $this->belongsToMany(Release::class);
    }
}
