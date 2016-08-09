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

    public function __construct(AuthService $service) {
        $this->middleware('guest', ['except' => ['logout', 'register']]);
        $this->service = $service;
    }

    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $user = $this->service->login($request);
        if ($user) {
            if ($user->isTeacher()) {
                return redirect()->route('home.index')->withMessage('Login efetuado com sucesso.');
            }
            $teams = Team::all();
            return view('auth.register')->withTeams($teams)->withUser($user);
        }

        return redirect()->route('home.index')->withMessage('Login efetuado com sucesso.');
    }

    public function logout() {
        $googleService = new GoogleService();
        $googleService->logout();
        $this->service->logout();
        return redirect()->route('auth.index');
    }

}
