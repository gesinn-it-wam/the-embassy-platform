<?php
# This file was automatically generated by the MediaWiki 1.31.1
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}


foreach (glob("$IP/includes/semantic-core/00-*.php") as $filename) {
  require_once($filename);
}

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "wiki01";
$wgMetaNamespace = "Wiki01";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "/wiki01";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "http://localhost:8080";

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgResourceBasePath/resources/assets/wiki.png";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@localhost";
$wgPasswordSender = "apache@localhost";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBname = "wikidb01";
$wgDBuser = "wikiuser";
$wgDBpassword = "wikiuser";

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=utf8";

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgEnableParserCache = false;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
#$wgUseImageMagick = true;
#$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "C.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "en";

$wgSecretKey = "40e3b06151decf3f19ca7cb6f12752415ebe69cc09c881aaf47b5eabc3a830cb";

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "9c2735724a899e1b";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Vector' );


# End of automatically generated settings.
# Add more configuration options below.

foreach (glob("$IP/includes/semantic-core/10-*.php") as $filename) {
  require_once($filename);
}



## -------- AdminLinks --------
wfLoadExtension( "AdminLinks" );
## ======== AdminLinks ========

## -------- Arrays --------
require_once( "$IP/extensions/Arrays/Arrays.php" );
## ======== Arrays ========

## -------- AutoCreatePage --------
require_once( "$IP/extensions/AutoCreatePage/AutoCreatePage.php" );
## ======== AutoCreatePage ========

## -------- CommentStreams --------
wfLoadExtension( "CommentStreams" );
$wgCommentStreamsShowLabels = false;
## ======== CommentStreams ========

## -------- CreateRedirect --------
require_once( "$IP/extensions/CreateRedirect/CreateRedirect.php" );
## ======== CreateRedirect ========

## -------- Elastica --------
wfLoadExtension( "Elastica" );
## ======== Elastica ========

## -------- CirrusSearch --------
require_once( "$IP/extensions/CirrusSearch/CirrusSearch.php" );
$wgCirrusSearchServers = [ "127.0.0.1" ];
$wgSearchType = "CirrusSearch";
# $wgDisableSearchUpdate = true;
## ======== CirrusSearch ========

## -------- CSS --------
wfLoadExtension( "CSS" );
## ======== CSS ========

## -------- DateDiff --------
require_once( "$IP/extensions/DateDiff/DateDiff.php" );
## ======== DateDiff ========

## -------- Echo --------
wfLoadExtension( "Echo" );
## ======== Echo ========

## -------- EditAccount --------
wfLoadExtension( "EditAccount" );
$wgGroupPermissions["sysop"]["editaccount"] = true;
$wgGroupPermissions["bureaucrat"]["editaccount"] = true;
## ======== EditAccount ========

## -------- ImageMap --------
require_once( "$IP/extensions/ImageMap/ImageMap.php" );
## ======== ImageMap ========

## -------- GraphViz --------
# GraphViz included via Composer
#wfLoadExtension( "GraphViz" );
## ======== GraphViz ========

## -------- GuidedTour --------
wfLoadExtension( "GuidedTour" );
## ======== GuidedTour ========

## -------- EventLogging --------
wfLoadExtension( "EventLogging" );
$wgEventLoggingSchemaApiUri = $wgServer . $wgScriptPath . "/api.php";
$wgEventLoggingDBname = $wgDBname;
## ======== EventLogging ========

## -------- IDProvider --------
require_once( "$IP/extensions/IDProvider/IDProvider.php" );
## ======== IDProvider ========

## -------- LinkTarget --------
require_once( "$IP/extensions/LinkTarget/LinkTarget.php" );
$wgLinkTargetParentClasses = array( "link-target-blank" );
$wgLinkTargetDefault = "_blank";
## ======== LinkTarget ========

## -------- Loops --------
require_once( "$IP/extensions/Loops/Loops.php" );
ExtLoops::$maxLoops = 1000;
## ======== Loops ========

## -------- NumberFormat --------
require_once( "$IP/extensions/NumberFormat/NumberFormat.php" );
## ======== NumberFormat ========

## -------- OpenLayers --------
wfLoadExtension( "OpenLayers" );
## ======== OpenLayers ========

## -------- ParserFunctions --------
require_once( "$IP/extensions/ParserFunctions/ParserFunctions.php" );
$wgPFEnableStringFunctions = true;
## ======== ParserFunctions ========

## -------- PermissionACL --------
# require_once( "$IP/extensions/PermissionACL/PermissionACL.php" );
## ======== PermissionACL ========

## -------- ReplaceText --------
require_once( "$IP/extensions/ReplaceText/ReplaceText.php" );
## ======== ReplaceText ========

## -------- SemanticMediaWiki --------
# SemanticMediaWiki included via Composer
enableSemantics( $wgServer, true );
$smwgQDefaultLimit = 500;
$smwgQMaxInlineLimit = 25000;
$smwgQMaxLimit = 25000;
$smwgQMaxSize = 25000;
$smwgQUpperbound = 25000;
SMWResultPrinter::$maxRecursionDepth = 40;
$smwgLinksInValues = true;
$smwgDefaultNumRecurringEvents = 1000;
$smwgPageSpecialProperties[] = "_CDAT";
$smwgPageSpecialProperties[] = "_NEWP";
$smwgPageSpecialProperties[] = "_LEDT";
$smwgEnabledQueryDependencyLinksStore = true;
## ======== SemanticMediaWiki ========

