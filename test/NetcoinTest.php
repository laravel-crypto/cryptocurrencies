<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Netcoin.
 */
class NetcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Netcoin());
    }

    public function getInvalidAddress()
    {
        return 'nMEkHkSaYLp7Aqjr8YSDsSvF4795LVmzi1';
    }

    public function getBalanceAddress()
    {
        return 'nMEkHkSaYLp7Aqjr8YSDsSvF4795LVmziQ';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(10.67430105, $balance);
    }

    public function getBalanceAtBlock()
    {
        return 260440;
    }

    public function doTestBalanceAtBlock($balance)
    {
        $this->assertEquals(10.67430105, $balance);
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
        // NET seems to be a dead currency
        return 0.001;
    }
}
