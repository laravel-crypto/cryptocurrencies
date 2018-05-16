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
 * Represents the Vertcoin cryptocurrency.
 */
class Vertcoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'vtc';
    }

    public function getName()
    {
        return 'Vertcoin';
    }

    public function getURL()
    {
        return 'http://www.vertcoin.org/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://vertcoinforum.com/' => 'Vertcoin Forum',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'V')
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
        return 'Vertcoin Block Explorer';
    }

    public function getExplorerURL()
    {
        return 'http://vtc.sovereignshare.com/exp/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('http://vtc.sovereignshare.com/exp/#/vtc/address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\VertcoinExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\VertcoinExplorer();

        return $fetcher->getBalance($address, $logger, true);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\VertcoinExplorer();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\VertcoinExplorer();

        return $fetcher->getDifficulty($logger);
    }
}
