<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

/**
 * Represents something that can fetch Viacoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class ViacoinExplorer extends AbstractChainzService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Vericoin(), [
      'url' => 'http://chainz.cryptoid.info/via/api.dws?a=%s&q=getbalance',
      'received_url' => 'http://chainz.cryptoid.info/via/api.dws?a=%s&q=getreceivedbyaddress',
      'block_url' => 'http://chainz.cryptoid.info/via/api.dws?q=getblockcount',
      'difficulty_url' => 'http://chainz.cryptoid.info/via/api.dws?q=getdifficulty',
    ]);
    }
}
