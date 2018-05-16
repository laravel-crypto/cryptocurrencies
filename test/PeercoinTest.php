<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Peercoin.
 */
class PeercoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Peercoin());
    }

    public function getInvalidAddress()
    {
        return 'PNGYQH5aSNDKCHSroXL2HqgDJTZab1mhT1';
    }

    public function getBalanceAddress()
    {
        return 'PNGYQH5aSNDKCHSroXL2HqgDJTZab1mhTQ';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(9.88, $balance);
    }

    public function doTestBalanceWithConfirmations($balance)
    {
        $this->assertEquals(9.88, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(9.88, $balance);
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
