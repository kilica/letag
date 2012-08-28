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

if(!defined('LETAG_TRUST_PATH'))
{
	define('LETAG_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/letag');
}

require_once LETAG_TRUST_PATH . '/class/LetagUtils.class.php';

//
// Define a basic manifesto.
//
$modversion['name'] = $myDirName;
$modversion['version'] = 0.11;
$modversion['description'] = _MI_LETAG_DESC_LETAG;
$modversion['author'] = _MI_LETAG_LANG_AUTHOR;
$modversion['credits'] = _MI_LETAG_LANG_CREDITS;
$modversion['help'] = 'help.html';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = 'images/module_icon.png';
$modversion['dirname'] = $myDirName;
$modversion['trust_dirname'] = 'letag';
$modversion['role'] = 'tag';

$modversion['cube_style'] = true;
$modversion['legacy_installer'] = array(
	'installer'   => array(
		'class' 	=> 'Installer',
		'namespace' => 'Letag',
		'filepath'	=> LETAG_TRUST_PATH . '/admin/class/installer/LetagInstaller.class.php'
	),
	'uninstaller' => array(
		'class' 	=> 'Uninstaller',
		'namespace' => 'Letag',
		'filepath'	=> LETAG_TRUST_PATH . '/admin/class/installer/LetagUninstaller.class.php'
	),
	'updater' => array(
		'class' 	=> 'Updater',
		'namespace' => 'Letag',
		'filepath'	=> LETAG_TRUST_PATH . '/admin/class/installer/LetagUpdater.class.php'
	)
);
$modversion['disable_legacy_2nd_installer'] = false;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = array(
//	  '{prefix}_{dirname}_xxxx',
##[cubson:tables]
	'{prefix}_{dirname}_tag',

##[/cubson:tables]
);

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
$modversion['templates'] = array(
/*
	array(
		'file'		  => '{dirname}_xxx.html',
		'description' => _MI_LETAG_TPL_XXX
	),
*/
##[cubson:templates]
		array('file' => '{dirname}_tag_list.html','description' => _MI_LETAG_TPL_TAG_LIST),
		array('file' => '{dirname}_tag_view.html','description' => _MI_LETAG_TPL_TAG_VIEW),
		array('file' => '{dirname}_inc_tag_cloud.html','description' => 'tag cloud'),

##[/cubson:templates]
);

//
// Admin panel setting
//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php?action=Index';
$modversion['adminmenu'] = array(
/*
	array(
		'title'    => _MI_LETAG_LANG_XXXX,
		'link'	   => 'admin/index.php?action=xxx',
		'keywords' => _MI_LETAG_KEYWORD_XXX,
		'show'	   => true,
		'absolute' => false
	),
*/
##[cubson:adminmenu]
##[/cubson:adminmenu]
);

//
// Public side control setting
//
$modversion['hasMain'] = 1;
$modversion['hasSearch'] = 0;
$modversion['sub'] = array(
/*
	array(
		'name' => _MI_LETAG_LANG_SUB_XXX,
		'url'  => 'index.php?action=XXX'
	),
*/
##[cubson:submenu]
##[/cubson:submenu]
);

//
// Config setting
//
$modversion['config'] = array(
/*
	array(
		'name'			=> 'xxxx',
		'title' 		=> '_MI_LETAG_TITLE_XXXX',
		'description'	=> '_MI_LETAG_DESC_XXXX',
		'formtype'		=> 'xxxx',
		'valuetype' 	=> 'xxx',
		'options'		=> array(xxx => xxx,xxx => xxx),
		'default'		=> 0
	),
*/

	array(
		'name'			=> 'css_file' ,
		'title' 		=> "_MI_LETAG_LANG_CSS_FILE" ,
		'description'	=> "_MI_LETAG_DESC_CSS_FILE" ,
		'formtype'		=> 'textbox' ,
		'valuetype' 	=> 'text' ,
		'default'		=> '/modules/'.$myDirName.'/style.css',
		'options'		=> array()
	) ,
##[cubson:config]
##[/cubson:config]
);

//
// Block setting
//
$modversion['blocks'] = array(
	1 => array(
		'func_num'			=> 1,
		'file'				=> 'ListBlock.class.php',
		'class' 			=> 'ListBlock',
		'name'				=> _MI_LETAG_BLOCK_NAME_TAG_CLOUD,
		'description'		=> _MI_LETAG_BLOCK_DESC_TAG_CLOUD,
		'options'			=> '||||',
		'template'			=> '{dirname}_block_tag_cloud.html',
		'show_all_module'	=> true,
		'can_clone'			=> true,
		'visible_any'		=> true
	),
/*
	x => array(
		'func_num'			=> x,
		'file'				=> 'xxxBlock.class.php',
		'class' 			=> 'xxx',
		'name'				=> _MI_LETAG_BLOCK_NAME_xxx,
		'description'		=> _MI_LETAG_BLOCK_DESC_xxx,
		'options'			=> '',
		'template'			=> '{dirname}_block_xxx.html',
		'show_all_module'	=> true,
		'visible_any'		=> true
	),
*/
##[cubson:block]
##[/cubson:block]
);

?>
