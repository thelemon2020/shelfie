<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReleaseDetails extends Controller
{
    public function __invoke($id)
    {
        return response([], 200);
    }
}
