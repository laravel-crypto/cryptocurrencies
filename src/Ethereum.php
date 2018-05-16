<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency;

use Monolog\Logger;
use Openclerk\Currencies\Cryptocurrency;

/**
 * Represents the Ethereum cryptocurrency.
 */
class Ethereum extends Cryptocurrency
{
    public function getCode()
    {
        return 'eth';
    }

    public function getName()
    {
        return 'Ethereum';
    }

    public function getURL()
    {
        return 'https://www.ethereum.org/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://twitter.com/ethereumproject' => 'Ethereum Twitter',
    ];
    }

    public function isValid($address)
    {
        if (strlen($address) >= 40 && strlen($address) <= 45
        && preg_match('#^0x[0-9a-f]+$#i', $address)) {
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
        return new Services\EtherscanIo();
    }

    public function getExplorerName()
    {
        return 'Etherscan.io';
    }

    public function getExplorerURL()
    {
        return 'https://etherscan.io';
    }

    public function getBalanceURL($address)
    {
        return 'https://etherscan.io/address/'.$address;
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = $this->getService();

        return $fetcher->getBalance($address, $logger);
    }
}
