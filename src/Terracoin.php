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
 * Represents the Terracoin cryptocurrency.
 */
class Terracoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'trc';
    }

    public function getName()
    {
        return 'Terracoin';
    }

    public function getURL()
    {
        return 'http://terracoin.org/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://terracoin.sourceforge.net/about.html' => 'About Terracoin',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && ((substr($address, 0, 1) == '1' || substr($address, 0, 1) == '3'))
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
        return 'sha256';
    }

    public function hasExplorer()
    {
        return true;
    }

    public function getService()
    {
        return new Services\TerracoinExplorer();
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
