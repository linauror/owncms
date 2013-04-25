<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo '登录 - '. $siteconfig['sitename'];?></title>
<meta name="description" content="<?php echo $siteconfig['keyword'];?>" />
<meta name="keywords" content="<?php echo $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/style.css" />
<script type="text/javascript" src="<?php echo base_url();?>static/js/jquery.js"></script>
</head>

<body>
<div id="wrap">
<?php $this->load->view('header');?>
<div id="content">
    <div class="left_con">
        <div class="form login">
            <h3>登录</h3>
            <form method="post" action="<?php echo site_url('login/logining');?>" onsubmit="return checklogin_form();">
                <input type="hidden" name="refer" value="<?php echo $refer;?>" />
                <p>账号/邮箱 <span class="required">*</span></p>
                <p><input type="text" name="username" class="username" value="" /></p>
                <p>密码 <span class="required">*</span></p>
                <p><input type="text" name="password" class="password" value="" /></p>
                <p><input type="submit" value="登录" class="comment_submit" /><input type="checkbox" value="2592000" name="expired" id="expired" /> <label for="expired">保持登录</label></p>
            </form>
            <script type="text/javascript">
            function checklogin_form() {
                if ($('#respond .username').val().length < 1) {
                    alert('姓名不能为空，请填写！');
                    $('#respond .username').focus();
                    return false;
                } else if ($('#respond .usermail').val().length < 6) {
                    alert('电子邮件不能为空，请填写！');
                    $('#respond .usermail').focus();
                    return false;                    
                } else if ($('#respond .content').val().length < 1) {
                    alert('评论内容不能为空，请填写！');
                    $('#respond .content').focus();
                    return false;                      
                }
            }
            </script>
        </div>
    </div>
    <?php $this->load->view('right');?>
</div>
<?php $this->load->view('footer');?>
</div>
</body>
</html>