<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

/**
 * Represents something that can fetch Reddcoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class ReddcoinExplorer extends AbstractInsightService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Reddcoin(), [
      'url' => 'http://live.reddcoin.com/api/addr/%s/?noTxList=1',
      'info_url' => 'http://live.reddcoin.com/api/status?q=getInfo',
    ]);
    }
}
