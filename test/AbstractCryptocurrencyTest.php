<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Tests;

use Monolog\Logger;
use Openclerk\Config;
use Monolog\Handler\NullHandler;
use Monolog\Handler\BufferHandler;
use Openclerk\Currencies\Currency;
use Monolog\Handler\ErrorLogHandler;

/**
 * Abstracts away common test functionality.
 */
abstract class AbstractCryptocurrencyTest extends \PHPUnit_Framework_TestCase
{
    public function __construct(Currency $currency)
    {
        $this->logger = new Logger('test');
        $this->currency = $currency;

        if ($this->isDebug()) {
            $this->logger->pushHandler(new BufferHandler(new ErrorLogHandler()));
        } else {
            $this->logger->pushHandler(new NullHandler());
        }

        Config::merge([
      $currency->getCode().'_confirmations' => 6,
      'get_contents_timeout' => 30,
    ]);
    }

    public function isDebug()
    {
        global $argv;
        if (isset($argv)) {
            foreach ($argv as $value) {
                if ($value === '--debug' || $value === '--verbose') {
                    return true;
                }
            }
        }

        return false;
    }

    abstract public function getBalanceAddress();

    abstract public function getInvalidAddress();

    abstract public function doTestBalance($balance);

    // optional test methods based on Currency superclasses
    public function doTestReceived($balance)
    {
        throw new \Exception('Need to implement doTestReceived() for a ReceivedCurrency');
    }

    public function getBalanceAtBlock()
    {
        throw new \Exception('Need to implement getBalanceAtBlock() for a BlockBalanceableCurrency');
    }

    public function getConfirmations()
    {
        return 6; // by default
    }

    public function doTestBalanceAtBlock($balance)
    {
        throw new \Exception('Need to implement doTestBalanceAtBlock() for a BlockBalanceableCurrency');
    }

    public function doTestBalanceWithConfirmations($balance)
    {
        throw new \Exception('Need to implement doTestBalanceWithConfirmations() for a ConfirmableCurrency');
    }

    public function testValid()
    {
        $this->assertTrue($this->currency->isValid($this->getBalanceAddress()), $this->getBalanceAddress().' should be valid');
        $this->assertFalse($this->currency->isValid('invalid'), 'invalid should be invalid');
    }

    public function testBalance()
    {
        $balance = $this->currency->getBalance($this->getBalanceAddress(), $this->logger);
        $this->doTestBalance($balance);
    }

    public function testReceived()
    {
        if ($this->currency instanceof \Openclerk\Currencies\ReceivedCurrency) {
            $balance = $this->currency->getReceived($this->getBalanceAddress(), $this->logger);
            $this->doTestReceived($balance);
        }
    }

    public function testBalanceAtBlock()
    {
        if ($this->currency instanceof \Openclerk\Currencies\BlockBalanceableCurrency) {
            $balance = $this->currency->getBalanceAtBlock($this->getBalanceAddress(), $this->getBalanceAtBlock(), $this->logger);
            $this->doTestBalanceAtBlock($balance);
        }
    }

    public function testBalanceWithConfirmations()
    {
        if ($this->currency instanceof \Openclerk\Currencies\ConfirmableCurrency) {
            $balance = $this->currency->getBalanceWithConfirmations($this->getBalanceAddress(), $this->getConfirmations(), $this->logger);
            $this->doTestBalanceWithConfirmations($balance);
        }
    }

    public function testInvalidBalance()
    {
        try {
            $balance = $this->currency->getBalance($this->getInvalidAddress(), $this->logger);
            $this->fail('Expected failure');
        } catch (\Openclerk\Currencies\BalanceException $e) {
            // expected
        }
    }

    public function testBlockCount()
    {
        if ($this->currency instanceof \Openclerk\Currencies\BlockCurrency) {
            $value = $this->currency->getBlockCount($this->logger);
            $this->assertGreaterThan(100, $value);
        }
    }

    public function expectedDifficulty()
    {
        return 10;
    }

    public function testDifficulty()
    {
        if ($this->currency instanceof \Openclerk\Currencies\DifficultyCurrency) {
            $value = $this->currency->getDifficulty($this->logger);
            $this->assertGreaterThan($this->expectedDifficulty(), $value);
        }
    }

    /**
     * Test that all URLs returned by {@link Currency#getBalanceURL()} are valid URLs and
     * can be fetched with a GET.
     */
    public function testValidPublicAddress()
    {
        $url = $this->currency->getBalanceURL($this->getBalanceAddress());
        $this->logger->info($url);
        $html = \Apis\Fetch::get($url);
    }
}
