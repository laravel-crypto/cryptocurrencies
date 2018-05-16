<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class PeercoinBlockr extends AbstractBlockrService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Peercoin(), [
      'url' => 'http://ppc.blockr.io/api/v1/address/info/%s',
      'info_url' => 'http://ppc.blockr.io/api/v1/coin/info',
      'confirmations' => 6,
    ]);
    }
}
