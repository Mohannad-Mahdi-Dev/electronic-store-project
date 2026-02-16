<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //  $user = $request->user();
        // if (!$user || $user->role_id != 1) {
        //     abort(403, 'ليس لديك صلاحية الدخول');
        // }

        // return $next($request);
        return view('dsadmin.dashboard');
    }
}
