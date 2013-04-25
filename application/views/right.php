<div class="right_con">
    <form action="<?php echo site_url('search');?>" class="search_right">
        <input type="text" name="q" class="search_right_q" value="" /> <input type="submit" value="搜索" class="search_right_submit" />
    </form>
    <?php if ($this->User_mdl->uid) {?>
    <div class="widget user_info">
    <h3>欢迎登录</h3>
    <img class="avatar" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower($user_info['usermail']))?>?s=44" title="<?php echo $user_info['username'];?>" />
    <p><strong><?php echo $user_info['username'];?></strong></p>
    <p><a href="<?php echo site_url('author/'.$user_info['username'])?>" title="我的作品">我的作品</a>&nbsp;&nbsp;&nbsp;<?php echo $user_info['userurl'] ? '<a href="'.$user_info['userurl'].'" target="_blank">我的网站</a>' : '';?> </p>
    <p>上次登录：<?php echo $user_info['logedtime']?></p>
    <p><a href="<?php echo site_url('admin/login/loginout?refer='.current_url());?>" title="退出登录">登出</a>&nbsp;&nbsp;&nbsp;<?php echo $user_info['group'] == 1 ? '<a href="'.site_url('admin').'" title="后台管理">后台管理</a>' : '';?></p>
    </div>
    <?php } ?>
    <div class="widget">
    <h3>热门文章</h3>
        <ul>
        <?php foreach ($post_hot['list'] as $line) {?>
            <li><a href="<?php echo site_url($line['channeltype'].'/'.$line['slug']);?>" title="<?php echo $line['title'];?>"><?php echo $line['title'];?></a> <?php echo $line['click'];?>℃</li>
        <?php } ?>
        </ul>
    </div>
    <div class="widget">
    <h3>最新评论</h3>
        <ul>
        <?php foreach ($comments_new['list'] as $line) {?>
            <li><a href="<?php echo site_url($line['channeltype'].'/'.$line['slug']);?>#comments_id_<?php echo $line['id'];?>" title="评论给《<?php echo $line['title'];?>》"><?php echo $line['content'];?></a></li>
        <?php } ?>
        </ul>
    </div>
    <div class="widget">
    <h3>友情链接</h3>
        <ul>
        <?php foreach ($friendlink as $line) {?>
            <li><a href="<?php echo $line['url']?>" title="<?php echo $line['dec'];?>" target="_blank"><?php echo $line['title'];?></a></li>
        <?php } ?>
        </ul>
    </div>
    <div class="widget">
    <h3>功能</h3>
        <ul>
            <?php echo $this->User_mdl->uid ? '<li><a href="'.site_url('admin/login/loginout?refer='.current_url()).'" title="退出登录">登出</a></li>' : '<a href="'.site_url('admin/login').'" title="登录后台">登录</a>' ?>
        </ul>
    </div>
</div>