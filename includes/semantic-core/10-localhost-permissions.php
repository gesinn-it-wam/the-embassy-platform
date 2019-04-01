<?php

## Access Rights
# needs to be set in 10-* include group, otherwise
# - Elsasticsearch updateSearchIndexConfig.php fails
# - VE/Parsoid does not work

$wgGroupPermissions['*']    ['read'] = false;
$wgGroupPermissions['*']    ['edit'] = false;
$wgGroupPermissions['*']    ['createaccount'] = false;
$wgGroupPermissions['user'] ['delete'] = true;
$wgGroupPermissions['bot']  ['upload'] = true;

if ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == "127.0.0.1" ) {         # VE/Parsoid
  $wgGroupPermissions['*']    ['read'] = true;
  $wgGroupPermissions['*']    ['edit'] = true;
}