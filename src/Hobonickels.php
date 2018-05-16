<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency;

use Monolog\Logger;
use Openclerk\Currencies\BlockCurrency;
use Openclerk\Currencies\Cryptocurrency;
use Openclerk\Currencies\HashableCurrency;
use Openclerk\Currencies\DifficultyCurrency;

/**
 * Represents the Hobonickels cryptocurrency.
 */
class Hobonickels extends Cryptocurrency implements BlockCurrency, DifficultyCurrency, HashableCurrency
{
    public function getCode()
    {
        return 'hbn';
    }

    public function getName()
    {
        return 'HoboNickels';
    }

    public function getURL()
    {
        return 'http://hobonickels.info/';
    }

    public function getCommunityLinks()
    {
        return [
      'http://hobonickels.info/community.php' => 'HoboNickels Community',
    ];
    }

    public function isValid($address)
    {
        // based on is_valid_btc_address
        if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == 'E' || substr($address, 0, 1) == 'F')
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
        return 'Hobonickels Explorer';
    }

    public function getExplorerURL()
    {
        return 'http://hbn.cryptocoinexplorer.com/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('http://hbn.cryptocoinexplorer.com/address?address=%s', urlencode($address));
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $fetcher = new Services\HobonickelsExplorer();

        return $fetcher->getBalance($address, $logger);
    }

    public function getBlockCount(Logger $logger)
    {
        $fetcher = new Services\HobonickelsExplorer();

        return $fetcher->getBlockCount($logger);
    }

    public function getDifficulty(Logger $logger)
    {
        $fetcher = new Services\HobonickelsExplorer();

        return $fetcher->getDifficulty($logger);
    }
}
