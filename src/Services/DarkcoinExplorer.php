<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class DarkcoinExplorer extends AbstractAbeService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Darkcoin(), [
      'url' => 'http://explorer.darkcoin.io/address/%s',
      'block_url' => 'http://explorer.darkcoin.io/chain/Darkcoin/q/getblockcount',
      'difficulty_url' => 'http://explorer.darkcoin.io/chain/Darkcoin/q/getdifficulty',
      'confirmations' => 6,
    ]);
    }
}
