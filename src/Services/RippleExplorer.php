<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

use Apis\Fetch;
use Monolog\Logger;
use Openclerk\Currencies\Currency;
use Openclerk\Currencies\BalanceException;

class RippleExplorer
{
    public function __construct()
    {
        $this->currency = new \Cryptocurrency\Ripple();
        $this->url = 'http://s_west.ripple.com:51234/';
    }

    public function getAccountBalance($address, Logger $logger)
    {
        $url = $this->url;
        $logger->info($url);
        $data = [
      'method' => 'account_info',
      'params' => [
        [
          'account' => $address,
          'strict' => true,
        ],
      ],
    ];

        $json = Fetch::jsonDecode(Fetch::post($url, json_encode($data)));

        if (! isset($json['result'])) {
            throw new BalanceException('No result found');
        }

        if (isset($json['result']['error_message']) && $json['result']['error_message']) {
            throw new BalanceException('Ripple returned '.htmlspecialchars($json['result']['error_message']));
        }

        if (! isset($json['result']['account_data']['Balance'])) {
            throw new BalanceException('No balance found');
        }

        $balance = $json['result']['account_data']['Balance'];
        $divisor = 1e6;

        return $balance / $divisor;
    }

    public function getAccountLines($address, Logger $logger)
    {
        $url = $this->url;
        $logger->info($url);
        $data = [
      'method' => 'account_lines',
      'params' => [
        [
          'account' => $address,
        ],
      ],
    ];

        $json = Fetch::jsonDecode(Fetch::post($url, json_encode($data)));

        return $json['result']['lines'];
    }

    /**
     * Get all associated Ripple balances.
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalances($address, Logger $logger)
    {
        $result = [
      'xrp' => $this->getAccountBalance($address, $logger),
    ];

        // now look for other currencies (#242)
        foreach ($this->getAccountLines($address, $logger) as $line) {
            $cur = strtolower($line['currency']);
            if (! isset($result[$cur])) {
                $result[$cur] = 0;
            }

            $result[$cur] += $line['balance'];
        }

        foreach ($result as $currency => $balance) {
            $logger->info("Balance in $currency: $balance");
        }

        return $result;
    }

    /**
     * Get just the Ripple balance.
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger)
    {
        $balance = $this->getAccountBalance($address, $logger);
        $logger->info("Balance: $balance");

        return $balance;
    }
}
