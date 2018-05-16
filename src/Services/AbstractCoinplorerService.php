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

abstract class AbstractCoinplorerService extends AbstractHTMLService
{
    public function __construct(Currency $currency, $args)
    {
        $this->currency = $currency;

        // default parameters
        $args += [
      'info_url' => false,
    ];

        $this->url = $args['url'];
        $this->info_url = $args['info_url'];
    }

    /**
     * Must force TLSv1.
     * If this does not work, make sure you are using CURL 7.34+.
     */
    public function getCURLOptions()
    {
        return [
      // CURLOPT_SSLVERSION => 1,
      // CURLOPT_SSL_CIPHER_LIST => 'TLSv1',
      // CURLOPT_VERBOSE => true,
      // CURLOPT_STDERR => fopen("php://stdout", "w"),
      // CURLOPT_SSL_VERIFYPEER => false,
      // CURLOPT_SSL_VERIFYHOST => false,
    ];
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger, $is_received = false)
    {

    // we can now request the HTML page
        $url = sprintf($this->url, $address);
        $logger->info($url);

        try {
            $html = Fetch::get($url, $this->getCURLOptions());
        } catch (\Apis\FetchHttpException $e) {
            throw new BalanceException($e->getContent(), $e);
        }
        $html = $this->stripHTML($html);

        // assumes that the page format will not change
        if ($is_received) {
            $logger->info('We are looking for received balance.');

            if (preg_match('#<tr><td>Total received:?</td><td>\\s*([0-9,\.]+) '.$this->currency->getAbbr().'#im', $html, $matches)) {
                $balance = str_replace(',', '', $matches[1]);
                $logger->info('Address balance: '.$balance);
            } else {
                throw new BalanceException("Could not find received balance for currency '".$this->currency->getCode()."'");
            }
        } else {
            if (preg_match('#<tr><td>Final balance:?</td><td>\\s*([0-9,\.]+) '.$this->currency->getAbbr().'#im', $html, $matches)) {
                $balance = str_replace(',', '', $matches[1]);
                $logger->info('Address balance: '.$balance);
            } else {
                throw new BalanceException("Could not find final balance for currency '".$this->currency->getCode()."'");
            }
        }

        return $balance;
    }

    public function getBlockCount(Logger $logger)
    {
        $url = $this->info_url;

        $logger->info($url);
        $html = Fetch::get($url, $this->getCURLOptions());
        $html = $this->stripHTML($html);

        if (preg_match('#<tr><td>Blocks:?</td><td>\\s*([0-9,\.]+)</td>#im', $html, $matches)) {
            $value = str_replace(',', '', $matches[1]);
        } else {
            throw new BlockException("Could not find block count for currency '".$this->currency->getCode()."'");
        }

        $logger->info('Block count: '.number_format($value));

        return $value;
    }

    public function getDifficulty(Logger $logger)
    {
        $url = $this->info_url;

        $logger->info($url);
        $html = Fetch::get($url, $this->getCURLOptions());
        $html = $this->stripHTML($html);

        if (preg_match('#<tr><td>Difficulty:?</td><td>\\s*([0-9,\.]+)</td>#im', $html, $matches)) {
            $value = str_replace(',', '', $matches[1]);
        } else {
            throw new DifficultyException("Could not find difficulty for currency '".$this->currency->getCode()."'");
        }

        $logger->info('Difficulty: '.number_format($value));

        return $value;
    }

    public function getExplorerName()
    {
        return 'Coinplorer';
    }

    public function getExplorerURL()
    {
        return 'https://coinplorer.com/';
    }

    public function getBalanceURL($address)
    {
        return sprintf('https://coinplorer.com/'.$this->currency->getCode().'/Addresses/%s', urlencode($address));
    }
}
