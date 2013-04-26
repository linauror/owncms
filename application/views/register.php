<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo '注册 - '. $siteconfig['sitename'];?></title>
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
            <h3>注册</h3>
            <form method="post" action="<?php echo site_url('login/register');?>" onsubmit="return checkregister_form();">
                <p>账号 <span class="required">*</span></p>
                <p><input type="text" name="username" class="username" value="" /> 4-20位数字字母组合</p>
                <p>密码 <span class="required">*</span></p>
                <p><input type="password" name="password" class="password" value="" /> 6-20位数字字母组合</p>
                <p>确认密码 <span class="required">*</span></p>
                <p><input type="password" name="passwordagain" class="passwordagain" value="" /> 确认密码</p>
                <p>邮箱 <span class="required">*</span></p>
                <p><input type="text" name="usermail" class="usermail" value="" /> 账号绑定邮箱，可用来登录</p>
                <p>网址 </p>
                <p><input type="text" name="userurl" class="userurl" value="" /></p>
                <p><input type="submit" value="注册" class="comment_submit" /></p>
            </form>
            <script type="text/javascript">
            function checkregister_form() {
                var Regex_username = /^[\w]{4,20}$/;
                var Regex_usermail = /^[\w]+@[a-zA-Z0-9]+.+[a-zA-Z]$/;
                var Regex_userurl = /^[http|https].*[.].*$/
                var username = $('.form .username').val();
                var password = $('.form .password').val();
                var passwordagain = $('.form .passwordagain').val();
                var usermail = $('.form .usermail').val();
                var userurl = $('.form .userurl').val();
                if (Regex_username.test(username) === false) {
                    alert('账号必须为4-20位数字字母组合！');
                    $('.form .username').focus();
                    return false;
                } else if (password != passwordagain) {
                    alert('确认密码不一致！');
                    $('.form .passwordagain').focus();
                    return false;                    
                } else if (Regex_username.test(password) === false) {
                    alert('密码必须为6-20位数字字母组合！');
                    $('.form .password').focus();
                    return false;                   
                } else if (Regex_usermail.test(usermail) === false) {
                    alert('邮箱格式不正确！');
                    $('.form .usermail').focus();
                    return false;                        
                } else if (userurl.length > 0 && Regex_userurl.test(userurl) === false) {
                    alert('网址格式不正确！');
                    $('.form .userurl').focus();
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