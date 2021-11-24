<?php

namespace App\Http\Controllers;

class LoadingPage extends Controller
{
    public function __invoke(){
        return view('loadingScreen');
    }
}
