<p><?php echo $username;?> 您好！</p>
<p>您已经进行了密码重置的操作，请点击以下链接(或者复制到您的浏览器):</p>
<p><a href="<?php echo $url;?>" target="_blank"><?php echo $url;?></a></p>
<p>此链接10分钟内有效，如不是您本人操作，请忽视此邮件！</p>
<br />
<p><a href="<?php echo base_url();?>" target="_blank"><?php echo $this->Siteconfig_mdl->get('value', 'short_sitename');?></a></p>
<p><?php echo date('Y-m-d H:i:s');?></p>
