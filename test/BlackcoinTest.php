<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Blackcoin.
 */
class BlackcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Blackcoin());
    }

    public function getInvalidAddress()
    {
        return 'BGCiwF6J8VsMT6rQUiDvgjahWNC62nyZqZ';
    }

    public function getBalanceAddress()
    {
        return 'BGCiwF6J8VsMT6rQUiDvgjahWNC62nyZq3';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0.0, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertGreaterThan(106, $balance);
    }

    /**
     * We can't actually test for invalid addresses using Coinplorer,
     * so we disable this test.
     */
    public function testInvalidBalance()
    {
        $this->assertEquals('Chainz', $this->currency->getExplorerName());
    }
}
