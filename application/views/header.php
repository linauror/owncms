<div id="header">
	<h1 class="sitename"><a href="<?php echo base_url();?>" title="<?php echo $siteconfig['sitename'];?>"><?php echo $siteconfig['sitename'];?></a></h1>
    <?php echo show_menu_nav($this->Menu_mdl->get_list(), 0, $current_nav, 'nav_main');?>
</div>