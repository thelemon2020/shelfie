<?php

namespace App\Http\Controllers\Release\NowPlaying;

use App\Models\Release;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class Index extends Controller
{
    public function __invoke()
    {
        return json_encode(Release::query()->where('id', Cache::get('now-playing'))->first());
    }
}
