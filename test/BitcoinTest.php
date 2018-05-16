<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Bitcoin.
 */
class BitcoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Bitcoin());
    }

    public function getInvalidAddress()
    {
        return '1MbknviVk2tD6rFvDdiS1W6w4NJSfKEJG5';
    }

    public function getBalanceAddress()
    {
        return '17eTMdqaFRSttfBYB9chKEzHubECZPTS6p';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(0.0301, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(0.0301, $balance);
    }

    public function doTestBalanceWithConfirmations($balance)
    {
        $this->assertEquals(0.0301, $balance);
    }

    public function getBalanceAtBlock()
    {
        return $this->currency->getBlockCount($this->logger) - 100;
    }

    public function doTestBalanceAtBlock($balance)
    {
        $this->assertEquals(0.0301, $balance);
    }

    public function testInvalidChecksum()
    {
        try {
            $balance = $this->currency->getBalance('1MbknviVk2tD6rFvDdiS1W6w4NJSfKEJG5', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Checksum does not validate/i', $e->getMessage());
        }
    }

    public function testInvalidCharacter()
    {
        try {
            $balance = $this->currency->getBalance('17eTMdqaFRSttfBYB9chKEzHubECZPTS60', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Illegal character /i', $e->getMessage());
        }
    }

    public function testInvalidAddress()
    {
        try {
            $balance = $this->currency->getBalance('invalid', $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            $this->assertRegExp('/Illegal character /i', $e->getMessage());
        }
    }
}
