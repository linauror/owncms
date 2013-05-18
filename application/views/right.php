<div class="right_con">
    <form action="<?php echo site_url('search');?>" class="search_right">
        <input type="text" name="q" class="search_right_q" value="" /> <input type="submit" value="搜索" class="search_right_submit" />
    </form>
    <div class="widget user_info"></div>
    <div class="widget">
    <h3>热门文章</h3>
        <ul>
        <?php foreach ($post_hot['list'] as $line) {?>
            <li><a href="<?php echo site_url($line['channeltype'].'/'.$line['id'].'/'.$line['slug']);?>" title="<?php echo $line['title'];?>"><?php echo $line['title'];?></a> <?php echo $line['click'];?>℃</li>
        <?php } ?>
        </ul>
    </div>
    <div class="widget">
    <h3>最新评论</h3>
        <ul>
        <?php foreach ($comments_new['list'] as $line) {?>
            <li><a href="<?php echo site_url($line['channeltype'].'/'.$line['pid'].'/'.$line['slug']);?>#comments_id_<?php echo $line['id'];?>" title="评论给《<?php echo $line['title'];?>》"><?php echo $line['content'];?></a></li>
        <?php } ?>
        </ul>
    </div>
    <div class="widget">
    <h3>友情链接</h3>
        <ul>
        <?php foreach ($friendlink['list'] as $line) {?>
            <li><a href="<?php echo $line['url']?>" title="<?php echo $line['dec'];?>" target="_blank"><?php echo $line['title'];?></a></li>
        <?php } ?>
        </ul>
    </div>
    <div class="widget">
    <h3>功能</h3>
        <ul>
            <li class="login"><a href="<?php echo site_url('login');?>" title="登录后台">登录</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('login/register');?>" title="没有账号？请注册">注册</a></li>
        </ul>
    </div>
</div>