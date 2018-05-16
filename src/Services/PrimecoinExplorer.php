<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

/**
 * Represents something that can fetch Primecoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class PrimecoinExplorer extends AbstractCoinplorerService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Primecoin(), [
      'url' => 'https://coinplorer.com/XPM/Addresses/%s',
      'info_url' => 'https://coinplorer.com/XPM',
    ]);
    }
}
