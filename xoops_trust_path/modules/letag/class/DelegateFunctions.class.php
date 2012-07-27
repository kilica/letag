<?php
/**
 * @package letag
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Letag_CoolUriDelegate
{
	/**
	 * getNormalUri
	 *
	 * @param string	$uri
	 * @param string	$dirname
	 * @param string	$dataname
	 * @param int		$data_id
	 * @param string	$action
	 * @param string	$query
	 *
	 * @return	void
	 */ 
	public static function getNormalUri(/*** string ***/ &$uri, /*** string ***/ $dirname, /*** string ***/ $dataname=null, /*** int ***/ $data_id=0, /*** string ***/ $action=null, /*** string ***/ $query=null)
	{
		$sUri = '/%s/index.php?action=%s%s';
		$lUri = '/%s/index.php?action=%s%s&%s=%d';
		$table = isset($dataname) ? $dataname : 'Tag';
	
		$key = $table.'_id';
	
		if(isset($dataname)){
			if($data_id>0){
				if(isset($action)){
					$uri = sprintf($lUri, $dirname, ucfirst($dataname), ucfirst($action), $key, $data_id);
				}
				else{
					$uri = sprintf($lUri, $dirname, ucfirst($dataname), 'View', $key, $data_id);
				}
			}
			else{
				if(isset($action)){
					$uri = sprintf($sUri, $dirname, ucfirst($dataname), ucfirst($action));
				}
				else{
					$uri = sprintf($sUri, $dirname, ucfirst($dataname), 'List');
				}
			}
			$uri = isset($query) ? $uri.'&'.$query : $uri;
		}
		else{
			if($data_id>0){
				if(isset($action)){
					die();
				}
				else{
					$handler = Legacy_Utils::getModuleHandler($table, $dirname);
					$key = $handler->mPrimary;
					$uri = sprintf($lUri, $dirname, ucfirst($table).'View', ucfirst($action), $key, $data_id);
				}
				$uri = isset($query) ? $uri.'&'.$query : $uri;
			}
			else{
				if(isset($action)){
					die();
				}
				else{
					$uri = sprintf('/%s/', $dirname);
					$uri = isset($query) ? $uri.'index.php?'.$query : $uri;
				}
			}
		}
	}
}


class Letag_TagDelegate implements Legacy_iTagDelegate
{
	/**
	 * setTags
	 *
	 * @param bool		$result
	 * @param string	$tDirname	//Legacy_Tag module's dirname
	 * @param string	$dirname
	 * @param string	$dataname
	 * @param int		$dataId
	 * @param int		$posttime
	 * @param string[]	$tagArr
	 */	
	public static function setTags($result, $tDirname, $dirname, $dataname, $dataId, $posttime, $tagArr)
	{
		$handler = Legacy_Utils::getModuleHandler('tag', $tDirname);
		$result = $handler->updateTags($dirname, $dataname, $dataId, $tagArr, $posttime);
	}

	/**
	 * get tags from dirname/dataname/data_id
	 *
	 * @param string[] $tagArr
	 * @param string	$tDirname	//Legacy_Tag module's dirname
	 * @param string	$dirname
	 * @param string	$dataname
	 * @param int		$dataId
	 */	
	public static function getTags(&$tagArr, $tDirname, $dirname, $dataname, $dataId)
	{
		$handler = Legacy_Utils::getModuleHandler('tag', $tDirname);
		$objs = $handler->getTags($dirname, $dataname, $dataId);
		foreach($objs as $obj){
			$tagArr[] = $obj->get('tag');
		}
	}

	/**
	 * getTagCloudSrc
	 *
	 * @param mixed		$cloud
	 *	 $cloud[$tag] = $count
	 * @param string	$tDirname	//Legacy_Tag module's dirname
	 * @param string	$dirname
	 * @param string	$dataname
	 * @param int[]		$uidList
	 */	
	public static function getTagCloudSrc(&$cloud, $tDirname, $dirname=null, $dataname=null, $uidList=array())
	{
		$handler = Legacy_Utils::getModuleHandler('tag', $tDirname);
		$cri = Letag_Utils::getTagCriteria($dirname, $dataname, null, $uidList);
		$cloud = $handler->getTagList($cri);
	}

	/**
	 * getDataIdListByTags
	 *
	 * @param int[]		$list
	 * @param string	$tDirname	//Legacy_Tag module's dirname
	 * @param string[]	$tagArr
	 * @param string	$dirname
	 * @param string	$dataname
	 */	
	public static function getDataIdListByTags(&$list, $tDirname, $tagArr, $dirname, $dataname)
	{
		if(count($tagArr)===0) return;
	
		$handler = Legacy_Utils::getModuleHandler('tag', $tDirname);
		$list = $handler->getDataIdListByTags($tagArr, $dirname, $dataname);
	}
}


?>
