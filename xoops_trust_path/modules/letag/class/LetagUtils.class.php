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
 * Letag_Utils
**/
class Letag_Utils
{
    /**
     * &getXoopsHandler
     *
     * @param   string  $name
     * @param   bool  $optional
     *
     * @return  XoopsObjectHandler
    **/
    public static function &getXoopsHandler(/*** string ***/ $name,/*** bool ***/ $optional = false)
    {
        // TODO will be emulated xoops_gethandler
        return xoops_gethandler($name,$optional);
    }

    /**
     * getClientList
     *
     * @param   string  $dirname
     *
     * @return  array
    **/
	public static function getClientList(/*** string ***/ $dirname)
	{
		$clients = array();
		$list = array();
		XCube_DelegateUtils::call('Legacy_TagClient.GetClientList', new XCube_Ref($clients), $dirname);

		foreach($clients as $module){
			$list[] = array('dirname'=>trim($module['dirname']), 'dataname'=>trim($module['dataname']));
		}
		return $list;
	}

	/**
	 * getTagCriteria
	 *
	 * @param	string	$dirname
	 * @param	string  $dataname
	 * @param	int		$dataId
	 * @param	int[]	$uidList
	 *
	 * @return	CriteriaCompo
	**/
	public static function getTagCriteria(/*** string ***/ $dirname=null, /*** string ***/ $dataname=null, /*** string ***/ $dataId=0, /*** int[] ***/ $uidList=array())
	{
		$cri = new CriteriaCompo();
		if(isset($dirname)){
			$cri->add(new Criteria('dirname', $dirname));
			if(isset($dataname)){
				$cri->add(new Criteria('dataname', $dataname));
				if($dataId>0){
					$cri->add(new Criteria('data_id', $dataId));
				}
			}
		}
        // PHP 7.2, count() method does not support Null as a parameter
        if ( (!empty($uidList)) && (count( $uidList ) ) {
            $cri->add(new Criteria('uid', $uidList, 'IN'))
        })

	/* 	if(count($uidList)>0){
			$cri->add(new Criteria('uid', $uidList, 'IN'));
		}  */
		return $cri;
	}
}

