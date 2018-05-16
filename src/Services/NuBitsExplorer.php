<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

class NuBitsExplorer extends AbstractNuExplorerService
{
    public function __construct()
    {
        parent::__construct(new \Cryptocurrency\NuBits(), [
      'url' => 'https://blockexplorer.nu/api/addressInfo/%s',
      'info_url' => 'https://blockexplorer.nu/api/statusInfo/',
    ]);
    }
}
