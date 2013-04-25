###################
关于OWNCMS
###################

OWNCMS基于CI的PHP开源框架。
目前适用于小型博客，内容型站点等。

#安装步骤
*解压程序文件至网站根目录下
*导入owncms.sql，修改·application/config/database.php·中的数据库地址、账号、密码、数据库名信息。
*默认重写的url，如服务器不支持URL重写，可修改·application/config/config.php中$config['index_page']·的值改为·index.php·，并删除根目录下·.htaccess·。
