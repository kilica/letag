<?php
/**
 * @file
 * @package letag
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once XOOPS_TRUST_PATH . '/modules/letag/preload/AssetPreload.class.php';
Letag_AssetPreloadBase::prepare(basename(dirname(dirname(__FILE__))));

?>
