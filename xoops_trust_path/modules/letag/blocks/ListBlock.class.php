<?php
/**
 * @file
 * @package letag
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit();
}

/**
 * Letag_ListBlock
**/
class Letag_ListBlock extends Legacy_BlockProcedure
{
    /**
     * @var string[]
     * 
     * @private
    **/
    var $_mOptions = array();
    
    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  bool
     * 
     * @public
    **/
    function prepare()
    {
        return parent::prepare() && $this->_parseOptions();
    }
    
    /**
     * _parseOptions
     * 
     * @param   void
     * 
     * @return  bool
     * 
     * @private
    **/
    function _parseOptions()
    {
        $opts = explode('|',$this->_mBlock->get('options'));
        $this->_mOptions = array(
            'dirname'	=> $opts[0],
            'dataname'	=> $opts[1],
            'uidList'	=> $opts[2],
            'min'	=> $opts[3],
            'max'	=> $opts[4],
        );
        return true;
    }
    
    /**
     * getBlockOption
     * 
     * @param   string  $key
     * 
     * @return  string
     * 
     * @public
    **/
    function getBlockOption($key)
    {
        return $this->_mOptions[$key] ? $this->_mOptions[$key] : null;
    }
    
    /**
     * getOptionForm
     * 
     * @param   void
     * 
     * @return  string
     * 
     * @public
    **/
    function getOptionForm()
    {
        if(!$this->prepare())
        {
            return null;
        }
		$form = '<label for="'. $this->_mBlock->get('dirname') .'block_dirname">'._AD_LETAG_LANG_DIRNAME.'</label>&nbsp;:
		<input type="text" size="10" name="options[0]" id="'. $this->_mBlock->get('dirname') .'block_dirname" value="'.$this->getBlockOption('dirname').'" /><br />
		<label for="'. $this->_mBlock->get('dirname') .'block_dataname">'._AD_LETAG_LANG_DATANAME.'</label>&nbsp;:
		<input type="text" size="10" name="options[1]" id="'. $this->_mBlock->get('dirname') .'block_dataname" value="'.$this->getBlockOption('dataname').'" /><br />
		<label for="'. $this->_mBlock->get('dirname') .'block_uid_list">'._AD_LETAG_LANG_UIDLIST.'</label>&nbsp;:
		<input type="text" size="10" name="options[2]" id="'. $this->_mBlock->get('dirname') .'block_uidList" value="'.$this->getBlockOption('uidList').'" /><br />
		<label for="'. $this->_mBlock->get('dirname') .'block_max">'._AD_LETAG_LANG_MIN.'</label>&nbsp;:
		<input type="text" size="10" name="options[3]" id="'. $this->_mBlock->get('dirname') .'block_min" value="'.$this->getBlockOption('min').'" /><br />
		<label for="'. $this->_mBlock->get('dirname') .'block_max">'._AD_LETAG_LANG_MAX.'</label>&nbsp;:
		<input type="text" size="10" name="options[4]" id="'. $this->_mBlock->get('dirname') .'block_max" value="'.$this->getBlockOption('max').'" />';

		return $form;
    }

    /**
     * execute
     * 
     * @param   void
     * 
     * @return  void
     * 
     * @public
    **/
    function execute()
    {
        $root =& XCube_Root::getSingleton();
    
        $render =& $this->getRenderTarget();
        $render->setTemplateName($this->_mBlock->get('template'));
        $render->setAttribute('tDirname', $this->_mBlock->get('dirname'));
        $render->setAttribute('dirname', $this->getBlockOption('dirname'));
        $render->setAttribute('dataname', $this->getBlockOption('dataname'));
        $render->setAttribute('uidList', $this->getBlockOption('uidList'));
        $render->setAttribute('min', $this->getBlockOption('min'));
        $render->setAttribute('max', $this->getBlockOption('max'));
        $render->setAttribute('template', $this->_mBlock->get('dirname').'_inc_tag_cloud.html');
        $renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
        $renderSystem->renderBlock($render);
    }
}

?>
