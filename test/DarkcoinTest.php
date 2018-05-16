<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Darkcoin.
 */
class DarkcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Darkcoin());
    }

    public function getInvalidAddress()
    {
        return 'Xuu3Rg1oWubR2y4B828poADTdxAGuCGFS1';
    }

    public function getBalanceAddress()
    {
        return 'Xuu3Rg1oWubR2y4B828poADTdxAGuCGFSd';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(0.0129, $balance);
    }

    public function getBalanceAtBlock()
    {
        return 140000;
    }

    public function doTestBalanceAtBlock($balance)
    {
        $this->assertEquals(0.0129, $balance);
    }

    public function testInvalidAddress()
    {
        try {
            $balance = $this->currency->getBalance('invalid', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Not a valid address/i', $e->getMessage());
        }
    }
}
