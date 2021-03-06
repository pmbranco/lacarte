<?php
namespace spec\rtens\lacarte\fixtures\resource;

use rtens\lacarte\WebResource;
use spec\rtens\lacarte\Specification;
use watoki\curir\http\Url;
use watoki\curir\responder\Presenter;
use watoki\curir\Responder;
use watoki\curir\responder\Redirecter;
use watoki\factory\Factory;
use watoki\scrut\Fixture;

abstract class ResourceFixture extends Fixture {

    /** @var Responder */
    protected $responder;

    protected $component;

    abstract protected function getComponentClass();

    public function __construct(Specification $spec, Factory $factory) {
        parent::__construct($spec, $factory);

        $root = $factory->getInstance(WebResource::$CLASS, array(
            'url' => Url::parse('http://lacarte'),
            'parent' => null
        ));

        $this->component = $factory->getInstance($this->getComponentClass(), array(
            'url' => Url::parse('http://lacarte'),
            'parent' => $root
        ));
    }

    public function thenIShouldBeRedirectedTo($url) {
        $this->spec->assertTrue($this->responder instanceof Redirecter, 'Not a Redirecter');
        if ($this->responder instanceof Redirecter) {
            $this->spec->assertEquals($url, $this->responder->getTarget()->toString());
        }
    }

    protected function getFieldIn($string, $field) {
        $this->spec->assertTrue(is_array($field), $string . ' is not an array');

        foreach (explode('/', $string) as $key) {
            if (!$field || !array_key_exists($key, $field)) {
                throw new \Exception("Could not find '$key' in " . json_encode($field));
            }
            $field = $field[$key];
        }
        return $field;
    }

    protected function getField($string) {
        $this->spec->assertTrue($this->responder instanceof Presenter, 'Not a Presenter');
        if ($this->responder instanceof Presenter) {
            return $this->getFieldIn($string, $this->responder->getModel());
        }
        return null;
    }

}