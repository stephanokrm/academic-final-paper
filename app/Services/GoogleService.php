<?php

namespace Academic\Services;

use Redirect;
use Session;
//
use Google_Client;
use Google_Service_Calendar;
//
use Academic\GoogleEmail;

class GoogleService {

    public function getClient() {
        $client = new Google_Client();
        $client->setApplicationName('Academic');
        $client->setClientId('853157239818-rsl4k0s23joipal9li62p32s02uk65de.apps.googleusercontent.com');
        $client->setClientSecret('uCN_zH8cN5d6cRKk7Im2dX2o');
        $client->setRedirectUri('http://webacademico.canoas.ifrs.edu.br/~academic/index.php/home');
        $client->setScopes(['email', Google_Service_Calendar::CALENDAR]);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        if (Session::has('credentials')) {
            $accessToken = Session::get('credentials');
        } else {
            if (isset($_GET['code'])) {
                $accessToken = $client->authenticate($_GET['code']);
                Session::put('credentials', $accessToken);
                $this->associateGoogleEmail($client);
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

    private function associateGoogleEmail(Google_Client $client) {
        $email = $client->verifyIdToken()->getAttributes()['payload']['email'];
        $user = Session::get('user');

        if (!isset($user->googleEmail->email)) {
            $googleEmail = new GoogleEmail();
            $googleEmail->email = $email;
            $googleEmail->active = 'true';
            $user->googleEmail()->associate($googleEmail);
            $user->save();
        }
    }

    public function logout() {
        Session::forget('credentials');
        Session::forget('authUrl');
    }

    public function translateMessage($message) {
        switch ($message) {
            case 'Cannot change your own access level.':
                return 'Não pode mudar o seu próprio nível de acesso.';
            case 'Forbidden':
                return 'Proibido';
            case 'Backend Error':
                return 'O serviço Google não está disponível no momento.';
            case 'Not Found':
                return 'Não encontrado.';
            default:
                return $message;
        }
    }
}
