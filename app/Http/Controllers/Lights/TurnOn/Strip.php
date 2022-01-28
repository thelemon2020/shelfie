<?php

namespace App\Http\Controllers\Lights\TurnOn;

use App\Http\Controllers\Controller;
use App\Models\LightSegment;
use Illuminate\Http\Request;

class Strip extends Controller
{
    public function __invoke(Request $request)
    {
        return LightSegment::turnOnAllLightsSameColour($request->input('colour'));
    }
}
