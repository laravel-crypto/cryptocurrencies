<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch Vericoin statistics.
 */
class BlackcoinExplorer extends AbstractChainzService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Vericoin(), array(
      "url" => "http://chainz.cryptoid.info/blk/api.dws?a=%s&q=getbalance",
      "received_url" => "http://chainz.cryptoid.info/blk/api.dws?a=%s&q=getreceivedbyaddress",
      "block_url" => "http://chainz.cryptoid.info/blk/api.dws?q=getblockcount",
      "difficulty_url" => "http://chainz.cryptoid.info/blk/api.dws?q=getdifficulty",
    ));
  }

}
