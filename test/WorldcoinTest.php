<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Worldcoin.
 */
class WorldcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Worldcoin());
    }

    public function getInvalidAddress()
    {
        return 'WRhxyue7Nq27cKzwPfk5j4rAHJn75ArKe1';
    }

    public function getBalanceAddress()
    {
        return 'WRhxyue7Nq27cKzwPfk5j4rAHJn75ArKed';
    }

    public function doTestBalance($balance)
    {
        $this->assertGreaterThanOrEqual(0, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertGreaterThanOrEqual(2411775.2488575, $balance);
    }
}
