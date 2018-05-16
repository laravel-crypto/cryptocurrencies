<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

/**
 * Represents something that can fetch TerracoinExplorer statistics.
 *
 * TODO it may be possible to do confirmations
 */
class TerracoinExplorer extends AbstractCoinplorerService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Terracoin(), [
      'url' => 'https://coinplorer.com/TRC/Addresses/%s',
      'info_url' => 'https://coinplorer.com/TRC',
    ]);
    }
}
