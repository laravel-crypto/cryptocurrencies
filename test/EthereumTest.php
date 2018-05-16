<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Ethereum.
 */
class EthereumTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Ethereum());
    }

    public function getInvalidAddress()
    {
        return '0x2910543af39aba0cd09dbb2d50200b3e800a63d0';
    }

    public function getBalanceAddress()
    {
        return '0x2910543af39aba0cd09dbb2d50200b3e800a63d2';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(25610.670351616746038528, $balance);
    }

    public function doTestBalanceWithConfirmations($balance)
    {
        $this->assertEquals(9.88, $balance);
    }

    /**
     * We can't actually test for invalid addresses using Etherscan.io,
     * so we disable this test.
     */
    public function testInvalidBalance()
    {
        // empty
    }
}
