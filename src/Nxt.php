<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency;

use Monolog\Logger;
use Openclerk\Currencies\BlockCurrency;
use Openclerk\Currencies\Cryptocurrency;
use Openclerk\Currencies\ReceivedCurrency;

/**
 * Represents the Nxt cryptocurrency.
 */
class Nxt extends Cryptocurrency implements BlockCurrency, ReceivedCurrency
{
    public function getCode()
    {
        return 'nxt';
    }

    public function getName()
    {
        return 'Nxt';
    }

    public function getURL()
    {
        return 'http://nxt.org/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://nxt.org/get-started/' => 'Get Started',
    ];
    }

    /**
     * We support NXT addresses by numeric value only.
     */
    public function isValid($address)
    {
        if (strlen($address) >= 5 && strlen($address) <= 32 && preg_match('#^[0-9]+$#', $address)) {
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
        return 'myNXT.info';
    }

    public function getExplorerURL()
    {
        return 'http://www.mynxt.info/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('http://www.mynxt.info/blockexplorer/details.php?action=ac&ac=%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\MyNxtInfo();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getReceived($address, Logger $logger)
    {
        $fetcher = new Services\MyNxtInfo();

        return $fetcher->getBalance($address, $logger, true);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\MyNxtInfo();

        return $fetcher->getBlockCount($logger);
    }
}
