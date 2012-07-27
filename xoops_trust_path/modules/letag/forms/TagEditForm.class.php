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

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH . '/legacy/class/Legacy_Validator.class.php';

/**
 * Letag_TagEditForm
**/
class Letag_TagEditForm extends XCube_ActionForm
{
	/**
	 * getTokenName
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getTokenName()
	{
		return "module.letag.TagEditForm.TOKEN";
	}

	/**
	 * prepare
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['tag_id'] = new XCube_IntProperty('tag_id');
		$this->mFormProperties['tag'] = new XCube_StringProperty('tag');
		$this->mFormProperties['uid'] = new XCube_IntProperty('uid');
		$this->mFormProperties['dirname'] = new XCube_StringProperty('dirname');
		$this->mFormProperties['dataname'] = new XCube_StringProperty('dataname');
		$this->mFormProperties['data_id'] = new XCube_IntProperty('data_id');
		$this->mFormProperties['posttime'] = new XCube_IntProperty('posttime');

	
		//
		// Set field properties
		//
		$this->mFieldProperties['tag_id'] = new XCube_FieldProperty($this);
$this->mFieldProperties['tag_id']->setDependsByArray(array('required'));
$this->mFieldProperties['tag_id']->addMessage('required', _MD_LETAG_ERROR_REQUIRED, _MD_LETAG_LANG_TAG_ID);
		$this->mFieldProperties['tag'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['tag']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['tag']->addMessage('required', _MD_LETAG_ERROR_REQUIRED, _MD_LETAG_LANG_TAG);
		$this->mFieldProperties['tag']->addMessage('maxlength', _MD_LETAG_ERROR_MAXLENGTH, _MD_LETAG_LANG_TAG, '60');
		$this->mFieldProperties['tag']->addVar('maxlength', '60');
		$this->mFieldProperties['uid'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['dirname'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['dirname']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['dirname']->addMessage('required', _MD_LETAG_ERROR_REQUIRED, _MD_LETAG_LANG_DIRNAME);
		$this->mFieldProperties['dirname']->addMessage('maxlength', _MD_LETAG_ERROR_MAXLENGTH, _MD_LETAG_LANG_DIRNAME, '25');
		$this->mFieldProperties['dirname']->addVar('maxlength', '25');
		$this->mFieldProperties['dataname'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['dataname']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['dataname']->addMessage('required', _MD_LETAG_ERROR_REQUIRED, _MD_LETAG_LANG_DATANAME);
		$this->mFieldProperties['dataname']->addMessage('maxlength', _MD_LETAG_ERROR_MAXLENGTH, _MD_LETAG_LANG_DATANAME, '25');
		$this->mFieldProperties['dataname']->addVar('maxlength', '25');
		$this->mFieldProperties['data_id'] = new XCube_FieldProperty($this);
$this->mFieldProperties['data_id']->setDependsByArray(array('required'));
$this->mFieldProperties['data_id']->addMessage('required', _MD_LETAG_ERROR_REQUIRED, _MD_LETAG_LANG_DATA_ID);
		$this->mFieldProperties['posttime'] = new XCube_FieldProperty($this);
$this->mFieldProperties['posttime']->setDependsByArray(array('required'));
$this->mFieldProperties['posttime']->addMessage('required', _MD_LETAG_ERROR_REQUIRED, _MD_LETAG_LANG_POSTTIME);

	}

	/**
	 * load
	 * 
	 * @param	XoopsSimpleObject  &$obj
	 * 
	 * @return	void
	**/
	public function load(/*** XoopsSimpleObject ***/ &$obj)
	{
		$this->set('tag_id', $obj->get('tag_id'));
		$this->set('tag', $obj->get('tag'));
		$this->set('uid', $obj->get('uid'));
		$this->set('dirname', $obj->get('dirname'));
		$this->set('dataname', $obj->get('dataname'));
		$this->set('data_id', $obj->get('data_id'));
		$this->set('posttime', $obj->get('posttime'));
	}

	/**
	 * update
	 * 
	 * @param	XoopsSimpleObject  &$obj
	 * 
	 * @return	void
	**/
	public function update(/*** XoopsSimpleObject ***/ &$obj)
	{
		$obj->set('tag', $this->get('tag'));
		$obj->set('dirname', $this->get('dirname'));
		$obj->set('dataname', $this->get('dataname'));
		$obj->set('data_id', $this->get('data_id'));
		$obj->set('posttime', $this->get('posttime'));
	}
}

?>
