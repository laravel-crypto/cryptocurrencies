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
use Openclerk\Currencies\BlockBalanceableCurrency;

/**
 * Represents the Dogecoin cryptocurrency.
 */
class Dogecoin extends Cryptocurrency implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'dog';
    }

    public function getName()
    {
        return 'Dogecoin';
    }

    public function getAbbr()
    {
        return 'DOGE';
    }

    public function getURL()
    {
        return 'http://dogecoin.com/';
    }

    public function getCommunityLinks()
    {
        return [
      'https://dogecoin.org/' => 'Dogecoin community',
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
        return 'DogeChain';
    }

    public function getExplorerURL()
    {
        return 'https://dogechain.info/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('https://dogechain.info/address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\Dogechain();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\Dogechain();

        return $fetcher->getBalance($address, $logger, true);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalanceAtBlock($address, $block, Logger $logger)
    {
        $fetcher = new Services\Dogechain();

        return $fetcher->getBalanceAtBlock($address, $block, $logger);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\Dogechain();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\Dogechain();

        return $fetcher->getDifficulty($logger);
    }
}
