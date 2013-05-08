#
# TABLE STRUCTURE FOR: category
#

DROP TABLE IF EXISTS category;

CREATE TABLE `category` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL COMMENT '缩略标题',
  `reid` tinyint(4) NOT NULL COMMENT '上层ID',
  `typename` varchar(50) NOT NULL COMMENT '类别名称',
  `channeltype` varchar(50) NOT NULL COMMENT '频道模型',
  `tempindex` varchar(30) NOT NULL COMMENT '模板首页或者列表路径',
  `temparticle` varchar(30) NOT NULL COMMENT '模板内容路径',
  PRIMARY KEY (`id`,`slug`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='分类目录';

INSERT INTO category (`id`, `slug`, `reid`, `typename`, `channeltype`, `tempindex`, `temparticle`) VALUES (1, 'update', 0, '更新日志', 'post', 'category', 'post');


#
# TABLE STRUCTURE FOR: comment
#

DROP TABLE IF EXISTS comment;

CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `reid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上个回复ID',
  `username` varchar(50) NOT NULL COMMENT '姓名',
  `usermail` varchar(30) NOT NULL COMMENT '邮件地址',
  `userurl` varchar(50) NOT NULL DEFAULT '' COMMENT '链接地址',
  `content` text NOT NULL COMMENT '留言内容',
  `posttime` datetime NOT NULL COMMENT '评论时间',
  `ip` char(20) NOT NULL COMMENT 'IP地址',
  `ishidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `ispass` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否通过',
  PRIMARY KEY (`id`,`uid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表';

#
# TABLE STRUCTURE FOR: friendlink
#

DROP TABLE IF EXISTS friendlink;

CREATE TABLE `friendlink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(100) NOT NULL COMMENT '略缩图',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `dec` varchar(100) NOT NULL COMMENT '链接描述',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `sortrank` int(4) unsigned NOT NULL COMMENT '排序 倒序',
  `ishidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='友情链接表';

INSERT INTO friendlink (`id`, `logo`, `title`, `dec`, `url`, `sortrank`, `ishidden`) VALUES (4, 'http://www.oschina.net/img/logo_s2.png', '开源中国OSCHINA', '开源中国 - 找到您想要的开源软件，分享和交流', 'http://www.oschina.net/', 50, 0);
INSERT INTO friendlink (`id`, `logo`, `title`, `dec`, `url`, `sortrank`, `ishidden`) VALUES (7, 'http://bbs.blueidea.com/static/image/common/logo.png', '蓝色理想', '蓝色理想', 'http://bbs.blueidea.com', 50, 0);


#
# TABLE STRUCTURE FOR: media
#

DROP TABLE IF EXISTS media;

CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL COMMENT '文件名称',
  `des` varchar(200) NOT NULL COMMENT '文件描述',
  `filepath` varchar(100) NOT NULL COMMENT '文件路径',
  `suffix` varchar(10) NOT NULL COMMENT '文件后缀',
  PRIMARY KEY (`id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='媒体库';

#
# TABLE STRUCTURE FOR: menu
#

DROP TABLE IF EXISTS menu;

CREATE TABLE `menu` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL COMMENT '菜单类型',
  `nav` varchar(50) NOT NULL COMMENT '菜单',
  `url` varchar(50) NOT NULL COMMENT '链接',
  `target` varchar(10) NOT NULL DEFAULT '_self' COMMENT '打开方式',
  `reid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `sortrank` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='菜单';

INSERT INTO menu (`id`, `type`, `nav`, `url`, `target`, `reid`, `sortrank`) VALUES (1, 'jump', '首页', 'index', '_self', 0, 0);
INSERT INTO menu (`id`, `type`, `nav`, `url`, `target`, `reid`, `sortrank`) VALUES (2, 'category', '更新日志', 'category/update', '_self', 0, 0);
INSERT INTO menu (`id`, `type`, `nav`, `url`, `target`, `reid`, `sortrank`) VALUES (3, 'page', '关于OWNCMS', 'page/about_owncms', '_self', 0, 0);


#
# TABLE STRUCTURE FOR: page
#

DROP TABLE IF EXISTS page;

CREATE TABLE `page` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `slug` varchar(100) NOT NULL COMMENT '缩略标题',
  `content` text NOT NULL COMMENT '内容',
  `posttime` datetime NOT NULL COMMENT '发表时间',
  `modifytime` datetime NOT NULL COMMENT '最后修改时间',
  `uid` int(10) unsigned NOT NULL COMMENT '作者ID',
  `template` varchar(50) NOT NULL COMMENT '模板名称',
  `ishidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  PRIMARY KEY (`slug`,`uid`),
  UNIQUE KEY `slug` (`slug`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='单页文档表';

INSERT INTO page (`id`, `title`, `slug`, `content`, `posttime`, `modifytime`, `uid`, `template`, `ishidden`) VALUES (1, '关于OWNCMS', 'about_owncms', '关于本软件', '2013-04-22 22:16:14', '0000-00-00 00:00:00', 1, 'page', 0);


#
# TABLE STRUCTURE FOR: post
#

DROP TABLE IF EXISTS post;

CREATE TABLE `post` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` tinyint(4) unsigned NOT NULL COMMENT '类别ID',
  `flag` varchar(50) NOT NULL COMMENT '属性',
  `litpic` varchar(100) NOT NULL COMMENT '略缩图',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `slug` varchar(100) NOT NULL COMMENT '缩略标题',
  `content` text NOT NULL COMMENT '内容',
  `keyword` varchar(200) NOT NULL COMMENT '关键词',
  `description` varchar(600) NOT NULL COMMENT '描述',
  `source` varchar(50) NOT NULL COMMENT '文章来源',
  `click` int(10) unsigned NOT NULL COMMENT '点击次数',
  `comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论次数',
  `comment_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许评论',
  `uid` int(10) unsigned NOT NULL COMMENT '作者ID',
  `sortrank` int(10) unsigned NOT NULL COMMENT '排序 倒序',
  `posttime` datetime NOT NULL COMMENT '发表时间',
  `modifytime` datetime NOT NULL COMMENT '最后修改时间',
  `template` varchar(50) NOT NULL COMMENT '模板名称',
  `tag` varchar(100) NOT NULL COMMENT '标签ID集合',
  `ishidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  PRIMARY KEY (`uid`, `id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章列表';

#
# TABLE STRUCTURE FOR: siteconfig
#

DROP TABLE IF EXISTS siteconfig;

CREATE TABLE `siteconfig` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL COMMENT '变量名称',
  `description` varchar(50) NOT NULL COMMENT '变量描述',
  `value` text NOT NULL COMMENT '变量值',
  `inputtype` varchar(10) NOT NULL COMMENT '值类型',
  PRIMARY KEY (`id`,`varname`),
  UNIQUE KEY `varname` (`varname`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='网站信息表';

INSERT INTO siteconfig (`id`, `varname`, `description`, `value`, `inputtype`) VALUES (1, 'sitename', '网站名称', 'OWNCMS', 'text');
INSERT INTO siteconfig (`id`, `varname`, `description`, `value`, `inputtype`) VALUES (2, 'short_sitename', '网站缩略名称', 'OWNCMS', 'text');
INSERT INTO siteconfig (`id`, `varname`, `description`, `value`, `inputtype`) VALUES (3, 'keyword', '网站关键词', 'OWNCMS，基于CI的内容管理程序', 'text');
INSERT INTO siteconfig (`id`, `varname`, `description`, `value`, `inputtype`) VALUES (4, 'description', '网站描述', 'OWNCMS，基于CI的内容管理程序', 'textarea');


#
# TABLE STRUCTURE FOR: tag
#

DROP TABLE IF EXISTS tag;

CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) NOT NULL COMMENT '标签',
  PRIMARY KEY (`id`,`tag`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='标签表';

#
# TABLE STRUCTURE FOR: user
#

DROP TABLE IF EXISTS user;

CREATE TABLE `user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `usermail` varchar(20) NOT NULL COMMENT '用户邮箱',
  `userurl` varchar(50) NOT NULL COMMENT '用户网址',
  `logintime` datetime NOT NULL COMMENT '登录时间',
  `loginip` char(19) NOT NULL COMMENT '登录IP',
  `logedtime` datetime NOT NULL COMMENT '上次登录时间',
  `logedip` char(19) NOT NULL COMMENT '上次登录IP',
  `regip` char(19) NOT NULL COMMENT '注册IP',
  `regtime` datetime NOT NULL COMMENT '注册时间',
  `group` tinyint(2) NOT NULL COMMENT '1管理员2编辑3普通会员',
  `isverify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经通过验证',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:正常0:禁止',
  `logincount` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '登录次数',
  PRIMARY KEY (`uid`,`username`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `usermail` (`usermail`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO user (`uid`, `username`, `password`, `usermail`, `userurl`, `logintime`, `loginip`, `logedtime`, `logedip`, `regip`, `regtime`, `group`, `isverify`, `status`, `logincount`) VALUES (1, 'admin', '786b2e2ab12b9806705117a21127e0ba', 'lms514168424@qq.com', 'http://www.linauror.com', '2013-04-22 18:05:27', '127.0.0.1', '2013-04-22 18:04:14', '127.0.0.1', '', '0000-00-00 00:00:00', 1, 1, 1, 16);
INSERT INTO user (`uid`, `username`, `password`, `usermail`, `userurl`, `logintime`, `loginip`, `logedtime`, `logedip`, `regip`, `regtime`, `group`, `isverify`, `status`, `logincount`) VALUES (3, 'test', 'dc28247369ba3eb0df9d34fdad6d677d', 'test@test.com', 'http://owncms.linauror.com', '2013-04-11 23:09:57', '127.0.0.1', '2013-04-11 23:09:15', '127.0.0.1', '', '0000-00-00 00:00:00', 2, 1, 1, 4);


#
# TABLE STRUCTURE FOR: userlog
#

DROP TABLE IF EXISTS userlog;

CREATE TABLE `userlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(2) unsigned NOT NULL,
  `msg` varchar(600) NOT NULL,
  `ip` char(19) NOT NULL,
  `time` datetime NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1：后台操作2：用户操作',
  PRIMARY KEY (`id`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='操作日志';


