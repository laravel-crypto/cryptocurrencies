<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Namecoin.
 */
class NamecoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Namecoin());
    }

    public function getInvalidAddress()
    {
        return 'N7ZdQURKz79Zt7KHJh1nMDsjNvYdnASAM1';
    }

    public function getBalanceAddress()
    {
        return 'N7ZdQURKz79Zt7KHJh1nMDsjNvYdnASAMY';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(0.27, $balance);
    }

    public function getBalanceAtBlock()
    {
        return 104000;
    }

    public function doTestBalanceAtBlock($balance)
    {
        $this->assertEquals(0.27, $balance);
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
