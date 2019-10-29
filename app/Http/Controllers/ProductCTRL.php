<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductCTRL extends Controller
{
    public function index()
    {
        return view('realtime');
    }
}
