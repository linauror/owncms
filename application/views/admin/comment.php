  <?php $this->load->view('admin/header');?>
  <div id="content">
<form action="<?php echo site_url('admin/comment/alldel');?>" method="post">
    <table class="table fileslist">
      <thead>
        <tr>
          <th colspan="11"><a href="?">所有评论</a>
          </th>
        </tr>
      <tr class="table_title">
        <td width="3%"><input type="checkbox" title="全选" /></td>
        <td width="50"></td>
        <td>作者</td>
        <td>评论</td>
        <td>回应给</td>
        <td>操作</td>
      </tr>
      </thead>
     <tbody>
     <?php
     if(count($comment)){
        foreach($comment as $line){
     ?>
        <tr>
          <td><input type="checkbox" name="id[]" class="checkbox" value="<?php echo $line['id'];?>" /></td>
          <td><img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower($line['usermail']));?>?s=40" /></td>
          <td><?php echo $line['username']?>[<?php echo $line['uid'] ? '<a href="?username='.$line['username'].'">'.$line['username'].'</a>' : '未注册';?>]<br /><a href="<?php echo $line['userurl']?>" target="_blank"><?php echo $line['userurl']?></a></td>
          <td>提交于 <?php echo $line['posttime'];?><br /><?php echo $line['content'];?></td>
          <td><a href="?pid=<?php echo $line['pid'];?>"><?php echo $line['title'];?></a></td>
		  <td><a href="<?php echo site_url('admin/comment/del/'.$line['id']);?>" title="删除评论">删除</a> | <a href="<?php echo site_url('admin/post/view/'.$line['pid']);?>" target="_blank" title="查看文章">查看文章</a> | <a href="<?php echo site_url('admin/comment/edit/'.$line['id'].'?ishidden='.$line['ishidden']);?>">设为[<?php echo $line['ishidden'] ? '显示' : '隐藏' ?>]</a> | <a href="<?php echo site_url('admin/comment/edit/'.$line['id'].'?ispass='.$line['ispass']);?>">设为[<?php echo $line['ispass'] ? '通过' : '审核' ?>]</a></td>
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