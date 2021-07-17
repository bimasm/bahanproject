<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginuser(Request $request)
    {
        request()->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ]);

            $credential = $request->only('email','password');

            if (Auth::attempt($credential)) {
                if (Auth::user()->level == 'admin') {
                    return redirect()->intended('admin');
                }elseif(Auth::user()->level == 'user'){
                    return redirect()->intended('home');
                }else{
                    return redirect()->back()->with('error','anda tidak memiliki akses');
                }
            }

        return redirect()->back()->with('error','anda tidak memiliki akses');
    }
}
