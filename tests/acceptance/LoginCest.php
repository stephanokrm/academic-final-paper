<?php

use Page\LoginPage;

class LoginCest {

    private $loginPage;

    public function _before(AcceptanceTester $I, LoginPage $loginPage) {
        $this->loginPage = $loginPage;
        $this->loginPage->setI($I);
        $this->loginPage->enterLoginPage();
    }

    public function _after(AcceptanceTester $I) {
        //
    }

    public function shouldShowErrorMessageWhenUsernameRequiredValidationIsThrow(AcceptanceTester $I) {
        $this->loginPage->fillUsernameField('');
        $this->loginPage->fillPasswordField('Fames17016924');
        $this->loginPage->clickEnter();
        $I->see('O campo Matrícula é necessário.');
    }

    public function shouldShowErrorMessageWhenUsernameMaxValidationIsThrow(AcceptanceTester $I) {
        $this->loginPage->fillUsernameField('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
        $this->loginPage->fillPasswordField('Fames17016924');
        $this->loginPage->clickEnter();
        $I->see('O campo Matrícula deve conter no máximo 255 caracteres.');
    }

    public function shouldShowErrorMessageWhenPasswordRequiredValidationIsThrow(AcceptanceTester $I) {
        $this->loginPage->fillUsernameField('02060091');
        $this->loginPage->fillPasswordField('');
        $this->loginPage->clickEnter();
        $I->see('O campo Senha é necessário.');
    }

    public function shouldShowErrorMessageWhenPasswordMaxValidationIsThrow(AcceptanceTester $I) {
        $this->loginPage->fillUsernameField('02060091');
        $this->loginPage->fillPasswordField('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
        $this->loginPage->clickEnter();
        $I->see('O campo Senha deve conter no máximo 255 caracteres.');
    }

    public function shouldShowErrorMessageWhenUserNotFound(AcceptanceTester $I) {
        $this->loginPage->fillUsernameField('Username');
        $this->loginPage->fillPasswordField('Username');
        $this->loginPage->clickEnter();
        $I->see('Essas credenciais não correspondem aos nossos registros.');
    }

    public function shouldLoginAsStudent(AcceptanceTester $I) {
        $I->am('Student');
        $this->loginPage->fillUsernameField('02060091');
        $this->loginPage->fillPasswordField('Fames17016924');
        $this->loginPage->clickEnter();
        $I->see('Bem-vindo ao Academic');
    }

}
