<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo '重置密码 - '. $siteconfig['sitename'];?></title>
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
        <div class="form">
            <h3>重置密码</h3>
            <form method="post" action="<?php echo site_url('login/getpassword');?>" onsubmit="return checkgetpassword_form();">
                <?php foreach($data as $key => $value) {?>
                <input type="hidden" name="<?php echo $key?>" value="<?php echo $value;?>" />
                <?php } ?>
                <p>密码 <span class="required">*</span></p>
                <p><input type="password" name="password" class="password" value="" /> 6-20位数字字母组合</p>
                <p>确认密码 <span class="required">*</span></p>
                <p><input type="password" name="passwordagain" class="passwordagain" value="" /> 确认密码</p>
                <p><input type="submit" value="修改密码" class="comment_submit" /></p>
            </form>
            <script type="text/javascript">
            function checkgetpassword_form() {
                var Regex_password = /^[\w]{4,20}$/;
                var password = $('.form .password').val();
                var passwordagain = $('.form .passwordagain').val();
                if (password != passwordagain) {
                    alert('确认密码不一致！');
                    $('.form .passwordagain').focus();
                    return false;                    
                } else if (Regex_password.test(password) === false) {
                    alert('密码必须为6-20位数字字母组合！');
                    $('.form .password').focus();
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