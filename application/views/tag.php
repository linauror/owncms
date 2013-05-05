<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo urldecode($tag) .' - '. $siteconfig['sitename'];?></title>
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
    <h1 class="archive_header">标签归档：<?php echo urldecode($tag);?></h1>
    <?php foreach ($post_list as $line) {?>
        <div class="post_list">
            <h1 class="post_title"><a href="<?php echo site_url($line['channeltype'].'/'.$line['id'].'/'.$line['slug']);?>" title="<?php echo $line['title'];?>"><?php echo $line['title'];?></a></h1>
            <?php if ($line['comment_status']) { 
                echo $line['comment_count'] ? '<a class="comments_link" href="'.site_url($line['channeltype'].'/'.$line['id'].'/'.$line['slug']).'#comments_list" title="《'.$line['title'].'》上的评论">'.$line['comment_count'].'条评论</a>' : '<a class="comments_link" href="'.site_url(get_from_array($categorys, 'id', $line['category'], 'channeltype').'/'.$line['slug']).'#respond" title="《'.$line['title'].'》上的评论">发表评论</a>'; 
            }?>
            <div class="post_content"><?php echo $line['content'];?></div>
            <div class="post_meta">本文章发布于 <a href="<?php echo site_url($line['channeltype'].'/'.$line['id'].'/'.$line['slug']);?>"><?php echo $line['posttime']?></a>。
            属于 <?php echo getParCategory($categorys, $line['category'], '<a category_id="%u" href="'.site_url('category/%s').'">%s</a>', ' 、 ');?> 分类。
            <?php echo $line['uid'] == $this->User_mdl->uid ? '<a href="'.site_url('admin/post/edit/'.$line['id']).'">编辑</a>' : ''?>
            </div>
        </div>
    <?php } ?>
    <div class="pagination"><?php echo $pagination;?></div>
    </div>
    <?php $this->load->view('right');?>
</div>
<?php $this->load->view('footer');?>
</div>
</body>
</html>