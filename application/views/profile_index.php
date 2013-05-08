<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo '个人中心 - '. $siteconfig['sitename'];?></title>
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
    <div class="archive_header user_info">
    <div class="avatar" ><a href="<?php echo site_url('profile');?>"><img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower($user['usermail']))?>?s=44" /></a><br /><a href="http://www.iplaysoft.com/gravatar.html" target="_blank" title="更换头像">更换头像</a></div>
    <div class="other">
        <p>账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：<strong><?php echo $user['username'];?></strong>&nbsp;&nbsp;&nbsp;<a href="#update" title="更新个人资料">更新资料</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('login/loginout');?>" title="退出登录">登出</a></p>
        <p>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱：<?php echo $user['usermail'];?> <?php echo !$user['isverify'] ? '<a href="javascript:;" onclick="resend_verifymail(\''.$user['usermail'].'\');" title="邮件尚未激活,未收到激活邮件?点击重新发送验证邮件">未激活</a>' : '';?></p>
        <?php echo $user['userurl'] ? '<p>网&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：<a href="'.$user['userurl'].'" target="_blank">'.$user['userurl'].'</a></p>' : '';?>
        <p>用&nbsp;&nbsp;户&nbsp;&nbsp;组：<?php echo $this->User_mdl->group[$user['group']].($user['group'] == 1 ? '&nbsp;&nbsp;&nbsp;<a href="'.site_url('admin').'">后台管理</a>' : '');?></p>
        <p>加入时间：<?php echo $user['regtime'];?></p>
        <p>上次登录：<?php echo $user['logedtime'].' ['.$user['logedip'];?>]</p>
    </div>
    </div>
    <?php if ($user['group'] <= 2) {?>
    <dl>
        <h3><strong>我的作品</strong></h3>
        <dt>发表了<a href="<?php echo site_url('author/'.$user['username']);?>"><?php echo $post_list['total'];?></a>个作品&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('admin/post/add');?>">+发表新作品</a></dt>
    </dl>
    <?}?>
    <div class="form" id="update">
        <h3>更新资料</h3>
        <form method="post" action="<?php echo site_url('profile/update');?>" onsubmit="return checkupdate_form();">
            <p>邮箱 <span class="required">*</span></p>
            <p><input type="text" name="usermail" class="usermail" value="<?php echo $user['usermail'];?>" /> 绑定邮箱，可用来登录</p>
            <p>网址 </p>
            <p><input type="text" name="userurl" class="userurl" value="<?php echo $user['userurl'];?>" /></p>
            <p>密码 </p>
            <p><input type="password" name="password" class="password" value="" /> 6-20位数字字母组合，不修改留空即可</p>
            <p><input type="submit" value="更新" class="comment_submit" /></p>
        </form>
        <script type="text/javascript">
        function checkupdate_form() {
            var Regex_password = /^[\w]{6,20}$/;
            var Regex_usermail = /^[\w]+@[a-zA-Z0-9]+.+[a-zA-Z]$/;
            var Regex_userurl = /^[http|https].*[.].*$/
            var password = $('.form .password').val();
            var usermail = $('.form .usermail').val();
            var userurl = $('.form .userurl').val();
            if (password.length > 0 && Regex_password.test(password) === false) {
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
        function resend_verifymail(usermail) {
            $.post('<?php echo site_url('login/resend_verifymail');?>', function(data) {
                if (data == 'success') {
                    alert('已重新发送验证邮件至['+usermail+']，请查收！')
                } else {
                    alert(data);
                }
            })
        }
        </script>
    </div>
    </div>
    <?php $this->load->view('right');?>
</div>
<?php $this->load->view('footer');?>
<script type="text/javascript">
$('.right_con .user_info').remove();
</script>
</div>
</body>
</html>