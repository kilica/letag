CREATE TABLE `{prefix}_{dirname}_tag` (
  `tag_id` int(11) unsigned NOT NULL  auto_increment,
  `tag` varchar(60) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `dirname` varchar(25) NOT NULL,
  `dataname` varchar(25) NOT NULL,
  `data_id` int(11) unsigned NOT NULL,
  `posttime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`tag_id`),
  UNIQUE KEY uid_groupid (`tag`,`dirname`,`dataname`,`data_id`),
  KEY `tag` (`tag`),
  KEY `moduledata` (`dirname`) ,
  KEY `data` (`dirname`, `dataname`, `data_id`)
  ) ENGINE=MyISAM;

