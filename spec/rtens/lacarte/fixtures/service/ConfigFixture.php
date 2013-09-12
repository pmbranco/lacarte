<?php
namespace spec\rtens\lacarte\fixtures\service;

use rtens\lacarte\core\Configuration;
use rtens\mockster\Mock;
use rtens\mockster\MockFactory;
use spec\rtens\lacarte\TestCase;
use watoki\factory\Factory;
use watoki\scrut\Fixture;

class ConfigFixture extends Fixture {

    public static $CLASS = __CLASS__;

    /** @var Mock */
    private $config;

    public function __construct(TestCase $test, Factory $factory) {
        parent::__construct($test, $factory);

        $this->config = $factory->getInstance(Configuration::Configuration);
    }

    public function givenTheApiTokenIs($string) {
        $this->config->__mock()->method('getApiToken')->willReturn($string);
    }

}