<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class NamecoinExplorer extends AbstractAbeService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Namecoin(), [
      'url' => 'http://darkgamex.ch:2751/address/%s',
      'block_url' => 'http://darkgamex.ch:2751/chain/Namecoin/q/getblockcount',
      'difficulty_url' => 'http://darkgamex.ch:2751/chain/Namecoin/q/getdifficulty',
      'confirmations' => 6,
    ]);
    }
}
