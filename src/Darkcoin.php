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
use Openclerk\Currencies\BlockBalanceableCurrency;

/**
 * Represents the Darkcoin cryptocurrency.
 */
class Darkcoin extends Cryptocurrency implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency
{
    public function getCode()
    {
        return 'drk';
    }

    public function getName()
    {
        return 'Darkcoin';
    }

    public function getURL()
    {
        return 'https://www.darkcoin.io/';
    }

    public function getCommunityLinks()
    {
        return [
      'https://www.darkcoin.io/community/' => 'Darkcoin Community',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'X')
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
        return 'Darkcoin Explorer';
    }

    public function getExplorerURL()
    {
        return 'http://explorer.darkcoin.io/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('http://explorer.darkcoin.io/address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\DarkcoinExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\DarkcoinExplorer();

        return $fetcher->getBalance($address, $logger, true);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalanceAtBlock($address, $block, Logger $logger)
    {
        $fetcher = new Services\DarkcoinExplorer();

        return $fetcher->getBalanceAtBlock($address, $block, $logger);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\DarkcoinExplorer();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\DarkcoinExplorer();

        return $fetcher->getDifficulty($logger);
    }
}
