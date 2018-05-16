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
 * Represents the Feathercoin cryptocurrency.
 */
class Feathercoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'ftc';
    }

    public function getName()
    {
        return 'Feathercoin';
    }

    public function getURL()
    {
        return 'https://www.feathercoin.com/';
    }

    public function getCommunityLinks()
    {
        return [
      'https://www.feathercoin.com/about/' => 'About Feathercoin',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == '6' || substr($address, 0, 1) == '7')
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

    public function getService()
    {
        return new Services\FeathercoinExplorer();
    }

    public function getExplorerName()
    {
        return $this->getService()->getExplorerName();
    }

    public function getExplorerURL()
    {
        return $this->getService()->getExplorerURL();
    }

    public function getBalanceURL($address)
    {
        return $this->getService()->getBalanceURL($address);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = $this->getService();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = $this->getService();

        return $fetcher->getBalance($address, $logger, true);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = $this->getService();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = $this->getService();

        return $fetcher->getDifficulty($logger);
    }
}
