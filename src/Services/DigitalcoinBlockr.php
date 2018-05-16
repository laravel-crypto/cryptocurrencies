<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class DigitalcoinBlockr extends AbstractBlockrService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Digitalcoin(), [
      'url' => 'http://dgc.blockr.io/api/v1/address/info/%s',
      'info_url' => 'http://dgc.blockr.io/api/v1/coin/info',
      'confirmations' => 6,
    ]);
    }
}
