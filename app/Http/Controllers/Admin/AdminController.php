<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
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
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function profiles()
    {
        return view('admin.profiles');
    }

    public function profileDetail()
    {
        return view('admin.profile-detail');
    }

    public function listCV(){
        return view('cv.index');
    }

    public function listCVProfile()
    {
        return view("cv.indexProfile");
    }
}
