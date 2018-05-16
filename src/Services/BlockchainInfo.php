<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

use Apis\Fetch;
use Monolog\Logger;
use Openclerk\Config;
use Openclerk\Currencies\BlockException;
use Openclerk\Currencies\BalanceException;
use Openclerk\Currencies\DifficultyException;

/**
 * Represents something that can fetch Bitcoin statistics.
 *
 * Blockchain job (BTC).
 */
class BlockchainInfo
{
    public function getBalance($address, Logger $logger, $is_received = false)
    {
        return $this->getBalanceWithConfirmations($address, Config::get('btc_confirmations'), $logger, $is_received);
    }

    /**
     * We can emulate this through confirmations.
     *
     * @param $block may be {@code null}
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalanceAtBlock($address, $block, Logger $logger, $is_received = false)
    {
        // there is no API to switch from block# to confirmations, so we do this manually
        $logger->info("Finding appropriate number of confirmations from block $block...");
        $current_block = $this->getBlockCount($logger);
        $confirmations = $current_block - $block;
        if ($confirmations >= 120) {
            $logger->warn('Cannot request more than 120 confirmations in the past with Blockchain');
            $confirmations = 120;
        }
        $logger->info('Confirmations necessary: '.number_format($confirmations));

        return $this->getBalanceWithConfirmations($address, $confirmations, $logger, $is_received);
    }

    public function getBalanceWithConfirmations($address, $confirmations, Logger $logger, $is_received = false)
    {
        if ($is_received) {
            $logger->info('Need to get received balance rather than current balance');
            $url = 'https://blockchain.info/q/getreceivedbyaddress/'.urlencode($address).'?confirmations='.$confirmations;
        } else {
            $url = 'https://blockchain.info/q/addressbalance/'.urlencode($address).'?confirmations='.$confirmations;
        }

        if (Config::get('blockchain_api_key', false)) {
            $logger->info('Using Blockchain API key.');
            $url = url_add($url, ['api_code' => Config::get('blockchain_api_key')]);
        }

        try {
            $logger->info($url);
            $balance = Fetch::get($url);
            $divisor = 1e8;   // divide by 1e8 to get btc balance

            if (! is_numeric($balance)) {
                $logger->error('Blockchain balance for '.htmlspecialchars($address).' is non-numeric: '.htmlspecialchars($balance));
                if ($balance == 'Checksum does not validate') {
                    throw new BalanceException('Checksum does not validate');
                }
                if (strpos($balance, 'Maximum concurrent requests reached.') !== false) {
                    throw new BlockchainException('Maximum concurrent requests reached');
                }
                throw new BalanceException("Blockchain returned non-numeric balance: '".htmlspecialchars($balance)."'");
            } else {
                $logger->info('Blockchain balance for '.htmlspecialchars($address).': '.($balance / $divisor));
            }

            return $balance / $divisor;
        } catch (\Apis\FetchHttpException $e) {
            throw new BalanceException($e->getContent(), $e);
        }
    }

    /**
     * @throws {@link BlockException} if something happened and the balance could not be obtained.
     */
    public function getBlockCount(Logger $logger)
    {
        $url = 'https://blockchain.info/q/getblockcount';

        if (Config::get('blockchain_api_key', false)) {
            $logger->info('Using Blockchain API key.');
            $url = url_add($url, ['api_code' => Config::get('blockchain_api_key')]);
        }

        $logger->info($url);
        $value = Fetch::get($url);

        if (! is_numeric($value)) {
            $logger->error('Block count is non-numeric: '.htmlspecialchars($value));
            throw new BlockException("Blockchain returned non-numeric value: '".htmlspecialchars($value)."'");
        } else {
            $logger->info('Block count : '.$value);
        }

        return $value;
    }

    /**
     * @throws {@link DifficultyException} if something happened and the balance could not be obtained.
     */
    public function getDifficulty(Logger $logger)
    {
        $url = 'https://blockchain.info/q/getdifficulty';

        if (Config::get('blockchain_api_key', false)) {
            $logger->info('Using Blockchain API key.');
            $url = url_add($url, ['api_code' => Config::get('blockchain_api_key')]);
        }

        $logger->info($url);
        $value = Fetch::get($url);

        if (! is_numeric($value)) {
            $logger->error('Difficulty is non-numeric: '.htmlspecialchars($value));
            throw new BlockException("Blockchain returned non-numeric value: '".htmlspecialchars($value)."'");
        } else {
            $logger->info('Difficulty : '.$value);
        }

        return $value;
    }
}
