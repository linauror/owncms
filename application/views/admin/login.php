<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title>后台登录</title>
<link type="text/css" href="<?php echo base_url(); ?>static/admin/css/admin.css" rel="stylesheet" />
<style type="text/css">
.loginbox{ width:300px; position:absolute; left:50%; top:50%; margin-left:-170px; margin-top:-130px; padding:20px;}
.loginbox p{ line-height:30px; font-size:14px; margin-bottom:10px;}
.loginbox input{ width:200px;}
.loginbox .expired { line-height: 20px; font-size: 12px;}
.loginbox .expired input{ width: 14px; position: relative; margin-left: 50px; top: 5px;}
.loginbox .expired label{ cursor: pointer;}
.loginbox input.roundbtn{ margin-top:10px; width:50px; margin-left: 50px;}
</style>
</head>

<body>
<div id="container">
<form action="<?php echo site_url('admin/login/logining');?>" method="post" class="loginbox roundbox" name="loginbox">
	<h1><img src="<?php echo base_url(); ?>static/admin/images/admin_logo.png" alt="OWNCMS" title="OWNCMS" /></h1>
	<p><label for="username">用户名：</label><input type="text" name="username" /></p>
	<p><label for="password">密&nbsp;&nbsp;&nbsp;码：</label><input type="password" name="password" /></p>
    <input type="hidden" name="refer" value="<?php echo $refer;?>" />
	<p><input type="submit" value="登录" name="loginsubmit" class="roundbtn" /></p>
    <p class="expired" ><label>&nbsp;</label><input type="checkbox" value="2592000" name="expired" id="expired" /> <label for="expired">一个月免登陆？</label></p>
</form>
</div>
</body>
</html>