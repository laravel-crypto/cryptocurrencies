<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of NuShares.
 */
class NuSharesTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\NuShares());
    }

    public function getInvalidAddress()
    {
        return 'STiiSEVpMhBug74F4V9dTQvBT3YsLAJJb1';
    }

    public function getBalanceAddress()
    {
        return 'STiiSEVpMhBug74F4V9dTQvBT3YsLAJJby';
    }

    public function doTestBalance($balance)
    {
        $this->assertGreaterThan(9292000, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertGreaterThan(9292000, $balance);
    }

    public function testInvalidAddress()
    {
        try {
            $balance = $this->currency->getBalance('invalid', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Address does not exist/i', $e->getMessage());
        }
    }
}
