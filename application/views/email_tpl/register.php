<p><?php echo $username;?> 您好！</p>
<p>欢迎注册本网站，请点击以下链接(或者复制到您的浏览器)进行注册激活:</p>
<p><a href="<?php echo $url;?>" target="_blank"><?php echo $url;?></a></p>
<p>此链接10分钟内有效，激活后邮箱将作为取回密码的重要依据！</p>
<br />
<p><a href="<?php echo base_url();?>" target="_blank"><?php echo $this->Siteconfig_mdl->get('value', 'short_sitename');?></a></p>
<p><?php echo date('Y-m-d H:i:s');?></p>
