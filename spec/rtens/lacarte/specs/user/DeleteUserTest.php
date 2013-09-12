<?php
namespace spec\rtens\lacarte\specs\user;

use rtens\mockster\MockFactory;
use spec\rtens\lacarte\fixtures\component\user\ListComponentFixture;
use spec\rtens\lacarte\fixtures\service\SessionFixture;
use spec\rtens\lacarte\fixtures\model\UserFixture;
use spec\rtens\lacarte\TestCase;

/**
 * @property UserFixture user
 * @property SessionFixture session
 * @property ListComponentFixture component
 */
class DeleteUserTest extends TestCase {

    function testDeleteAUser() {
        $this->user->givenTheUser('Bart Simpson');
        $this->user->givenTheUser('Lisa Simpson');
        $this->session->givenIAmLoggedInAsAdmin();

        $this->component->whenIDeleteTheUser('Bart Simpson');

        $this->user->thenThereShouldBe_Users(1);
        $this->user->thenThereShouldBeAUserWithTheTheName('Lisa Simpson');
    }

    function testNotAdmin() {
        $this->user->givenTheUser('Bart Simpson');

        $this->component->whenIDeleteTheUser('Bart Simpson');

        $this->component->thenIShouldBeRedirectedTo('../order/list.html');
    }

}