<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Dogecoin.
 */
class DogecoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Dogecoin());
    }

    public function getInvalidAddress()
    {
        return 'D64vbPp9TvqQ67xc6we5GnEtcKqiTXfp11';
    }

    public function getBalanceAddress()
    {
        return 'D64vbPp9TvqQ67xc6we5GnEtcKqiTXfp1S';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(300, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(300, $balance);
    }

    public function getBalanceAtBlock()
    {
        return 104000;
    }

    public function doTestBalanceAtBlock($balance)
    {
        $this->assertEquals(0, $balance);
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

    public function testZeroBalance()
    {
        $balance = $this->currency->getBalance('D88CHfdvzegoTDkMb8ZpW6xe7mXK9dXDAY', $this->logger);
        $this->assertEquals(0, $balance);
    }
}
