<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Hobonickels.
 */
class HobonickelsTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Hobonickels());
    }

    public function getInvalidAddress()
    {
        return 'F1KM3Z51GFKUgAgPQ3nGFKQNNCGErTqyo1';
    }

    public function getBalanceAddress()
    {
        return 'F1KM3Z51GFKUgAgPQ3nGFKQNNCGErTqyoP';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0.14037, $balance);
    }

    public function testInvalidAddress()
    {
        try {
            $balance = $this->currency->getBalance('invalid', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Not a valid address/i', $e->getMessage());
        }
    }

    public function expectedDifficulty()
    {
        // HBN seems to be a dead currency
        return 0.001;
    }
}
