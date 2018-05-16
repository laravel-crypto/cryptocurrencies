<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Viacoin.
 */
class ViacoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Viacoin());
    }

    public function getInvalidAddress()
    {
        return 'VxpV5duYe1pUmkQjwzeg8mfficUzfPEXE1';
    }

    public function getBalanceAddress()
    {
        return 'VxpV5duYe1pUmkQjwzeg8mfficUzfPEXEV';
    }

    public function doTestBalance($balance)
    {
        $this->assertGreaterThan(100, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertGreaterThanOrEqual(256.28689524, $balance);
    }

    /**
     * We can't actually test for invalid addresses using Chainz,
     * so we disable this test.
     */
    public function testInvalidBalance()
    {
        $this->assertEquals('Chainz', $this->currency->getExplorerName());
    }
}
