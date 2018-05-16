<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Ixcoin.
 */
class IxcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Ixcoin());
    }

    public function getInvalidAddress()
    {
        return 'xowXLgLhWGNGr5q12TwggynR4z6RbvtSH1';
    }

    public function getBalanceAddress()
    {
        return 'xowXLgLhWGNGr5q12TwggynR4z6RbvtSHz';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(13.23873833, $balance);
    }

    public function getBalanceAtBlock()
    {
        return 239400;
    }

    public function doTestBalanceAtBlock($balance)
    {
        $this->assertEquals(13.23873833, $balance);
    }
}
