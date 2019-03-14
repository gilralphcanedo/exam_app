<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use Auth;

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
        $userID = Auth::user()->id;
        $exams = Exam::with('users')->where('id',$userID)->paginate(5);
        return view('home', compact('exams'));
    }
}
