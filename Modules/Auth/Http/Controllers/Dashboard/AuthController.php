<?php

namespace Modules\Auth\Http\Controllers\Dashboard;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }
/**
 * Show the application's login form.
 *
 * @return \Illuminate\View\View
 */
    public function showLoginForm()
    {
        return view('auth::login');
    }
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string|min:8',
        ], [

        ], [
            $this->username() => 'Username',
            'password' => 'Password',
        ]);
    }

    public function logout()
    {
        $this->guard()->logout();

        return redirect('/admin/login');
    }

    public function username()
    {
        return 'name';
    }
}
