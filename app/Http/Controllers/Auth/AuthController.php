<?php 

namespace Academic\Http\Controllers\Auth;

use Academic\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use Academic\Services\AuthService;

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
	public function __construct(Guard $auth, Registrar $registrar, AuthService $service)
	{
		$this->middleware('guest', ['except' => 'logout']);
		$this->service = $service;
	}

	public function index() {
		return view('auth.login');
	}

	public function login(Request $request) {
		$this->service->login($request);
		return redirect()->route('home.index')->withMessage('Login efetuado com sucesso.');
	}

	public function logout() {
		$this->service->logout();
		return redirect()->route('auth.index');
	}

}
