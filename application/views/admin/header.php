<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title><?php echo $this->Siteconfig_mdl->get('value', 'sitename');?> 后台管理</title>
<link type="text/css" href="<?php echo base_url();?>static/admin/css/admin.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>static/admin/Scripts/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>static/admin/Scripts/admin.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>static/admin/Scripts/ajaxfileupload.js" ></script>
</head>
<body>
<div id="container">  
  <div id="header">
    <h1><a href="<?php echo site_url('admin');?>"><img src="<?php echo base_url();?>static/admin/images/admin_logo.png"  alt="OWNCMS 精简版" title="OWNCMS 精简版" /></a></h1>
    <div class="welcome">欢迎你，<strong><?php echo $this->User_mdl->username;?></strong> <a href="<?php echo site_url();?>" target="_blank">前台首页</a> <a href="<?php echo site_url('admin/login/loginout');?>">注销登录</a> <a href="<?php echo site_url('admin/index/clean_cache')?>">清空缓存</a></div>
    <form action="<?php echo site_url('admin/post');?>" method="get" class="top_search">
      <input type="text" name="title" placeholder="请输入关键字 -.-" />
      <input type="submit" value="搜索" class="roundbtn" />
    </form>
    <div class="aboutowncms">
      <div class="aboutowncms_text">
        <p>Powered by <a href="javascript:;">OWNCMS</a></p>
        <p>版本：Ver 1.0</p>
        <p>开发者：Auror（514168424）</p>
      </div>
    </div>
    <ul>
      <li><a href="<?php echo site_url('admin/siteconfig')?>" class="siteconfigPage">网站设置</a></li>
      <li><a href="<?php echo site_url('admin/menu')?>" class="menuPage">菜单设置</a></li>
      <li><a href="<?php echo site_url('admin/category')?>" class="categoryPage">分类目录</a></li>
      <li><a href="<?php echo site_url('admin/page')?>" class="pagePage">单页文档</a></li>
      <li><a href="<?php echo site_url('admin/post')?>" class="postPage">文章管理</a></li>
      <li><a href="<?php echo site_url('admin/media')?>" class="mediaPage">媒体库</a></li>
      <li><a href="<?php echo site_url('admin/comment')?>" class="commentPage">评论管理</a></li>
      <li><a href="<?php echo site_url('admin/friendlink')?>" class="friendlinkPage">友情链接</a></li>
      <li><a href="<?php echo site_url('admin/user')?>" class="userPage">用户管理</a></li>
    </ul>
  </div>
  <div id="result"><?php echo $this->input->cookie('admintip');?></div>