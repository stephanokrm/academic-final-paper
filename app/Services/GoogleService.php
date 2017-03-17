<?php

namespace Academic\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Plus;
use Session;
use URL;

class GoogleService {

    public function authenticate() {
        $client = $this->getNewClient();
        if (Session::has('credentials')) {
            $accessToken = Session::get('credentials');
        } else {
            $parts = parse_url(URL::previous());
            parse_str($parts['query'], $query);
            $code = $query['code'];
            $accessToken = $client->authenticate($code);
            Session::put('credentials', $accessToken);
        }
        $client->setAccessToken($accessToken);
        if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            Session::put('credentials', $client->getAccessToken());
        }

        $this->saveProfileImageFromUser($client);
        return $client;
    }

    public function createAuthUrl() {
        $client = $this->getNewClient();
        return $client->createAuthUrl();
    }
    
    public function getCalendarService() {
        $client = $this->authenticate();
        return new Google_Service_Calendar($client);
    }

    private function getNewClient() {
        $client = new Google_Client();
        $client->setApplicationName('Academic');
        $client->addScope([
            Google_Service_Calendar::CALENDAR,
            Google_Service_Plus::PLUS_LOGIN,
            Google_Service_Plus::PLUS_ME,
            Google_Service_Plus::USERINFO_EMAIL,
            Google_Service_Plus::USERINFO_PROFILE
        ]);
        $client->setClientId('853157239818-rsl4k0s23joipal9li62p32s02uk65de.apps.googleusercontent.com');
        $client->setClientSecret('uCN_zH8cN5d6cRKk7Im2dX2o');
        $client->setRedirectUri('http://webacademico.canoas.ifrs.edu.br/~academic/');
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        return $client;
    }

    private function saveProfileImageFromUser(Google_Client $client) {
        $googlePlusService = new Google_Service_Plus($client);
        $person = $googlePlusService->people->get('me');
        $profileImage = $person->getImage()->getUrl();
        $user = Session::get('user');
        $google = $user->google;
        $google->profile_image = $profileImage;
        $google->save();
    }

    public function logout() {
        Session::forget('credentials');
    }

}
