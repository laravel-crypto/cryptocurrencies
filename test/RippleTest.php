<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Ripple.
 */
class RippleTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Ripple());
    }

    public function getInvalidAddress()
    {
        return 'rHDmTYEot15DNF1hP2DPQqYP3KfNVpfyh1';
    }

    public function getBalanceAddress()
    {
        return 'rHDmTYEot15DNF1hP2DPQqYP3KfNVpfyhB';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(100.045596, $balance);
    }

    public function testMultiBalanceXRP()
    {
        $balances = $this->currency->getMultiBalances($this->getBalanceAddress(), $this->logger);
        $this->assertEquals(100.045596, $balances['xrp']);
    }

    public function testMultiBalanceCNY()
    {
        $balances = $this->currency->getMultiBalances($this->getBalanceAddress(), $this->logger);
        $this->assertEquals(9.7117, $balances['cny']);
    }

    public function testMultiBalanceUSD()
    {
        $balances = $this->currency->getMultiBalances($this->getBalanceAddress(), $this->logger);
        $this->assertEquals(0, $balances['usd']);
    }
}
