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
