<?php

namespace App\Http\Controllers\Lights\TurnOn;

use App\Http\Controllers\Controller;
use App\Models\LightSegment;

class Segments extends Controller
{
    public function __invoke()
    {
        return LightSegment::turnOnAllIndividualSegments();
    }
}
