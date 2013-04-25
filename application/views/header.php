<div id="header">
	<h1 class="sitename"><a href="<?php echo base_url();?>" title="<?php echo $siteconfig['sitename'];?>"><?php echo $siteconfig['sitename'];?></a></h1>
    <?php echo $this->Menu_mdl->show_menu_nav(0, $current_nav, 'nav_main');?>
</div>