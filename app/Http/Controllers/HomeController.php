<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Fascades\Auth;

class HomeController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
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
    public function login(Request $request){
        $input = $request->all();

        $this->validate($request,[
        'email' => 'required\email',
        'password'=>'required',
        ]);

        if(auth()->attempt(array('email'=>$input['email'],'password'=>$input['password']))){
            if(auth()->user()->roles_id == 1){
                return redirect()->route('admin.home');
            }else{
                return redirect()->route('home');
            }
        }else{
            return redirect()->route('login')->with('email','Email-address and Password are wrong');
        }
    }
    public function index()
    {
        $user=Auth::user();
        return view('home',compact('user'));
    }
}
