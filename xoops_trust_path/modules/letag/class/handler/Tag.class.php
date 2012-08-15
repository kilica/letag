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

/**
 * Letag_TagObject
**/
class Letag_TagObject extends XoopsSimpleObject
{
	public $mPrimary = 'tag_id';
	public $mDataname = 'tag';

	/**
	 * __construct
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function __construct()
	{
		$this->initVar('tag_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('tag', XOBJ_DTYPE_STRING, '', false, 60);
		$this->initVar('uid', XOBJ_DTYPE_INT, '', false);
		$this->initVar('dirname', XOBJ_DTYPE_STRING, '', false, 25);
		$this->initVar('dataname', XOBJ_DTYPE_STRING, '', false, 25);
		$this->initVar('data_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('posttime', XOBJ_DTYPE_INT, '', false);
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
	public function getClientData(/*** mixed[] ***/ $list, /*** mixed[] ***/ $client)
	{
		$handler = Legacy_Utils::getModuleHandler('tag', $this->getDirname());
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('tag', $this->get('tag')));
		$cri->add(new Criteria('dirname', $client['dirname']));
		$cri->add(new Criteria('dataname', $client['dataname']));
		$cri->setSort('posttime', 'DESC');
		$objs = $handler->getObjects($cri);
		$idList = array();
		foreach($objs as $obj){
			$idList[] = $obj->get('data_id');
		}
	
		XCube_DelegateUtils::call('Legacy_TagClient.'.$client['dirname'].'.GetClientData', new XCube_Ref($list), $client['dirname'], $client['dataname'], $idList);
		return $list;
	}

	/**
	 * getPrimary
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getPrimary()
	{
		return self::PRIMARY;
	}

	/**
	 * getDataname
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getDataname()
	{
		return self::DATANAME;
	}
}

/**
 * Letag_TagHandler
**/
class Letag_TagHandler extends XoopsObjectGenericHandler
{
	public /*** string ***/ $mTable = '{dirname}_tag';

	public /*** string ***/ $mPrimary = 'tag_id';

	public /*** string ***/ $mClass = 'Letag_TagObject';

	/**
	 * __construct
	 * 
	 * @param	XoopsDatabase  &$db
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public function __construct(/*** XoopsDatabase ***/ &$db,/*** string ***/ $dirname)
	{
		$this->mTable = strtr($this->mTable,array('{dirname}' => $dirname));
		parent::XoopsObjectGenericHandler($db);
	}

	/**
	 * getTags
	 * 
	 * @param	string	$dirname
	 * @param	string  $dataname
	 * @param	int		$dataId
	 * @param	int[]	$uidList
	 * 
	 * @return	Letag_TagObject[]
	**/
	public function getTags(/*** string ***/ $dirname=null, /*** string ***/ $dataname=null, /*** string ***/ $dataId=0, /*** int[] ***/ $uidList=array())
	{
		$cri = Letag_Utils::getTagCriteria($dirname, $dataname, $dataId, $uidList);
		return $this->getObjects($cri);
	}

	/**
	 * updateTags
	 * 
	 * @param	string	$dirname
	 * @param	string  $dataname
	 * @param	int		$dataId
	 * @param	string[]	$tagArr
	 * @param	int		$posttime
	 * 
	 * @return	bool
	**/
	public function updateTags(/*** string ***/ $dirname, /*** string ***/ $dataname, /*** string ***/ $dataId, /*** string[] ***/ $tagArr, /*** int ***/ $posttime)
	{
		$flag = true;	//result flag for database delete/insert
		$oldTagArr = array();
		$tagArr = array_unique($tagArr);
		$uid = Legacy_Utils::getUid();
		if(! $dirname || ! $dataname || ! $dataId){
			$flag = false;
			return;
		}
	
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('dirname', $dirname));
		$cri->add(new Criteria('dataname', $dataname));
		$cri->add(new Criteria('data_id', $dataId));
		$objs = $this->getObjects($cri);
		foreach(array_keys($objs) as $key){
			$oldTagArr[] = $objs[$key]->get('tag');
		}
	
		//remove deleted tags
		$deleteTags = array_diff($oldTagArr, $tagArr);
		$delCri = new CriteriaCompo();
		$delCri->add(new Criteria('dirname', $dirname));
		$delCri->add(new Criteria('dataname', $dataname));
		$delCri->add(new Criteria('data_id', $dataId));
		$delCri->add(new Criteria('tag', $deleteTags, 'IN'));
		if(! $this->deleteAll($delCri, true)){
			$flag = false;
		}
	
		//insert additional tags
		$addTags = array_diff($tagArr, $oldTagArr);
		foreach($addTags as $newTag){
			$newTagObj = $this->create();
			$newTagObj->set('tag', trim($newTag));
			$newTagObj->set('dirname', $dirname);
			$newTagObj->set('dataname', $dataname);
			$newTagObj->set('data_id', $dataId);
			$newTagObj->set('uid', $uid);
			$newTagObj->set('posttime', $posttime);
			if(trim($newTag) && !$this->insert($newTagObj, true)){
				$flag = false;
			}
		}
		return $flag;
	}

	/**
	 * getDataIdListByTags
	 *
	 * @param string[]	$tagArr
	 * @param string	$dirname
	 * @param string	$dataname
	 *
	 * @return $int[]
	 */	
	public function getDataIdListByTags($tagArr, $dirname, $dataname)
	{
		$tagIds = array();
		$ids = array();
		foreach($tagArr as $tag){
			$cri = new CriteriaCompo();
			$cri->add(new Criteria('tag', $tag));
			$cri->add(new Criteria('dirname', $dirname));
			$cri->add(new Criteria('dataname', $dataname));
			$objs = $this->getObjects($cri);
			$ids = array();
			foreach($objs as $obj){
				$ids[$obj->get('tag_id')] = $obj->get('data_id');
			}
			$tagIds[] = $ids;
		}
		//filter tag_id 
		if(count($tagIds)>0){
			$ids = array_shift($tagIds);
			for($i=0;$i<count($tagIds);$i++){
				$ids = array_intersect($ids, $tagIds[$i]);
			}
		}
		return $ids;
	}

	/**
	 * get uniqued tag list
	 * 
	 * @access public
	 * @param CriteriaElement $criteria
	 * 
	 * @return array
	 */
	public function &getTagList($criteria = null)
	{
		$ret = array();
		$where = "";
	
		if($criteria !== null && is_a($criteria, 'CriteriaElement')) {
			$where = $this->_makeCriteria4sql($criteria);
			if (trim($where)) {
				$where = " WHERE " . $where;
			}
		}
	
		$sql = "SELECT tag, COUNT(tag_id) AS quantity
		  FROM ". $this->mTable .$where. "
		  GROUP BY tag
		  ORDER BY tag ASC";
	
		$result = $this->db->query($sql);
	
		if (!$result) {
			return $ret;
		}
	
		// here we loop through the results and put them into a simple array:
		// $tag['thing1'] = 12;
		// $tag['thing2'] = 25;
		// etc. so we can use all the nifty array functions
		// to calculate the font-size of each tag
		while($row = $this->db->fetchArray($result)) {
		    $ret[$row['tag']] = $row['quantity'];
		}
		return $ret;
	}
}

?>
