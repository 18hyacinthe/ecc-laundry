<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.auth.master');
    }

    public function home()
    {
        return view('admin.dashboard.common.dashboard');
    }
}
