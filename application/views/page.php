<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page['title'] .' - '. $siteconfig['sitename'];?></title>
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
    <div class="post_list">
        <h1 class="post_title"><?php echo $page['title'];?></h1>
        <div class="post_content"><?php echo $page['content'];?></div>
        <?php echo $page['uid'] == $this->User_mdl->uid ? '<a href="'.site_url('admin/page/edit/'.$page['id']).'" class="edit_link">编辑</a>' : ''?>
    </div>
    </div>
    <?php $this->load->view('right');?>
</div>
<?php $this->load->view('footer');?>
</div>
<script type="text/javascript">
$('.search_right_q').val('<?php echo $q;?>');
</script>
</body>
</html>