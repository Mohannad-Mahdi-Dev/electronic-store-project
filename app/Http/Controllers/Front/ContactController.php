<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.site.contact');
    }

    public function show()
    {

        return view('front.site.contact');
    }
}
