<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

/**
 * Represents something that can fetch Vericoin statistics.
 */
class BlackcoinExplorer extends AbstractChainzService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Vericoin(), [
      'url' => 'http://chainz.cryptoid.info/blk/api.dws?a=%s&q=getbalance',
      'received_url' => 'http://chainz.cryptoid.info/blk/api.dws?a=%s&q=getreceivedbyaddress',
      'block_url' => 'http://chainz.cryptoid.info/blk/api.dws?q=getblockcount',
      'difficulty_url' => 'http://chainz.cryptoid.info/blk/api.dws?q=getdifficulty',
    ]);
    }
}
