<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency;

use Monolog\Logger;
use Openclerk\Currencies\BlockCurrency;
use Openclerk\Currencies\Cryptocurrency;
use Openclerk\Currencies\HashableCurrency;
use Openclerk\Currencies\ReceivedCurrency;
use Openclerk\Currencies\DifficultyCurrency;
use Openclerk\Currencies\ConfirmableCurrency;

/**
 * Represents the Digitalcoin cryptocurrency.
 */
class Digitalcoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ConfirmableCurrency, ReceivedCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'dgc';
    }

    public function getName()
    {
        return 'Digitalcoin';
    }

    public function getURL()
    {
        return 'http://digitalcoin.co/en/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://digitalcoin.co/quick-start/' => 'Digitalcoin Quick Start',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'D')
        && preg_match('#^[A-Za-z0-9]+$#', $address)) {
            return true;
        }

        return false;
    }

    /**
     * Get the main algorithm used by this currency for hashing, as a
     * code from {@link HashAlgorithm#getCode()}.
     */
    public function getAlgorithm()
    {
        return 'scrypt';
    }

    public function hasExplorer()
    {
        return true;
    }

    public function getExplorerName()
    {
        return 'Blockr.io';
    }

    public function getExplorerURL()
    {
        return 'http://dgc.blockr.io/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('http://dgc.blockr.io/address/info/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\DigitalcoinBlockr();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\DigitalcoinBlockr();

        return $fetcher->getBalance($address, $logger, true);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalanceWithConfirmations($address, $confirmations, Logger $logger)
    {
        $fetcher = new Services\DigitalcoinBlockr();

        return $fetcher->getBalanceWithConfirmations($address, $confirmations, $logger);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\DigitalcoinBlockr();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\DigitalcoinBlockr();

        return $fetcher->getDifficulty($logger);
    }
}
