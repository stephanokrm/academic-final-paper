<?php

namespace Academic\Http\Controllers\Auth;

use Illuminate\Http\Request;
//
use Academic\Http\Controllers\Controller;
use Academic\Services\AuthService;
use Academic\Services\GoogleService;
use Academic\Team;

class AuthController extends Controller {

    private $service;
    protected $username = 'username';

    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

    // use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */
    public function __construct(AuthService $service) {
        $this->middleware('guest', ['except' => ['logout', 'register']]);
        $this->service = $service;
    }

    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $user = $this->service->login($request);
        return isset($user) ? redirect()->route('auth.register') : redirect()->route('home.index')->withMessage('Login efetuado com sucesso.');
    }

    public function logout() {
        $googleService = new GoogleService();
        $googleService->logout();
        $this->service->logout();
        return redirect()->route('auth.index');
    }

    public function register() {
        $teams = Team::all();
        return view('auth.register')->withTeams($teams);
    }

}
