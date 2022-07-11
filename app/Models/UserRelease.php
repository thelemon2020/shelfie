<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRelease extends Pivot
{
    use HasFactory;

    protected $table = 'release_user';

}
