<?php
namespace spec\rtens\lacarte\fixtures\component\order;

use rtens\lacarte\web\LaCarteModule;
use rtens\lacarte\web\order\SelectionComponent;
use spec\rtens\lacarte\fixtures\component\ComponentFixture;
use spec\rtens\lacarte\fixtures\model\OrderFixture;
use spec\rtens\lacarte\fixtures\service\SessionFixture;
use spec\rtens\lacarte\fixtures\model\UserFixture;
use spec\rtens\lacarte\TestCase;
use watoki\factory\Factory;

/**
 * @property SelectionComponent $component
 */
class SelectionComponentFixture extends ComponentFixture {

    public static $CLASS = __CLASS__;

    /** @var OrderFixture */
    private $order;

    public function __construct(TestCase $test, Factory $factory, LaCarteModule $root, SessionFixture $session) {
        parent::__construct($test, $factory, $root);
        $this->order = $test->useFixture(OrderFixture::$CLASS);
    }

    public function whenIOpenThePageForOrder($orderName) {
        $this->model = $this->component->doGet($this->order->getOrder($orderName)->id);
    }

    public function thenTheErrorMessageShouldBe($string) {
        $this->test->assertEquals($string, $this->getField('error'));
    }

    public function thenThereShouldBeNoErrorMessage() {
        $this->thenTheErrorMessageShouldBe(null);
    }

    public function thenTheNameOfTheOrderShouldBe($string) {
        $this->test->assertEquals($string, $this->getField('order/name'));
    }

    public function thenThereShouldBe_Selections($int) {
        $this->test->assertCount($int, $this->getField('order/selection'));
    }

    public function thenTheDateOfSelection_ShouldBe($int, $string) {
        $int--;
        $this->test->assertEquals($string, $this->getField("order/selection/$int/date"));
    }

    public function thenTheSelectedDishOfSelection_ShouldBe($int, $string) {
        $int--;
        $this->test->assertEquals($string, $this->getField("order/selection/$int/dish"));
    }

    public function thenSelection_ShouldHave_NotSelectedDish($int, $int1) {
        $int--;
        $this->test->assertCount($int1, $this->getField("order/selection/$int/notSelected"));
    }

    public function thenNotSelectedDish_OfSelection_ShouldBe($int, $int1, $string) {
        $int--;
        $int1--;
        $this->test->assertEquals($string, $this->getField("order/selection/$int1/notSelected/$int"));
    }

    protected function getComponentClass() {
        return SelectionComponent::$CLASS;
    }
}