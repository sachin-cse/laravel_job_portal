<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request){
        return view('frontend.index');
    }

    public function dashboard(Request $request){
        return view('dashboard');
    }
}
