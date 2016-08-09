<?php

namespace Page;

class CalendarCreatePage {

    // include url of current page
    public static $URL = '/calendarios/criar';
    public static $summary = 'input[name="summary"]';
    public static $inviteAll = 'input[name="invite_all"]';
    public static $role = 'input[name="role"]';
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

    public function enterCalendarCreatePage() {
        $this->I->amOnPage(self::$URL);
    }

    public function fillSummaryField($summary) {
        $this->I->scrollTo(self::$summary);
        $this->I->fillField(self::$summary, $summary);
    }

    public function checkInviteOption() {
        $this->I->scrollTo(self::$inviteAll);
        $this->I->click(self::$inviteAll);
    }

    public function checkRoleOption() {
        $this->I->scrollTo(self::$role);
        $this->I->click(self::$role);
    }

    public function setI($I) {
        $this->I = $I;
    }

}
