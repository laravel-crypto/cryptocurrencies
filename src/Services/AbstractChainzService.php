<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

use Apis\Fetch;
use Monolog\Logger;
use Openclerk\Currencies\Currency;
use Openclerk\Currencies\BlockException;
use Openclerk\Currencies\BalanceException;
use Openclerk\Currencies\DifficultyException;

/**
 * Explorers using Chainz https://chainz.cryptoid.info/.
 */
abstract class AbstractChainzService
{
    public function __construct(Currency $currency, $args)
    {
        $this->currency = $currency;

        $this->url = $args['url'];
        $this->received_url = $args['received_url'];
        $this->block_url = $args['block_url'];
        $this->difficulty_url = $args['difficulty_url'];
    }

    /**
     * There is no API that returns transactions for a given address.
     *
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger, $is_received = false)
    {
        if ($is_received) {
            $url = sprintf($this->received_url, $address);
        } else {
            $url = sprintf($this->url, $address);
        }

        $logger->info($url);
        $value = Fetch::get($url);
        $logger->info('Balance: '.$value);

        return $value;
    }

    /**
     * @throws {@link BlockException} if something happened and the balance could not be obtained.
     */
    public function getBlockCount(Logger $logger)
    {
        $url = $this->block_url;

        $logger->info($url);
        $value = Fetch::get($url);
        $logger->info('Block count: '.number_format($value));

        return $value;
    }

    /**
     * @throws {@link DifficultyException} if something happened and the balance could not be obtained.
     */
    public function getDifficulty(Logger $logger)
    {
        $url = $this->difficulty_url;

        $logger->info($url);
        $value = Fetch::get($url);
        $logger->info('Difficulty: '.number_format($value));

        return $value;
    }

    public function getExplorerName()
    {
        return 'Chainz';
    }

    public function getExplorerURL()
    {
        return 'https://chainz.cryptoid.info/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('https://chainz.cryptoid.info/'.urlencode($this->currency->getCode()).'/address.dws?%s.htm', urlencode($address));
    }
}
