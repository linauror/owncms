<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title>后台管理</title>
<link type="text/css" href="<?php echo base_url();?>public/admin/css/admin.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>public/admin/Scripts/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/admin/Scripts/admin.js" ></script>
</head>
<body id="adminPage">
<div id="container">
  <?php $this->load->view('admin/header');?>
  <div id="content">
        <table class="table">
        <thead>
          <tr>
            <th colspan="3">编辑管理员 <a href="<?php echo site_url('admin/admin');?>"> [返回列表]</a></th>
          </tr>
        </thead>
        <tbody>
        <form action="<?php echo site_url('admin/admin/save');?>" method="post">
        <input type="hidden" name="uid" value="<?php echo $admin['uid'];?>"/>
        <tr>
          <td class="table_right"> 管理员账号 ：</td>
          <td width="50%"><?php echo $admin['username'];?></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 新密码 ：</td>
          <td width="50%"><input type="password" name="password" value="" title="新密码"  /></td>
          <td><span>不修改留空即可</span></td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="保存" class="roundbtn" /></td>
          <td></td>
        </tr>
        </form>
        </tbody>
      </table>
  </div>
</div>
</body>
</html>