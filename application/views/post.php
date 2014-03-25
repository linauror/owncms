<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $post['title'] .' - '. $siteconfig['sitename'];?></title>
<meta name="description" content="<?php echo $post['keyword'] ? $post['keyword'] : $siteconfig['keyword'];?>" />
<meta name="keywords" content="<?php echo $post['description'] ? $post['description'] : $siteconfig['description'];?>" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/style.css" />
<script type="text/javascript" src="<?php echo base_url();?>static/js/jquery.js"></script>
</head>

<body>
<div id="wrap">
<?php $this->load->view('header');?>
<div id="content">
    <div class="left_con">
        <div class="post_list">
            <h1 class="post_title"><?php echo $post['title'];?></h1>
            <?php if ($post['comment_status']) {?><a class="comments_link" href="#respond" title="发表评论">发表评论</a><?php }?>
            <div class="post_content"><?php echo $post['content'];?></div>
            <div class="post_meta">本文章发布于 <a href="<?php echo site_url(get_from_array($categorys, 'id', $post['category'], 'channeltype').'/'.$post['id'].'/'.$post['slug']);?>"><?php echo $post['posttime']?></a>。
            属于 <?php echo getParCategory($categorys, $post['category'], '<a category_id="%u" href="'.site_url('category/%s').'">%s</a>', ' 、 ');?> 分类。
            <?php echo $post['tag'] ? '被贴了'.showtag($post['tag'], $thetag, '<a href="'.site_url('tag/%s').'">%s</a>', ' 、 ').'标签。' : '';?>
            </div>
        </div>
        <div class="post_near">
        <?php echo $near_post['prev'] ? '<a href="'.site_url(get_from_array($categorys, 'id', $near_post['prev']['category'], 'channeltype').'/'.$near_post['prev']['id'].'/'.$near_post['prev']['slug']).'" class="prev_link" title = "上一篇《'.$near_post['prev']['title'].'》"> ← '.$near_post['prev']['title'].'</a>': '';?>
        <?php echo $near_post['next'] ? '<a href="'.site_url(get_from_array($categorys, 'id', $near_post['next']['category'], 'channeltype').'/'.$near_post['next']['id'].'/'.$near_post['next']['slug']).'" class="next_link" title = "下一篇《'.$near_post['next']['title'].'》">'.$near_post['next']['title'].' → </a>': '';?>
        </div>
        <?php if ($post['comment_count']) {?>
        <div class="comments_list" id="comments_list">
            <h3 class="comments_list_title">《<?php echo $post['title'];?>》上有 <?php echo $post['comment_count'];?> 条评论</h3>
            <?php echo show_comments_list($comments_list['list'], 0, $post['uid'])?>
        </div>
        <?php }?>
        <?php if($post['comment_status']) {?>
        <div id="respond" class="form">
            <h3>发表评论</h3>
            <form method="post" action="<?php echo site_url('post/ACT_comment_submit');?>" onsubmit="return check_comment_submit();">
                <input type="hidden" name="current_url" value="<?php echo current_url();?>" />
                <input type="hidden" name="pid" value="<?php echo $post['id'];?>" />
                <input type="hidden" name="reid" value="0" class="reid" />
                <div>
                <p>电子邮件地址不会被公开。 必填项已用 <span class="required">*</span> 标注</p>
                <p>姓名 <span class="required">*</span></p>
                <p><input type="text" name="username" class="username" value="<?=$this->input->cookie('temp_username')?>" /></p>
                <p>电子邮件 <span class="required">*</span></p>
                <p><input type="text" name="usermail" class="usermail" value="<?=$this->input->cookie('temp_usermail')?>" /></p>
                <p>站点</p>
                <p><input type="text" name="userurl" value="<?=$this->input->cookie('temp_userurl')?>" /></p>
                </div>
                <p>评论 <span class="required">*</span></p>
                <p><textarea name="content" cols="10" rows="10" class="content"></textarea></p>
                <p><label><input type="checkbox" name="tipme" checked="<?=$this->input->cookie('temp_tipme') ? 'true' : 'false'?>" value="1" /> 有回复通知我</label></p>
                <p><input type="button" value="我不是机器人啦" title="点击证明你不是机器人" class="notRobotBtn" /> <input type="hidden" class="notRobot" name="notRobot" value="" time="" /> <input type="submit" value="发表评论" class="comment_submit" /></p>
            </form>
            <script type="text/javascript">
            //已经登录
            $(function(){
                var timestamp = parseInt(Date.parse(new Date())) / 1000; 
                $('#respond .notRobot').attr('time', timestamp);
                $.post(base_url+'uapi/checklogin', function(data){
                    if (data) {
                        logged = '';
                        data = eval('(' + data + ')');
                        logged += '<p class="logged">以 '+ data.username +' 的身份登录。<a href="'+base_url+'login/loginout?refer='+current_url+'" title="登出此账户">登出？</a></p>';
                        $('#respond .reid').after(logged);
                        $('#respond .username').val(data.username);
                        $('#respond .usermail').val(data.usermail);
                        $('#respond .userurl').val(data.userurl);
                        $('#respond .logged').next('div').hide();
                        $('#respond .notRobot').val($('#respond .notRobot').attr('time'));
                        $('#respond .notRobotBtn').hide();
                    }
                })                 
            })
            
            //我不是机器人啦
            $('#respond .notRobotBtn').click(function(){
                $(this).val('OK!').fadeOut();
                setTimeout(function(){
                    $('#respond .notRobot').val($('#respond .notRobot').attr('time'));
                }, 200);
            })
            
            //检查提交表单
            function check_comment_submit() {
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
                } else if ($('.notRobot').val().length < 10) {
                    alert('请确定你不是机器人，请点击《我不是机器人啦》！');
                    $('#respond .notRobot').focus();
                    return false;                        
                }
            }
            
            //回复表单
            function go_reply(reid) {
                $('#respond .reid').val(reid);
            }
            
            //更新浏览量
            $.post('<?php echo site_url(get_from_array($categorys, 'id', $post['category'], 'channeltype').'/ACT_update_click')?>', {id : '<?php echo $post['id'];?>'});
            
            $(function(){
                $.get('<?php echo site_url(get_from_array($categorys, 'id', $post['category'], 'channeltype').'/ACT_show_edit_link?id='.$post['id'].'&uid='.$post['uid']);?>', function(data) {
                    data = eval('(' + data + ')');
                    if (data.status == 'yes') {
                        $('.post_meta').append('<a href="'+data.url+'" target="_blank">编辑</a>');
                    }
                })                
            })
            </script>
        </div>
        <?php } ?>
    </div>
    <?php $this->load->view('right');?>
</div>
<?php $this->load->view('footer');?>
</div>
</body>
</html>