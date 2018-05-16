<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Vertcoin.
 */
class VertcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Vertcoin());
    }

    public function getInvalidAddress()
    {
        return 'Vcvbcvbcvbcvbcvbxqv7xHV5oQH8iPhTr1';
    }

    public function getBalanceAddress()
    {
        return 'ViUu1mC7rQGFb54ixqv7xHV5oQH8iPhTrd';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(3301.70255715, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(158456.3730927, $balance);
    }
}
