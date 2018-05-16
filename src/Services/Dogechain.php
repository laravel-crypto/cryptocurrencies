<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

use Monolog\Logger;

class Dogechain extends AbstractAbeService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Dogecoin(), [
      'url' => 'https://dogechain.info/address/%s',
      'block_url' => 'https://dogechain.info/chain/Dogecoin/q/getblockcount',
      'difficulty_url' => 'https://dogechain.info/chain/Dogecoin/q/getdifficulty',
      'confirmations' => 6,
    ]);
    }

    // TODO remove ltc_address_url
    // TODO remove ltc_confirmations

    /**
     * No transactions were found; for Dogechain, this is OK.
     */
    public function foundNoTransactions(Logger $logger)
    {
//    throw new BalanceException("Could not find any transactions on page");
    }
}
