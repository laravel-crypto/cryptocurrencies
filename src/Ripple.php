<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency;

use Monolog\Logger;
use Openclerk\Currencies\Cryptocurrency;
use Openclerk\Currencies\MultiBalanceableCurrency;

/**
 * Represents the Ripple cryptocurrency.
 */
class Ripple extends Cryptocurrency implements MultiBalanceableCurrency
{
    public function getCode()
    {
        return 'xrp';
    }

    public function getName()
    {
        return 'Ripple';
    }

    public function getURL()
    {
        return 'https://ripple.com/';
    }

    public function getCommunityLinks()
    {
        return [
      'https://ripple.com/about-ripple/' => 'What is Ripple?',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'r')
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
        return 'Ripple Charts';
    }

    public function getExplorerURL()
    {
        return 'https://www.ripplecharts.com/#/graph';
    }

    public function getBalanceURL($address)
    {
        return sprintf('https://ripple.com/graph/#%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\RippleExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getMultiBalances($address, Logger $logger)
    {
        $fetcher = new Services\RippleExplorer();

        return $fetcher->getBalances($address, $logger);
    }
}
