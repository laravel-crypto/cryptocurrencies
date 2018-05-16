<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency;

use Monolog\Logger;
use Openclerk\Currencies\Cryptocurrency;

/**
 * Represents the Storjcoin cryptocurrency.
 */
class Storjcoin extends Cryptocurrency
{
    public function getCode()
    {
        return 'sj1';
    }

    public function getName()
    {
        return 'StorjCoin';
    }

    public function getAbbr()
    {
        return 'SJCX';
    }

    public function getURL()
    {
        return 'http://storj.io/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://storj.io/faq.html' => 'Storj Frequently Asked Questions',
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

    public function hasExplorer()
    {
        return true;
    }

    public function getExplorerName()
    {
        return 'Blockscan';
    }

    public function getExplorerURL()
    {
        return 'https://blockscan.com/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('https://blockscan.com/address/%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\Blockscan('SJCX');

        return $fetcher->getBalance($address, $logger);
    }
}
