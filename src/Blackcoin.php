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
 * Represents the Blackcoin cryptocurrency.
 */
class Blackcoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ReceivedCurrency
{
    public function getCode()
    {
        return 'bc1';
    }

    public function getName()
    {
        return 'Blackcoin';
    }

    public function getAbbr()
    {
        return 'BLK';
    }

    public function getURL()
    {
        return 'http://www.blackcoin.co/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://www.blackcoin.co/' => 'What is Blackcoin?',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'B')
        && preg_match('#^[A-Za-z0-9]+$#', $address)) {
            return true;
        }

        return false;
    }

    public function hasExplorer()
    {
        return true;
    }

    public function getService()
    {
        return new Services\BlackcoinExplorer();
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
