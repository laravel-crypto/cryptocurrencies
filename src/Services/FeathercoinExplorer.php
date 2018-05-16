<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

/**
 * Represents something that can fetch Feathercoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class FeathercoinExplorer extends AbstractCoinplorerService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\Feathercoin(), [
      'url' => 'https://coinplorer.com/FTC/Addresses/%s',
      'info_url' => 'https://coinplorer.com/FTC',
    ]);
    }
}
