<?php
############################################################################
##    SETTINGS                                                            ##
############################################################################

## PHP Settings
# increase limits of maximum execution time (defaut 30) to avoid issues
# with long running scripts, e.g. Special:Import
set_time_limit(300);

## MediaWiki Settings
$wgFixDoubleRedirects = true;
$wgAPIMaxDBRows = 25000;
$wgPFEnableStringFunctions = true;
$wgCacheDirectory = "$IP/cache";
$wgJobRunRate = 0;
$wgFavicon = "$wgScriptPath/favicon.ico";


## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgParserCacheType = CACHE_NONE;
$wgMessageCacheType = CACHE_NONE;

#$wgMainCacheType = CACHE_MEMCACHED;
#$wgParserCacheType = CACHE_MEMCACHED;
#$wgMessageCacheType = CACHE_MEMCACHED;

#$wgMemCachedServers = array( "127.0.0.1:11211" );

## Shell Memory Settings (required e.g. by PDF Handler for large PDFs)
$wgMaxShellFileSize=614400;
$wgMaxShellMemory=614400;

## Password Attempt Throttle
$wgPasswordAttemptThrottle = [ [ 'count' => 5, 'seconds' => 3600 ], [ 'count' => 2, 'seconds' => 300 ] ];

## E-Mail
$wgEnableEmail      = true;
$wgEnableUserEmail  = true; # UPO

$wgEmergencyContact = "support@acme.com";
$wgPasswordSender   = "support@acme.com";

$wgEnotifUserTalk      = true; # UPO
$wgEnotifWatchlist     = true; # UPO
$wgEmailAuthentication = true;

$wgSMTP = array(
    'host' => 'mail.acme.com',
  'IDHost' => 'acme.com',
    'port' => 25,
'username' => 'test',
'password' => 'secret',
    'auth' => true
);


## Timezone
$wgLocaltimezone = "Europe/Berlin";
putenv("TZ=$wgLocaltimezone");
$wgLocalTZoffset = date("Z") / 60;
$wgDefaultUserOptions['timecorrection'] = 'ZoneInfo|' . (date("I") ? 120 : 60) . '|Europe/Berlin';

## Default Language UPO
$wgDefaultUserOptions['language'] = 'en';

## Files UPO
$wgDefaultUserOptions['thumbsize'] = 0;     # 0 defaults to 60px

## Disable Patrolled Edits
$wgUseRCPatrol = false;
$wgUseNPPatrol = false;

## File Extensions
$wgFileExtensions = array("txt", "jpg", "jpeg", "eps", "doc", "docx", "docm", "dotx", "dotm", "flv", "gif", "ott", "odm", "ods", "ots", "odg", "otg", "odp", "otp", "odb", "pdf", "png", "pptx", "ppt", "pptm", "potx", "potm", "svg", "tif", "xls", "xlsx", "xlsm", "xltx", "xltm");
$wgVerifyMimeType = false;      # required to allow e.g. docx