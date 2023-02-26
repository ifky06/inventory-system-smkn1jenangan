<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;

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
    public function username()
    {
        return 'username';
    }
    public function login(Request $request){
        $input = $request->all();
        $validator=Validator::make($request->all(),[
            'username'=>'required',
            'password' => 'required'
        ],[
            'username.required'=>'Username harus diisi',
            'password.required'=>'Password harus diisi',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        if(auth()->attempt(array('username'=>$input['username'], 'password'=>$input['password']))){
            Alert::toast('Login Berhasil', 'success');
            return redirect('/dashboard');
        }else{
            Alert::toast('Username atau Password Salah', 'error');
            return redirect()->route('login');
        }

    }
}
