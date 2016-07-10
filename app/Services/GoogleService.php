<?php

namespace Academic\Services;

use Redirect;
use Session;
//
use Google_Client;
use Google_Service_Calendar;

class GoogleService {

    public function getClient() {
        $client = new Google_Client();
        $client->setApplicationName('Academic');
        $client->setScopes(['email', Google_Service_Calendar::CALENDAR]);
        $client->setClientId('853157239818-rsl4k0s23joipal9li62p32s02uk65de.apps.googleusercontent.com');
        $client->setClientSecret('uCN_zH8cN5d6cRKk7Im2dX2o');
        $client->setRedirectUri('http://webacademico.canoas.ifrs.edu.br/~academic/index.php/home');
        $client->setAccessType('offline');

        if (Session::has('credentials')) {
            $accessToken = Session::get('credentials');
        } else {
            if (isset($_GET['code'])) {
                $accessToken = $client->authenticate($_GET['code']);
                Session::put('credentials', $accessToken);
            } else {
                $authUrl = $client->createAuthUrl();
                Session::put('authUrl', $authUrl);
                return Redirect::route('home.index');
            }
        }
        $client->setAccessToken($accessToken);

        if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            Session::put('credentials', $client->getAccessToken());
        }
        return $client;
    }

    public function logout() {
        Session::forget('credentials');
        Session::forget('authUrl');
    }

    // public function setGoogleClient() {
    // $client = new Google_Client();
    // $client->setApplicationName('Academic');
    // $client->setScopes(['email', Google_Service_Calendar::CALENDAR]);
    // $client->setClientId('853157239818-rsl4k0s23joipal9li62p32s02uk65de.apps.googleusercontent.com');
    // $client->setClientSecret('uCN_zH8cN5d6cRKk7Im2dX2o');
    // $client->setRedirectUri('http://webacademico.canoas.ifrs.edu.br/~academic/index.php/home');
    // $client->setAccessType('offline');
    //     return $client;
    // }
    // public function authenticate() {
    //     $client = $this->setGoogleClient();
    //     if (Session::has('credentials')) {
    //         $this->setAccessToken($client);
    //     } else {
    //         $this->verifyCode($client);
    //     }
    // }
    // private function setAccessToken(Google_Client $client) {
    //     $accessToken = Session::get('credentials');
    //     $client->setAccessToken($accessToken);
    //     $this->verifyAccessToken($client);
    //     Session::put('client', $client);
    // }
    // private function verifyCode(Google_Client $client) {
    //     if (Session::has('code')) {
    //         Session::forget('authUrl');
    //         $accessToken = $client->authenticate(Session::get('code'));
    //         Session::put('credentials', $accessToken);
    //         $this->setAccessToken($client);
    //     } else {
    //         $authUrl = $client->createAuthUrl();
    //         Session::put('authUrl', $authUrl);
    //     }
    // }
    // private function verifyAccessToken(Google_Client $client) {
    //     if ($client->isAccessTokenExpired()) {
    //         $client->refreshToken($client->getRefreshToken());
    //         Session::put('credentials', $client->getAccessToken());
    //     }
    // }
    // private function associateGoogleEmail(Google_Client $client) {
    //     $email = $client->verifyIdToken()->getAttributes()['payload']['email'];
    //     $studentService = new StudentService();
    //     $studentService->associateGoogleEmail($email);
    // }
    // public function getCalendarService() {
    //     return $this->calendarService;
    // }
    // public function forgetSession() {
    //     Session::remove('access_token');
    //     Session::remove('auth_url');
    //     Session::remove('calendar_list');
    //     Session::remove('credentials');
    // }
    // public function translateMessage($message) {
    //     switch ($message) {
    //         case 'Cannot change your own access level.':
    //             return 'Não pode mudar o seu próprio nível de acesso.';
    //         case 'Forbidden':
    //             return 'Proibido';
    //         case 'Backend Error':
    //             return 'O serviço Google não está disponível no momento.';
    //         case 'Not Found':
    //             return 'Não encontrado.';
    //         default:
    //             return $message;
    //     }
    // }
}
