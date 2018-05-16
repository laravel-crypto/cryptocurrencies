<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Storjcoin.
 */
class StorjcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Storjcoin());
    }

    public function getInvalidAddress()
    {
        return '16WhhnUUCZVvszFxsaCG3d6v77Qin1LErz';
    }

    public function getBalanceAddress()
    {
        return '1EJf7RhWvb1LPMECiSt6aS3RpD7mfJQNaR';
    }

    public function doTestBalance($balance)
    {
        $this->assertGreaterThanOrEqual(300, $balance);
    }
}
