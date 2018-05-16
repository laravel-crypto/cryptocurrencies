<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Litecoin.
 */
class LitecoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Litecoin());
    }

    public function getInvalidAddress()
    {
        return 'LbYmauLERxK1vyqJbB9J2MNsffsYkBSuV1';
    }

    public function getBalanceAddress()
    {
        return 'LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(1, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(1, $balance);
    }

    public function getBalanceAtBlock()
    {
        return 515900;
    }

    public function testBalanceAtBlockZero()
    {
        $balance = $this->currency->getBalanceAtBlock($this->getBalanceAddress(), 514900, $this->logger);
        $this->assertEquals(0, $balance);
    }

    public function doTestBalanceAtBlock($balance)
    {
        $this->assertEquals(1, $balance);
    }

    public function testInvalidAddress()
    {
        try {
            $balance = $this->currency->getBalance('invalid', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Not a valid address/i', $e->getMessage());
            $this->assertNotRegExp('/</i', $e->getMessage(), 'Should not have any HTML');
        }
    }

    public function testAddressNotSeen()
    {
        try {
            $balance = $this->currency->getBalance('LSja8VGwpDhhjVqkiZUPk2vDzQp6J8STa5', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Address not seen on the network/i', $e->getMessage());
            $this->assertNotRegExp('/</i', $e->getMessage(), 'Should not have any HTML');
        }
    }
}
