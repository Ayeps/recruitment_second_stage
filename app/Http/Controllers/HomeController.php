<?php

namespace App\Http\Controllers;

use App\Requester;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $request = Requester::whereRequester_id(Auth::user()->id)->get();
        $received = Requester::whereRecipient_id(Auth::user()->id)->whereStatus(3)->get();

        $users = User::all();
        return view('home')->withRequests($request)->withUsers($users)->withReceived($received);

    }

    public function users()
    {
        $users = User::all();
        return view('admin.user.index')->withUsers($users);
    }

    public function create()
    {

        return view('admin.user.create_edit');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create(['name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role' => $request->get('role')]);
        flash('User Registered');
        return redirect()->route('users');
    }
}
