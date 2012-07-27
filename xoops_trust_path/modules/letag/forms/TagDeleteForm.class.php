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
 * Letag_TagDeleteForm
**/
class Letag_TagDeleteForm extends XCube_ActionForm
{
    /**
     * getTokenName
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getTokenName()
    {
        return "module.letag.TagDeleteForm.TOKEN";
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['tag_id'] = new XCube_IntProperty('tag_id');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['tag_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['tag_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['tag_id']->addMessage('required', _MD_LETAG_ERROR_REQUIRED, _MD_LETAG_LANG_TAG_ID);
    }

    /**
     * load
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function load(/*** XoopsSimpleObject ***/ &$obj)
    {
        $this->set('tag_id', $obj->get('tag_id'));
    }

    /**
     * update
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function update(/*** XoopsSimpleObject ***/ &$obj)
    {
        $obj->set('tag_id', $this->get('tag_id'));
    }
}

?>
