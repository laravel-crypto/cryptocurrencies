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

/**
 * Represents the Worldcoin cryptocurrency.
 */
class Worldcoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'wdc';
    }

    public function getName()
    {
        return 'Worldcoin';
    }

    public function getURL()
    {
        return 'http://www.worldcoinalliance.net/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://www.worldcoinalliance.net/worldcoin-features-specifications-advantages/' => 'Why Worldcoin?',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'W')
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
        return 'Worldcoin Explorer';
    }

    public function getExplorerURL()
    {
        return 'http://www.worldcoinexplorer.com';
    }

    public function getBalanceURL($address)
    {
        return sprintf('http://www.worldcoinexplorer.com/Explorer/Address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\WorldcoinExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\WorldcoinExplorer();

        return $fetcher->getBalance($address, $logger, true);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\WorldcoinExplorer();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\WorldcoinExplorer();

        return $fetcher->getDifficulty($logger);
    }
}
