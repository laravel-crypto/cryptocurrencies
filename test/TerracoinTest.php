<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Terracoin.
 */
class TerracoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Terracoin());
    }

    public function getInvalidAddress()
    {
        return '15K9eY6bmu3hhaRqp8vcNknq7G1T59oJF1';
    }

    public function getBalanceAddress()
    {
        return '15K9eY6bmu3hhaRqp8vcNknq7G1T59oJFR';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(404971.68357502, $balance);
    }

    /**
     * We can't actually test for invalid addresses using Coinplorer,
     * so we disable this test.
     */
    public function testInvalidBalance()
    {
        $this->assertEquals('Coinplorer', $this->currency->getExplorerName());
    }
}
