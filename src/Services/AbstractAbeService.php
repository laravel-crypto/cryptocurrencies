<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

use Apis\Fetch;
use Monolog\Logger;
use Openclerk\Currencies\Currency;
use Openclerk\Currencies\BlockCurrency;
use Openclerk\Currencies\BalanceException;

abstract class AbstractAbeService extends AbstractHTMLService
{
    public function __construct(Currency $currency, $args)
    {
        $this->currency = $currency;

        // default parameters
        $args += [
      'confirmations' => 6,
      'block_url' => false,
      'difficulty_url' => false,
    ];

        $this->url = $args['url'];
        $this->block_url = $args['block_url'];
        $this->difficulty_url = $args['difficulty_url'];
        $this->confirmations = $args['confirmations'];
    }

    /**
     * No transactions were found; possibly throw a {@link BalanceException}.
     */
    public function foundNoTransactions(Logger $logger)
    {
        throw new BalanceException('Could not find any transactions on page');
    }

    /**
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalance($address, Logger $logger, $is_received = false)
    {
        return $this->getBalanceAtBlock($address, null, $logger, $is_received);
    }

    /**
     * @param $block may be {@code null}
     * @throws {@link BalanceException} if something happened and the balance could not be obtained.
     */
    public function getBalanceAtBlock($address, $block, Logger $logger, $is_received = false)
    {
        $code = $this->currency->getCode();

        if ($is_received) {
            $logger->info('We are looking for received balance.');
        }

        // do we have a block count?
        if ($this->currency instanceof BlockCurrency && ! $block) {
            // TODO this needs to be cacheable between requests, otherwise we're going to end
            // up spamming services for block counts!
            $logger->info('Finding most recent block count...');
            $block = $this->currency->getBlockCount($logger) - $this->confirmations;
        }

        $logger->info('Ignoring blocks after block '.number_format($block));

        // we can now request the HTML page
        $url = sprintf($this->url, $address);
        $logger->info($url);
        try {
            $html = Fetch::get($url);
        } catch (\Apis\FetchHttpException $e) {
            // don't return raw HTML if we can find a valid error message
            if (strpos($e->getContent(), 'Not a valid address')) {
                throw new BalanceException('Not a valid address', $e);
            }
            if (strpos($e->getContent(), 'Address not seen on the network')) {
                throw new BalanceException('Address not seen on the network', $e);
            }

            // otherwise, throw HTML as normal
            throw new BalanceException($e->getContent(), $e);
        }
        $html = $this->stripHTML($html);

        // assumes that the page format will not change
        if (! $is_received && preg_match('#(<p>|<tr><th>|<tr><td>)Balance:?( |</th><td>|</td><td>)([0-9,\.]+) '.$this->currency->getAbbr().'#im', $html, $matches)) {
            $balance = str_replace(',', '', $matches[3]);
            $logger->info('Address balance before removing unconfirmed: '.$balance);

            // transaction, block, date, amount, [balance,] currency
            if (preg_match_all('#<tr><td>.+</td><td><a href=[^>]+>([0-9]+)</a></td><td>.+?</td><td>(- |\\+ |)([0-9,\\.\\(\\)]+)</td>(|<td>([0-9\\.]+)</td>)<td>'.$this->currency->getAbbr().'</td></tr>#im', $html, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    if ($match[1] >= $block) {
                        // too recent
                        $amount = str_replace(',', '', $match[3]);
                        if (substr($amount, 0, 1) == '(' && substr($amount, -1) == ')') {
                            // convert (1.23) into -1.23
                            $amount = -substr($amount, 1, strlen($amount) - 2);
                        }
                        if ($match[2] == '+ ') {
                            $amount = +$amount;
                        } elseif ($match[2] == '- ') {
                            $amount = -$amount;
                        }
                        $logger->info('Removing '.$amount.' from balance: unconfirmed (block '.$match[1].' >= '.$block.')');
                        $balance -= $amount;
                    }
                }

                $logger->info('Confirmed balance after '.$this->confirmations.' confirmations: '.$balance);
            } else {
                $this->foundNoTransactions($logger);
            }
        } elseif ($is_received && preg_match('#(|<tr><th>|<tr><td>)Received:?( |</th><td>|</td><td>)([0-9,\.]+) '.$this->currency->getAbbr().'#i', $html, $matches)) {
            $balance = str_replace(',', '', $matches[3]);
            $logger->info('Address received before removing unconfirmed: '.$balance);

            // transaction, block, date, amount, [balance,] currency
            if (preg_match_all('#<tr><td>.+</td><td><a href=[^>]+>([0-9]+)</a></td><td>.+?</td><td>(- |\\+ |)([0-9,\\.\\(\\)]+)</td>(|<td>([0-9\\.]+)</td>)<td>'.$this->currency->getAbbr().'</td></tr>#im', $html, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    if ($match[1] >= $block) {
                        // too recent
                        $amount = str_replace(',', '', $match[3]);
                        if (substr($amount, 0, 1) == '(' && substr($amount, -1) == ')') {
                            // convert (1.23) into -1.23
                            $amount = -substr($amount, 1, strlen($amount) - 2);
                        }
                        if ($match[2] == '+ ') {
                            $amount = +$amount;
                        } elseif ($match[2] == '- ') {
                            $amount = -$amount;
                        }
                        // only consider received
                        if ($amount > 0) {
                            $logger->info('Removing '.$amount.' from received: unconfirmed (block '.$match[1].' >= '.$block.')');
                            $balance -= $amount;
                        }
                    }
                }

                $logger->info('Confirmed received after '.$this->confirmations.' confirmations: '.$balance);
            } else {
                $this->foundNoTransactions($logger);
            }
        } elseif (strpos($html, 'Address not seen on the network.') !== false) {
            // the address is valid, it just doesn't have a balance
            $balance = 0;
            $logger->info('Address is valid, but not yet seen on network');
        } elseif (strpos($html, 'Not a valid address.') !== false || strpos($html, 'Please enter search terms') !== false) {
            // the address is NOT valid
            throw new BalanceException('Not a valid address');
        } elseif (strpos($html, 'this address has too many records to display') !== false) {
            // this address is valid, and it has a balance, but it has too many records for this Abe instance
            crypto_log('Address is valid, but has too many records to display');
            throw new BalanceException('Address has too many transactions');
        } elseif (strpos(strtolower($html), '500 internal server error') !== false) {
            crypto_log('Server returned 500 Internal Server Error');
            throw new BalanceException('Server returned 500 Internal Server Error');
        } else {
            throw new BalanceException('Could not find balance on page');
        }

        return $balance;
    }

    public function getBlockCount(Logger $logger)
    {
        if (! $this->block_url) {
            throw new BlockException("No known block URL for currency '".$this->currency->getCode()."'");
        }

        $url = $this->block_url;

        $logger->info($url);
        $value = (int) Fetch::get($url);
        $logger->info('Block count: '.number_format($value));

        return $value;
    }

    public function getDifficulty(Logger $logger)
    {
        if (! $this->difficulty_url) {
            throw new DifficultyException("No known difficulty URL for currency '".$this->currency->getCode()."'");
        }

        $url = $this->difficulty_url;

        $logger->info($url);
        $value = (float) Fetch::get($url);
        $logger->info('Difficulty: '.number_format($value, 6));

        return $value;
    }
}
