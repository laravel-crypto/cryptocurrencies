<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Digitalcoin.
 */
class DigitalcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Digitalcoin());
    }

    public function getInvalidAddress()
    {
        return 'D7BtQraYNfdXoUwenwrN3ivMSgncsS2mG1';
    }

    public function getBalanceAddress()
    {
        return 'D7BtQraYNfdXoUwenwrN3ivMSgncsS2mG8';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(421.4, $balance);
    }

    public function doTestBalanceWithConfirmations($balance)
    {
        $this->assertEquals(421.4, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(552.5, $balance);
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
