<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Feathercoin.
 */
class FeathercoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Feathercoin());
    }

    public function getInvalidAddress()
    {
        return '6yhuk17d9LcSgRkjidSoL5H8jNgx9KCA91';
    }

    public function getBalanceAddress()
    {
        return '6yhuk17d9LcSgRkjidSoL5H8jNgx9KCA9P';
    }

    public function doTestBalance($balance)
    {
        $this->assertEquals(16.27820373, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertEquals(16.27820373, $balance);
    }

    /**
     * We can't actually test for invalid addresses using Coinplorer,
     * so we disable this test.
     */
    public function testInvalidBalance()
    {
        $this->assertEquals('Coinplorer', $this->currency->getExplorerName());
    }

    public function expectedDifficulty()
    {
        return 2;
    }
}
