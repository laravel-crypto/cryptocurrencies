<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class MegacoinBlockr extends AbstractBlockrService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Megacoin(), [
      'url' => 'http://mec.blockr.io/api/v1/address/info/%s',
      'info_url' => 'http://mec.blockr.io/api/v1/coin/info',
      'confirmations' => 6,
    ]);
    }
}
