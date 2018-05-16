<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Vericoin.
 */
class VericoinTest extends AbstractCryptocurrencyTest
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Vericoin());
    }

    public function getInvalidAddress()
    {
        return 'VHFTkykgXLm4Tnp7qk3VdAzY16Gjyd5vq1';
    }

    public function getBalanceAddress()
    {
        return 'VHFTkykgXLm4Tnp7qk3VdAzY16Gjyd5vqm';
    }

    public function doTestBalance($balance)
    {
        $this->assertGreaterThan(3000, $balance);
    }

    public function doTestReceived($balance)
    {
        $this->assertGreaterThanOrEqual(1551335.95566986, $balance);
    }

    public function expectedDifficulty()
    {
        // VRC seems to be a dead currency
        return 0.001;
    }

    /**
     * We can't actually test for invalid addresses using Chainz,
     * so we disable this test.
     */
    public function testInvalidBalance()
    {
        $this->assertEquals('Chainz', $this->currency->getExplorerName());
    }
}
