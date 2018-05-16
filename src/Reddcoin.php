<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency;

use Monolog\Logger;
use Openclerk\Currencies\BlockCurrency;
use Openclerk\Currencies\Cryptocurrency;
use Openclerk\Currencies\ReceivedCurrency;
use Openclerk\Currencies\DifficultyCurrency;

/**
 * Represents the Reddcoin cryptocurrency.
 */
class Reddcoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ReceivedCurrency
{
    public function getCode()
    {
        return 'rdd';
    }

    public function getName()
    {
        return 'Reddcoin';
    }

    public function getURL()
    {
        return 'https://www.reddcoin.com/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://www.reddit.com/r/reddcoin' => '/r/reddcoin',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'R')
        && preg_match('#^[A-Za-z0-9]+$#', $address)) {
            return true;
        }

        return false;
    }

    public function hasExplorer()
    {
        return true;
    }

    public function getExplorerName()
    {
        return 'Reddsight';
    }

    public function getExplorerURL()
    {
        return 'http://live.reddcoin.com/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('http://live.reddcoin.com/address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\ReddcoinExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\ReddcoinExplorer();

        return $fetcher->getBalance($address, $logger, true);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\ReddcoinExplorer();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\ReddcoinExplorer();

        return $fetcher->getDifficulty($logger);
    }
}
