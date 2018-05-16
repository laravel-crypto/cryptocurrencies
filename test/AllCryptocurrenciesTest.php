<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Tests the collection of defined cryptocurrencies for various
 * release tests based on {@code currencies.json}.
 */
class AllCryptocurrenciesTest extends \PHPUnit_Framework_TestCase
{
    public function testCodeUniqueness()
    {
        foreach ($this->getCurrencies() as $key => $classname) {
            $instance = new $classname;
            $this->assertUnique($instance->getCode(), $instance);
        }
    }

    public function testAbbrUniqueness()
    {
        foreach ($this->getCurrencies() as $key => $classname) {
            $instance = new $classname;
            $this->assertUnique($instance->getAbbr(), $instance);
        }
    }

    public function testNameUniqueness()
    {
        foreach ($this->getCurrencies() as $key => $classname) {
            $instance = new $classname;
            $this->assertUnique($instance->getName(), $instance);
        }
    }

    public function getCurrencies()
    {
        return json_decode(file_get_contents(__DIR__.'/../currencies.json'), true /* assoc */);
    }

    public function setUp()
    {
        $this->unique_array = [];
    }

    public function tearDown()
    {
        $this->unique_array = null;
    }

    public function assertUnique($key, $instance)
    {
        if (isset($this->unique_array[$key])) {
            $this->fail("Found unique code '$key' twice for ".get_class($instance).' and '.get_class($this->unique_array[$key]));
        }
        $this->unique_array[$key] = $instance;
    }
}
