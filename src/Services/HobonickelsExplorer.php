<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class HobonickelsExplorer extends AbstractCryptoCoinExplorerService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Hobonickels(), [
      'url' => 'http://hbn.cryptocoinexplorer.com/api/',
    ]);
    }
}
