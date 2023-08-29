<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('inicio');
    }

    public function capcha_reload(){

        return response()->json(['captcha_img1' => captcha_img()]);

    }
}
