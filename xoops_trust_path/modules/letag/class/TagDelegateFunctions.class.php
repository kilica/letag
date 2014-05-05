<?php
/**
 * Created by PhpStorm.
 * User: ICHIKAWA
 * Date: 14/04/10
 * Time: 16:58
 */

class Letag_TagDelegate implements Legacy_iTagDelegate
{
    /**
     * setTags
     *
     * @param bool		&$result
     * @param string	$tDirname	//Legacy_Tag module's dirname
     * @param string	$dirname
     * @param string	$dataname
     * @param int		$dataId
     * @param int		$posttime
     * @param string[]	$tagArr
     */
    public static function setTags(&$result, $tDirname, $dirname, $dataname, $dataId, $posttime, $tagArr)
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
