  <?php $this->load->view('admin/header');?>
  <div id="content">
<form action="<?php echo site_url('admin/post/alldel');?>" method="post">
    <table class="table fileslist">
      <thead>
        <tr>
          <th colspan="11"><a href="?">所有文章</a> <a href="<?php echo site_url('admin/post/add?category='.$this->input->get('category'));?>">新增文章+</a>&nbsp;&nbsp;&nbsp;  
          <select name="category" onchange="selectGoUrl(this, 'value');">
            <option value="0" value="">查看所有分类目录</option>
            <?php rec_show($categorys, '<option value="{slug}"{selected}>{separator}{typename}</option>', 0, '', $category);?>
          </select>
          共 <strong><?php echo $post['total']?></strong> 项
          </th>
        </tr>
      <tr class="table_title">
        <td width="3%"><input type="checkbox" title="全选" /></td>
        <td width="5%">文章ID</td>
        <td>文章标题</td>
        <td>属性</td>
        <td>分类目录</td>
        <td>标签</td>
        <td>作者</td>
        <td>发布时间</td>
        <td>评论</td>
        <td>点击</td>
        <td>操作</td>
      </tr>
      </thead>
     <tbody>
     <?php
     if($post['total']){
        foreach($post['list'] as $line){
     ?>
        <tr>
          <td><input type="checkbox" name="id[]" class="checkbox" value="<?php echo $line['id'];?>" /></td>
          <td><?php echo $line['id'];?></td>
          <td><a href="<?php echo site_url('admin/post/edit/'.$line['id']);?>" title="<?php echo $line['title']; ?>"><?php echo $line['title']; ?></a> <?php echo $line['ishidden'] ? '<span class="red">[隐]</span>' : ''; ?></td>
          <td><?php echo showflag('html',$line['flag']);?></td>
          <td><?php getParCategory($categorys, $line['category'], '<a tid="%u" href="?category=%s">%s<a/> &gt; ') ?></td>
          <td><?php echo showtag($line['tag'], $tags, '<a href="?tag=%s">%s</a>');?></td>
          <td><a href="?uid=<?php echo $line['uid'];?>"><?php echo $line['username'];?></a></td>
          <td><?php echo $line['posttime'];?></td>
          <td><a href="<?php echo site_url('admin/comment?postid='.$line['id']);?>"><?php echo $line['comment_count'];?></a></td>
          <td><?php echo $line['click'];?></td>
		  <td><a href="<?php echo site_url('admin/post/edit/'.$line['id']);?>" title="编辑文章">编辑</a> | <a href="<?php echo site_url('admin/post/del/'.$line['id']);?>" title="删除文章">删除</a> | <a href="<?php echo site_url('admin/post/view/'.$line['id']);?>" target="_blank" title="预览文章">预览</a> | 排序[<?php echo $line['sortrank'];?>]</td>
        </tr>
    <?php
        }
    }
    ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="11"><input type="submit" value="删除所选" class="roundbtn" /></td>
        </tr>
        <tr><td colspan="11" class="pages"><?php echo $pagination;?></td></tr>
      </tfoot>
    </table>
</form>
  </div>
  <?php $this->load->view('admin/footer');?>