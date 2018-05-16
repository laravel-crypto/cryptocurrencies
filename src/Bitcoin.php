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
use Openclerk\Currencies\ConfirmableCurrency;
use Openclerk\Currencies\BlockBalanceableCurrency;

/**
 * Represents the Bitcoin cryptocurrency.
 */
class Bitcoin extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ConfirmableCurrency, BlockBalanceableCurrency, ReceivedCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'btc';
    }

    public function getName()
    {
        return 'Bitcoin';
    }

    public function getURL()
    {
        return 'http://bitcoin.org/';
    }

    public function getCommunityLinks()
    {
        return [
      'https://www.weusecoins.com/en/' => 'What is Bitcoin?',
    ];
    }

    public function isValid($address)
    {
        // very simple check according to https://bitcoin.it/wiki/Address
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

    public function getExplorerName()
    {
        return 'Blockchain.info';
    }

    public function getExplorerURL()
    {
        return 'https://blockchain.info/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('https://blockchain.info/address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\BlockchainInfo();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\BlockchainInfo();

        return $fetcher->getBalance($address, $logger, true);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalanceWithConfirmations($address, $confirmations, Logger $logger)
    {
        $fetcher = new Services\BlockchainInfo();

        return $fetcher->getBalanceWithConfirmations($address, $confirmations, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalanceAtBlock($address, $block, Logger $logger)
    {
        $fetcher = new Services\BlockchainInfo();

        return $fetcher->getBalanceAtBlock($address, $block, $logger);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\BlockchainInfo();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\BlockchainInfo();

        return $fetcher->getDifficulty($logger);
    }
}
