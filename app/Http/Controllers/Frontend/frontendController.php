<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class frontendController extends Controller
{
    public function Frontend()
    {
        return view('frontend.index');
        # code...
    }
    //
}
