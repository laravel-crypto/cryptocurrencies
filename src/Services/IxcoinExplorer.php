<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class IxcoinExplorer extends AbstractAbeService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Ixcoin(), [
      'url' => 'http://darkgamex.ch:2751/address/%s',
      'block_url' => 'http://darkgamex.ch:2751/chain/Ixcoin/q/getblockcount',
      'difficulty_url' => 'http://darkgamex.ch:2751/chain/Ixcoin/q/getdifficulty',
      'confirmations' => 6,
    ]);
    }
}
