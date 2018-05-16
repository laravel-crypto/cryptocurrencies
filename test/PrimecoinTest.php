<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Primecoin.
 */
class PrimecoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Primecoin());
    }

    public function getInvalidAddress()
    {
        return 'AVDEwDdQGR4CLLqn2JAypC9zRVriyJadL1';
    }

    public function getBalanceAddress()
    {
        return 'AVDEwDdQGR4CLLqn2JAypC9zRVriyJadLz';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(363864.22914168, $balance);
    }

    /**
     * We can't actually test for invalid addresses using Coinplorer,
     * so we disable this test.
     */
    public function testInvalidBalance()
    {
        $this->assertEquals('Coinplorer', $this->currency->getExplorerName());
    }

    public function testZeroBalance()
    {
        $balance = $this->currency->getBalance('AUqro6Zi6KVJA43CA73ZWYrvagUUGZFD1A', $this->logger);
        $this->assertEquals(0, $balance);
    }
}
