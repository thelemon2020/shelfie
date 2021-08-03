<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function releases()
    {
        return $this->belongsToMany('App\Release', 'releases', 'genre','id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
