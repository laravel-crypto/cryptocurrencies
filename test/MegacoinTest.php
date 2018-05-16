<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Megacoin.
 */
class MegacoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Megacoin());
    }

    public function getInvalidAddress()
    {
        return 'MRQxyWELkiGQW8KgsyCnchdJseestpZnz1';
    }

    public function getBalanceAddress()
    {
        return 'MRQxyWELkiGQW8KgsyCnchdJseestpZnzo';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(100, $balance);
    }

    public function doTestBalanceWithConfirmations($balance)
    {
        $this->assertEquals(100, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(100, $balance);
    }

    public function testInvalidAddress()
    {
        try {
            $balance = $this->currency->getBalance('invalid', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Address is not valid/i', $e->getMessage());
        }
    }
}
