<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function credentials(Request $request)
    {
        $return = ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 1];
        if (env('DEPLOYMENT_ENV') == 'POS'){
            $return = ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 1, 'role' => [2,3]];
        } else if (env('DEPLOYMENT_ENV') == 'CHEFF'){
            $return = ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 1, 'role' => 4];
        } else if (env('DEPLOYMENT_ENV') == 'BARISTA'){
            $return = ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 1, 'role' => 5];
        };
        return $return;
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => "Username or Password is Incorrect."];

        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        $auth_user_role = 1;
        if (env('DEPLOYMENT_ENV') == 'POS'){
            $auth_user_role = [2,3];
        } else if (env('DEPLOYMENT_ENV') == 'CHEFF'){
            $auth_user_role = 4;
        };

        if ($user && \Hash::check($request->password, $user->password) && $user->role != $auth_user_role) {
            $errors = [$this->username() => "Username or Password is Incorrect"];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
}
