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
 * Represents the Namecoin cryptocurrency.
 */
class Namecoin extends Cryptocurrency implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'nmc';
    }

    public function getName()
    {
        return 'Namecoin';
    }

    public function getURL()
    {
        return 'http://dot-bit.org/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://dot-bit.org/Namecoin' => 'What is Namecoin?',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'M' || substr($address, 0, 1) == 'N')
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

    public function getExplorerName()
    {
        return 'DarkGameX';
    }

    public function getExplorerURL()
    {
        return 'http://darkgamex.ch:2751/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('http://darkgamex.ch:2751/address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\NamecoinExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalanceAtBlock($address, $block, Logger $logger)
    {
        $fetcher = new Services\NamecoinExplorer();

        return $fetcher->getBalanceAtBlock($address, $block, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\NamecoinExplorer();

        return $fetcher->getBalance($address, $logger, true);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\NamecoinExplorer();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\NamecoinExplorer();

        return $fetcher->getDifficulty($logger);
    }
}
