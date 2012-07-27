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

require_once LETAG_TRUST_PATH . '/class/AbstractViewAction.class.php';

/**
 * Letag_TagViewAction
**/
class Letag_TagViewAction extends Letag_AbstractAction
{
	/**
	 * _getTagRequest
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	protected function _getTagRequest()
	{
		return $this->mRoot->mContext->mRequest->getRequest('tag');
	}

	/**
	 * _getTitle
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	protected function _getTitle()
	{
		return $this->_getTagRequest();
	}

	/**
	 * prepare
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function prepare()
	{
		$ret = parent::prepare();
		$this->mObjectHandler = Legacy_Utils::getModuleHandler('tag', $this->mAsset->mDirname);
		return $ret;
	}

	/**
	 * getDefaultView
	 * 
	 * @param	void
	 * 
	 * @return	Enum
	**/
	public function getDefaultView()
	{
		return ($this->_getTagRequest()) ? LETAG_FRAME_VIEW_SUCCESS : LETAG_FRAME_VIEW_ERROR;
	}

	/**
	 * getClientData
	 * 
	 * @param	array	$list
	 *  $client['template_name']
	 *  $client['data']
	 *  $client['dirname']
	 * @param	array	$client
	 *  $client['dirname']
	 *  $client['dataname']
	 * 
	 * @return	mixed[]
	 *	string	$list['template_name'][]
	 *	string	$list['data'][]
	**/
	protected function _getClientData(/*** mixed[] ***/ $list, /*** mixed[] ***/ $client, /*** string ***/ $tag)
	{
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('tag', $tag));
		$cri->add(new Criteria('dirname', $client['dirname']));
		$cri->add(new Criteria('dataname', $client['dataname']));
		$cri->setSort('posttime', 'DESC');
		$objs = $this->mObjectHandler->getObjects($cri);
		$idList = array();
		foreach($objs as $obj){
			$idList[] = $obj->get('data_id');
		}
	
		XCube_DelegateUtils::call('Legacy_TagClient.'.$client['dirname'].'.GetClientData', new XCube_Ref($list), $client['dirname'], $client['dataname'], $idList);
		return $list;
	}

	/**
	 * executeViewSuccess
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
	{
		$tag = $this->_getTagRequest();
		$render->setTemplateName($this->mAsset->mDirname . '_tag_view.html');
		$render->setAttribute('tag', $tag);
		$clientList = Letag_Utils::getClientList($this->mAsset->mDirname);
		$dataList = array();
		foreach($clientList as $client){
			$dataList = $this->_getClientData($dataList, $client, $tag);
		}
		$render->setAttribute('clientList', $clientList);
		$render->setAttribute('clients', $dataList);
	}

	/**
	 * executeViewError
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewError(/*** XCube_RenderTarget ***/ &$render)
	{
		$this->mRoot->mController->executeRedirect($this->_getNextUri('tag', 'list'), 1, _MD_LETAG_ERROR_CONTENT_IS_NOT_FOUND);
	}
}

?>
