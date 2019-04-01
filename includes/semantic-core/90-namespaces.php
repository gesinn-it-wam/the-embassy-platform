<?php

############################################################################
##    NAMESPACES                                                          ##
############################################################################

$customNamespaces = array(

    // Use 4000x for foundational namespaces
    // Use 5000x and 6000x for semantic app namespaces
    // Use 7000x for customer specific namespaces

    // Foundation
    4012 => 'Test',

);

// Apply Namespaces
foreach ($customNamespaces as $number => $name) {

    $id = 'NS_' . strtoupper($name);

    define($id, $number);                   // Define namespace
    define($id . '_TALK', ($number + 1));   // Define talk namespace

    if (isset($wgExtraNamespaces[$number])) {
        die('Cannot declare namespace number twice: ' . $number . ' for ' . $name);
    }

    $wgExtraNamespaces[$number] = $name;
    $wgExtraNamespaces[($number + 1)] = $name . '_Talk';

    $wgContentNamespaces[] = $number;                  // https://www.mediawiki.org/wiki/Manual:$wgContentNamespaces
    $wgNamespacesToBeSearchedDefault[$number] = true;  // https://www.mediawiki.org/wiki/Manual:$wgNamespacesToBeSearchedDefault
    $smwgNamespacesWithSemanticLinks[$number] = true;  // https://www.semantic-mediawiki.org/wiki/Help:$smwgNamespacesWithSemanticLinks
    $wgNamespacesWithSubpages[$number] = true;         // https://www.mediawiki.org/wiki/Manual:$wgNamespacesWithSubpages
    $egApprovedRevsNamespaces[] = $number;             // https://www.mediawiki.org/wiki/Extension:Approved_Revs#Setting_pages_as_approvable
    $wgUFAllowedNamespaces[$number] = true;            // https://www.mediawiki.org/wiki/Extension:UserFunctions#Allowing_namespaces

}

// Search in File Namespace to show PDFs in search results by default
$wgNamespacesToBeSearchedDefault[NS_FILE] = true;

# Project
# There is already a Project Namespace defined by MediaWiki, so we have some special handling here:
$wgMetaNamespace = "Project";

// Declare common namespaces as semantic
$smwgNamespacesWithSemanticLinks[2]   = true; // USER
$smwgNamespacesWithSemanticLinks[4]   = true; // PROJECT
$wgContentNamespaces[] = 4;
$wgUFAllowedNamespaces[4] = true;
$smwgNamespacesWithSemanticLinks[6]   = true; // FILE
$wgContentNamespaces[] = 6;
$wgUFAllowedNamespaces[6] = true;
$smwgNamespacesWithSemanticLinks[10]  = true; // TEMPLATE
$wgUFAllowedNamespaces[10] = true;
$smwgNamespacesWithSemanticLinks[12]  = true; // HELP
$smwgNamespacesWithSemanticLinks[14]  = true; // CATEGORY

$smwgNamespacesWithSemanticLinks[102] = true; // PROPERTY
$smwgNamespacesWithSemanticLinks[106] = true; // FORM
$smwgNamespacesWithSemanticLinks[108] = true; // CONCEPT

$wgVisualEditorNamespaces = array_merge($wgContentNamespaces, array( NS_USER, NS_CATEGORY ));