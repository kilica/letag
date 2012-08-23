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

/**
 * Letag_AssetPreloadBase
**/
class Letag_AssetPreloadBase extends XCube_ActionFilter
{
	public $mDirname = null;

	/**
	 * prepare
	 * 
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public static function prepare(/*** string ***/ $dirname)
	{
		static $setupCompleted = array();
		if(! isset($setupCompleted[$dirname]))
		{
			$setupCompleted[$dirname] = self::_setup($dirname);
		}
	}

	/**
	 * _setup
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public static function _setup(/*** string ***/ $dirname)
	{
		$root =& XCube_Root::getSingleton();
		$instance = new self($root->mController);
		$instance->mDirname = $dirname;
		$root->mController->addActionFilter($instance);
		return true;
	}

	/**
	 * preBlockFilter
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function preBlockFilter()
	{
		$file = LETAG_TRUST_PATH . '/class/DelegateFunctions.class.php';
		$this->mRoot->mDelegateManager->add('Module.letag.Global.Event.GetAssetManager','Letag_AssetPreloadBase::getManager');
		$this->mRoot->mDelegateManager->add('Legacy_Utils.CreateModule','Letag_AssetPreloadBase::getModule');
		$this->mRoot->mDelegateManager->add('Legacy_Utils.CreateBlockProcedure','Letag_AssetPreloadBase::getBlock');
		$this->mRoot->mDelegateManager->add('Module.'.$this->mDirname.'.Global.Event.GetNormalUri','Letag_CoolUriDelegate::getNormalUri', $file);
		$this->mRoot->mDelegateManager->add('Legacy_Tag.'.$this->mDirname.'.SetTags','Letag_TagDelegate::setTags', $file);
		$this->mRoot->mDelegateManager->add('Legacy_Tag.'.$this->mDirname.'.GetTags','Letag_TagDelegate::getTags', $file);
		$this->mRoot->mDelegateManager->add('Legacy_Tag.'.$this->mDirname.'.GetTagCloudSrc','Letag_TagDelegate::getTagCloudSrc', $file);
		$this->mRoot->mDelegateManager->add('Legacy_Tag.'.$this->mDirname.'.GetDataIdListByTags','Letag_TagDelegate::getDataIdListByTags', $file);
        $this->mRoot->mDelegateManager->add('Site.JQuery.AddFunction',array(&$this, 'addTagSelectScript'));
	}

	/**
	 * getManager
	 * 
	 * @param	Letag_AssetManager  &$obj
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public static function getManager(/*** Letag_AssetManager ***/ &$obj,/*** string ***/ $dirname)
	{
		require_once LETAG_TRUST_PATH . '/class/AssetManager.class.php';
		$obj = Letag_AssetManager::getInstance($dirname);
	}

	/**
	 * getModule
	 * 
	 * @param	Legacy_AbstractModule  &$obj
	 * @param	XoopsModule  $module
	 * 
	 * @return	void
	**/
	public static function getModule(/*** Legacy_AbstractModule ***/ &$obj,/*** XoopsModule ***/ $module)
	{
		if($module->getInfo('trust_dirname') == 'letag')
		{
			require_once LETAG_TRUST_PATH . '/class/Module.class.php';
			$obj = new Letag_Module($module);
		}
	}

	/**
	 * getBlock
	 * 
	 * @param	Legacy_AbstractBlockProcedure  &$obj
	 * @param	XoopsBlock	$block
	 * 
	 * @return	void
	**/
	public static function getBlock(/*** Legacy_AbstractBlockProcedure ***/ &$obj,/*** XoopsBlock ***/ $block)
	{
		$moduleHandler =& Letag_Utils::getXoopsHandler('module');
		$module =& $moduleHandler->get($block->get('mid'));
		if(is_object($module) && $module->getInfo('trust_dirname') == 'letag')
		{
			require_once LETAG_TRUST_PATH . '/blocks/' . $block->get('func_file');
			$className = 'Letag_' . substr($block->get('show_func'), 4);
			$obj = new $className($block);
		}
	}

	/**
	 * addTagSelectScript
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public static function addTagSelectScript($jQuery)
	{
        $jQuery->addScript('
$(".tag_select span").click(function(){
    var tagText = $("#legacy_xoopsform_tags").val();
    var delimiter = " ";
    // search tag in textbox
    if (tagText.indexOf($(this).text()) >= 0) {
        // Delete the tag from textbox if already exists
        $("#legacy_xoopsform_tags").val(tagText.replace($(this).text() + delimiter, ""));
    } else {
        // Add the tag to textbox if not exists.
        $("#legacy_xoopsform_tags").val(tagText + $(this).text() + delimiter);
    }
});
');
	}
}

?>
