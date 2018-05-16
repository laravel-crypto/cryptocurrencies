<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency;

use Monolog\Logger;
use Openclerk\Currencies\BlockCurrency;
use Openclerk\Currencies\Cryptocurrency;
use Openclerk\Currencies\HashableCurrency;
use Openclerk\Currencies\DifficultyCurrency;

/**
 * Represents the Novacoin cryptocurrency.
 */
class Novacoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'nvc';
    }

    public function getName()
    {
        return 'Novacoin';
    }

    public function getURL()
    {
        return 'http://novacoin.org/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://novacoin.org/wiki/' => 'Novacoin Wiki',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == '4')
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
        return 'Novacoin Explorer';
    }

    public function getExplorerURL()
    {
        return 'https://explorer.novaco.in/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('https://explorer.novaco.in/address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\NovacoinExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\NovacoinExplorer();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\NovacoinExplorer();

        return $fetcher->getDifficulty($logger);
    }
}
