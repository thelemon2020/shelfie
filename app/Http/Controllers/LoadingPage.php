<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoadingPage extends Controller
{
    public function __invoke(){
        return view('loadingScreen');
    }
}
