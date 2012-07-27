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

require_once LETAG_TRUST_PATH . '/class/AbstractFilterForm.class.php';

define('LETAG_TAG_SORT_KEY_TAG_ID', 1);
define('LETAG_TAG_SORT_KEY_TAG', 2);
define('LETAG_TAG_SORT_KEY_UID', 3);
define('LETAG_TAG_SORT_KEY_DIRNAME', 4);
define('LETAG_TAG_SORT_KEY_DATANAME', 5);
define('LETAG_TAG_SORT_KEY_DATA_ID', 6);
define('LETAG_TAG_SORT_KEY_POSTTIME', 7);

define('LETAG_TAG_SORT_KEY_DEFAULT', LETAG_TAG_SORT_KEY_TAG_ID);

/**
 * Letag_TagFilterForm
**/
class Letag_TagFilterForm extends Letag_AbstractFilterForm
{
    public /*** string[] ***/ $mSortKeys = array(
 	   LETAG_TAG_SORT_KEY_TAG_ID => 'tag_id',
 	   LETAG_TAG_SORT_KEY_TAG => 'tag',
 	   LETAG_TAG_SORT_KEY_UID => 'uid',
 	   LETAG_TAG_SORT_KEY_DIRNAME => 'dirname',
 	   LETAG_TAG_SORT_KEY_DATANAME => 'dataname',
 	   LETAG_TAG_SORT_KEY_DATA_ID => 'data_id',
 	   LETAG_TAG_SORT_KEY_POSTTIME => 'posttime',

    );

    /**
     * getDefaultSortKey
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function getDefaultSortKey()
    {
        return LETAG_TAG_SORT_KEY_DEFAULT;
    }

    /**
     * fetch
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function fetch()
    {
        parent::fetch();
    
        $root =& XCube_Root::getSingleton();
    
		if (($value = $root->mContext->mRequest->getRequest('tag_id')) !== null) {
			$this->mNavi->addExtra('tag_id', $value);
			$this->_mCriteria->add(new Criteria('tag_id', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('tag')) !== null) {
			$this->mNavi->addExtra('tag', $value);
			$this->_mCriteria->add(new Criteria('tag', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
			$this->mNavi->addExtra('uid', $value);
			$this->_mCriteria->add(new Criteria('uid', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('dirname')) !== null) {
			$this->mNavi->addExtra('dirname', $value);
			$this->_mCriteria->add(new Criteria('dirname', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('dataname')) !== null) {
			$this->mNavi->addExtra('dataname', $value);
			$this->_mCriteria->add(new Criteria('dataname', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('data_id')) !== null) {
			$this->mNavi->addExtra('data_id', $value);
			$this->_mCriteria->add(new Criteria('data_id', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('posttime')) !== null) {
			$this->mNavi->addExtra('posttime', $value);
			$this->_mCriteria->add(new Criteria('posttime', $value));
		}

    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
