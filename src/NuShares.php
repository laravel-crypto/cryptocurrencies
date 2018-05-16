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
 * Represents the NuShares cryptocurrency.
 */
class NuShares extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, ReceivedCurrency
{
    public function getCode()
    {
        return 'nsr';
    }

    public function getName()
    {
        return 'NuShares';
    }

    public function getURL()
    {
        return 'https://nubits.com/nushares/introduction';
    }

    public function getCommunityLinks()
    {
        return [
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'S')
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
        return 'NuExplorer';
    }

    public function getExplorerURL()
    {
        return 'https://blockexplorer.nu/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('https://blockexplorer.nu/address/%s/1/newest', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\NuSharesExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\NuSharesExplorer();

        return $fetcher->getBalance($address, $logger, true);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\NuSharesExplorer();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\NuSharesExplorer();

        return $fetcher->getDifficulty($logger);
    }
}
