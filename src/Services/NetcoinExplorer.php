<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class NetcoinExplorer extends AbstractAbeService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Netcoin(), [
      'url' => 'http://explorer.netcoinfoundation.org/address/%s',
      'block_url' => 'http://explorer.netcoinfoundation.org/chain/Netcoin/q/getblockcount',
      'difficulty_url' => 'http://explorer.netcoinfoundation.org/chain/Netcoin/q/getdifficulty',
      'confirmations' => 6,
    ]);
    }
}
