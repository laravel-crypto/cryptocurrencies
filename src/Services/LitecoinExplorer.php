<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class LitecoinExplorer extends AbstractAbeService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Litecoin(), [
      'url' => 'http://explorer.litecoin.net/address/%s',
      'block_url' => 'http://explorer.litecoin.net/chain/Litecoin/q/getblockcount',
      'difficulty_url' => 'http://explorer.litecoin.net/chain/Litecoin/q/getdifficulty',
      'confirmations' => 6,
    ]);
    }

    // TODO remove ltc_address_url
  // TODO remove ltc_confirmations
}
