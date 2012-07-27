<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

//http://prism-perfect.net/archive/php-tag-cloud-tutorial/
// connect to database at some point

// In the SQL below, change these three things:
// thing is the column name that you are making a tag cloud for
// id is the primary key
// my_table is the name of the database table

//$where : url or uid

class Letag_TagCloud
{
	protected $_mWhere = "";
	protected $_mMin = 0;	//minimum font size(%)
	protected $_mMax = 0;	//max font size(%)
	protected $_mMaxQty = 1;	//max number of tag
	protected $_mMinQty = 1;	//minimum number of tag
	protected $_mStep = 1;
	protected $_mDirname = "";
	public $mTagArr = array();

    /**
     * __construct
     * 
     * @param   string  $where
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public function __construct(/*** string ***/ $where = null, /*** string ***/ $dirname)
    {
        $this->_mDirname = $dirname;
        $this->_mWhere = $where;
    
    	$this->_setFontSizeByConfig();
        $this->_createTagArr();
    }

	protected function _createTagArr()
	{
		$db =& Database::getInstance() ;
		$myts =& MyTextsanitizer::getInstance() ;
		$wh = ($this->_mWhere) ? " WHERE ". $this->_mWhere : "";
		
		$sql = "SELECT tag_name AS tag, COUNT(tag_id) AS quantity
		  FROM ". $db->prefix($this->_mDirname ."_tag") .$wh. "
		  GROUP BY tag_name
		  ORDER BY tag_name ASC";
		$result = $db->query( $sql ) ;
		//echo $sql;var_dump($result);die();
	
		// here we loop through the results and put them into a simple array:
		// $tag['thing1'] = 12;
		// $tag['thing2'] = 25;
		// etc. so we can use all the nifty array functions
		// to calculate the font-size of each tag
	
		while ($row = $db->fetchRow($result)) {
		    $this->mTagArr[$myts->makeTboxData4Show($row['0'])] = $row[1];
		}
	}

	/**
	 *  getFontSizeByConfig
	 *
	 *  @param   void
     * 
     * @return  void
	 */
	protected function _setFontSizeByConfig()
	{
        $configHandler =& Dbkmarken_Utils::getXoopsHandler('config');
		$configArr =& $configHandler->getConfigsByDirname($this->_mDirname);
	
		$this->setFontSize($configArr['tagcloud_min'], $configArr['tagcloud_max']);
	}

    /**
     * setFontSize
     * 
     * @param   int  $min
     * @param   int  $max
     * 
     * @return  void
    **/
	public function setFontSize($min = 80, $max = 200)
	{
        $this->_mMin = $min;	//minimum font size(%)
        $this->_mMax = $max;	//max font size(%)
	}

    /**
     * _calcSize
     * 
     * @param   void
     * 
     * @return  void
    **/
	protected function _calcSize()
	{
		// get the largest and smallest array values
		if($this->mTagArr){
			$this->_mMaxQty = max(array_values($this->mTagArr));
			$this->_mMinQty = min(array_values($this->mTagArr));
		}

		// find the range of values
		$spread = $this->_mMaxQty - $this->_mMinQty;
		if ($spread<=0) { // we don't want to divide by zero
		    $spread = 1;
		}

		// determine the font-size increment
		// this is the increase per tag quantity (times used)
		$this->_mStep = ($this->_mMax - $this->_mMin)/($spread);
	}

    /**
     * getTagCloudHtml
     * 
     * @param   void
     * 
     * @return  string
    **/
	public function getTagCloudHtml($uid=0)
	{
		$html = "";
	
		$this->_calcSize();
	
		// loop through our tag array
		foreach ($this->mTagArr as $key => $value) {
		    // calculate CSS font-size
		    // find the $value in excess of $min_qty
		    // multiply by the font-size increment ($size)
		    // and add the $min_size set above
		    $size = $this->_mMin + (($value - $this->_mMinQty) * $this->_mStep);
		    // uncomment if you want sizes in whole %:
		    // $size = ceil($size);
		
		    // you'll need to put the link destination in place of the #
		    // (assuming your tag links to some sort of details page)
		    $html .= '<a href="'. XOOPS_MODULE_URL .'/'. $this->_mDirname .'/index.php?action=TagList&tag_name='. urlencode($key);
		    if($uid>0){
		    	$html .= '&uid='. $uid;
		    }
		    $html .= '" style="font-size: '.$size.'%">'.$key.'</a> ';
		    // notice the space at the end of the link
		}
	    return $html;
	}
}
?>
