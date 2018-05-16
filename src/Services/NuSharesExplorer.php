<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class NuSharesExplorer extends AbstractNuExplorerService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\NuShares(), [
      'url' => 'https://blockexplorer.nu/api/addressInfo/%s',
      'info_url' => 'https://blockexplorer.nu/api/statusInfo/',
    ]);
    }
}
