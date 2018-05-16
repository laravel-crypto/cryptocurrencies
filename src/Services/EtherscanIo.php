<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

use Apis\Fetch;
use Monolog\Logger;
use Openclerk\Currencies\BalanceException;

class EtherscanIo
{
    public function __construct()
    {
        $this->currency = new \Cryptocurrency\Ethereum();
        $this->url = 'https://api.etherscan.io/api?module=account&action=balance&address=%s&tag=latest&apikey=YourApiKeyToken';
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger, $is_received = false)
    {
        $code = $this->currency->getCode();

        $url = sprintf($this->url, urlencode($address));
        $logger->info($url);

        try {
            $raw = Fetch::get($url);
        } catch (\Apis\FetchHttpException $e) {
            throw new BalanceException($e->getContent(), $e);
        }
        if (! $raw) {
            throw new BalanceException('Invalid address');
        }
        $json = Fetch::jsonDecode($raw);

        if ($json['status'] != '1') {
            throw new BalanceException('Could not fetch balance: '.htmlspecialchars($json['message']));
        }

        $balance = $json['result'] / 1e18;

        $logger->info('Balance: '.$balance);

        return $balance;
    }
}
