<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sort_method',
        'wled_ip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
