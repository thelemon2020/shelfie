<?php

namespace App\Models;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    use EloquentJoin;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function releases()
    {
        return $this->hasMany(Release::class);
    }

}
