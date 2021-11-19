<?php

namespace App\Http\Controllers\Lights;

use App\Models\LightSegment;

class Toggle
{
    public function __invoke()
    {
        LightSegment::toggleLights();
    }
}
