#关于OWNCMS#

OWNCMS文件结构和主要代码完全基于CI，后台模板属于本人很久之前写的，前台演示模板来源于wordpress默认模板。

目前的功能能满足于博客，内容性站点等的搭建。

本程序遵循BSD协议！

官网：http://owncms.linauror.com/

安装步骤：

1，解压程序文件到网站根目录

2，导入owncms.sql，修改application/config/database.php中的数据库地址、账号、密码、数据库名信息。

3，默认重写的url，如服务器不支持URL重写，可修改application/config/config.php中$config['index_page']的值改为index.php，并删除根目录下.htaccess。
