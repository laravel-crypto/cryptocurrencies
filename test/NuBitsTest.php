<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of NuBits.
 */
class NuBitsTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\NuBits());
    }

    public function getInvalidAddress()
    {
        return 'BFree3gZJDHm1u2VQw4JyTDsF44sj9UcN1';
    }

    public function getBalanceAddress()
    {
        return 'BFree3gZJDHm1u2VQw4JyTDsF44sj9UcNr';
    }

    public function doTestBalance($balance)
    {
        $this->assertGreaterThan(0.25, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertGreaterThan(1659.0918, $balance);
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