## -------- SemanticCompoundQueries --------
# SemanticCompoundQueries included via Composer
wfLoadExtension( "SemanticCompoundQueries" );
## ======== SemanticCompoundQueries ========

## -------- SemanticDependencyUpdater --------
wfLoadExtension( "SemanticDependencyUpdater" );
$wgSDUProperty = "Semantic Dependency";
## ======== SemanticDependencyUpdater ========

## -------- SemanticDrilldown --------
require_once( "$IP/extensions/SemanticDrilldown/SemanticDrilldown.php" );
$sdgNumResultsPerPage = 250;
$sdgMinValuesForComboBox = 30;
$sdgHideFiltersWithoutValues = true;
$sdgDisableFilterCollapsible = true;
## ======== SemanticDrilldown ========

## -------- PageForms --------
wfLoadExtension( "PageForms" );
$wgPageFormsAutocompleteOnAllChars = true;
$wgPageFormsMaxAutocompleteValues = 3000;
$wgPageFormsMaxLocalAutocompleteValues = 5000;
$wgPageForms24HourTime = true;
$wgPageFormsListSeparator = ";";
## ======== PageForms ========

## -------- DateTimePicker2 --------
wfLoadExtension( "DateTimePicker2" );
## ======== DateTimePicker2 ========

## -------- SemanticFormsSelect --------
wfLoadExtension( "SemanticFormsSelect" );
## ======== SemanticFormsSelect ========

## -------- SemanticMaps --------
# SemanticMaps included via Composer
wfLoadExtension( "Maps" );
## ======== SemanticMaps ========



wfLoadExtension( "MultimediaViewer" );

## -------- SemanticMetaTags --------
# SemanticMetaTags included via Composer
wfLoadExtension( "SemanticMetaTags" );
## ======== SemanticMetaTags ========

## -------- SemanticResultFormats --------
# SemanticResultFormats included via Composer
wfLoadExtension( "SemanticResultFormats" );
$srfgFormats[] = "graph";
$srfgFormats[] = "excel";
$srfgFormats[] = "filtered";
## ======== SemanticResultFormats ========

## -------- SemanticTitle --------
require_once( "$IP/extensions/SemanticTitle/SemanticTitle.php" );
$wgAllowDisplayTitle = true;
$wgRestrictDisplayTitle = false;
## ======== SemanticTitle ========

## -------- SimpleTooltip --------
require_once( "$IP/extensions/SimpleTooltip/SimpleTooltip.php" );
## ======== SimpleTooltip ========

## -------- Substitutor --------
require_once( "$IP/extensions/Substitutor/Substitutor.php" );
## ======== Substitutor ========

## -------- SyntaxHighlight_GeSHi --------
wfLoadExtension( "SyntaxHighlight_GeSHi" );
## ======== SyntaxHighlight_GeSHi ========

## -------- TemplateData --------
wfLoadExtension( "TemplateData" );
$wgTemplateDataUseGUI = false;
## ======== TemplateData ========

## -------- TreeAndMenu --------
wfLoadExtension( "TreeAndMenu" );
## ======== TreeAndMenu ========

## -------- TitleIcon --------
wfLoadExtension( "TitleIcon" );
$wgTitleIcon_CSSSelector = "h1.firstHeading";
$wgTitleIcon_UseFileNameAsToolTip = false;
## ======== TitleIcon ========

## -------- UrlGetParameters --------
require_once( "$IP/extensions/UrlGetParameters/UrlGetParameters.php" );
## ======== UrlGetParameters ========

## -------- UserFunctions --------
require_once( "$IP/extensions/UserFunctions/UserFunctions.php" );
$wgUFEnablePersonalDataFunctions = true;
$wgUFAllowedNamespaces[NS_MAIN] = true;
## ======== UserFunctions ========

## -------- UserMerge --------
wfLoadExtension( "UserMerge" );
$wgGroupPermissions["sysop"]["usermerge"] = true;
$wgGroupPermissions["bureaucrat"]["usermerge"] = true;
## ======== UserMerge ========

## -------- Variables --------
wfLoadExtension( "Variables" );
## ======== Variables ========

## -------- VisualEditor --------
require_once( "$IP/extensions/VisualEditor/VisualEditor.php" );
$wgDefaultUserOptions["visualeditor-enable"] = 1;
$wgHiddenPrefs[] = "visualeditor-enable";
$wgDefaultUserOptions["visualeditor-enable-experimental"] = 1;
$wgVirtualRestConfig["modules"]["parsoid"] = ["url" => "http://localhost:8142", "domain" => "wiki01", "prefix" => "wiki01"];
## ======== VisualEditor ========

## -------- VEForAll --------
wfLoadExtension( "VEForAll" );
## ======== VEForAll ========

foreach (glob("$IP/includes/semantic-core/9*.php") as $filename) {
  require_once($filename);
}

if (file_exists( __DIR__."/_custom/custom-settings.php" )) {
  require_once( __DIR__."/_custom/custom-settings.php" );
}

