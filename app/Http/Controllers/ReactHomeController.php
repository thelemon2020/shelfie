<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReactHomeController extends Controller
{
    public function index()
    {
        return view('react-views/react-index');
    }
}
