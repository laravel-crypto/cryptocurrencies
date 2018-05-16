<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Reddcoin.
 */
class ReddcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Reddcoin());
    }

    public function getInvalidAddress()
    {
        return 'RbRGNKehaWVZpjSKvjtGmWvEnfgSnV3Sj1';
    }

    public function getBalanceAddress()
    {
        return 'RbRGNKehaWVZpjSKvjtGmWvEnfgSnV3SjE';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(200000, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(932976790.3360204, $balance);
    }
}
