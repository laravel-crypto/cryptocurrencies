<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

use Apis\Fetch;
use Monolog\Logger;
use Openclerk\Currencies\BalanceException;

/**
 * Represents the Blockscan service which returns counterparty assets.
 */
class Blockscan
{
    public function __construct($asset_name)
    {
        $this->asset_name = $asset_name;
    }

    public function getBalance($address, Logger $logger)
    {
        $url = sprintf('http://api.blockscan.com/api2?module=address&action=balance&btc_address=%s&asset=%s', $address, $this->asset_name);

        $logger->info($url);
        $json = Fetch::jsonDecode(Fetch::get($url));

        if ($json['status'] == 'error') {
            throw new BalanceException($json['message']);
        } else {
            $balance = $json['data'][0]['balance'];
        }

        $logger->info('Blockchain balance for '.htmlspecialchars($address).': '.$balance);

        return $balance;
    }
}
