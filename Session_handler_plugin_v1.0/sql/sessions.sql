CREATE TABLE `visitors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cookie` varchar(35) NOT NULL DEFAULT '',
  `type` set('visitor','session') NOT NULL DEFAULT 'session',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `user_agent` varchar(255) NOT NULL DEFAULT '',
  `browser` varchar(255) NOT NULL DEFAULT '',
  `version` varchar(5) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

CREATE TABLE `visitors_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `visitor_id` bigint(20) NOT NULL,
  `data_name` varchar(255) NOT NULL DEFAULT '',
  `data_value` text,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;