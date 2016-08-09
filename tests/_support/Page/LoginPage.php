<?php

namespace Page;

class LoginPage {

    // include url of current page
    public static $URL = '/login';
    public static $username = 'input[name="username"]';
    public static $password = 'input[name="password"]';
    public static $enter = 'button[type="submit"]';
    private $I;

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param) {
        return static::$URL . $param;
    }

    public function enterLoginPage() {
        $this->I->amOnPage(self::$URL);
    }

    public function fillUsernameField($username) {
        $this->I->scrollTo(self::$username);
        $this->I->fillField(self::$username, $username);
    }

    public function fillPasswordField($password) {
        $this->I->scrollTo(self::$password);
        $this->I->fillField(self::$password, $password);
    }

    public function clickEnter() {
        $this->I->scrollTo(self::$enter);
        $this->I->click(self::$enter);
    }

    public function setI($I) {
        $this->I = $I;
    }

}
