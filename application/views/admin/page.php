  <?php $this->load->view('admin/header');?>
  <div id="content">
<form action="<?php echo site_url('admin/page/alldel');?>" method="post">
    <table class="table fileslist">
      <thead>
        <tr>
          <th colspan="9">单页文档 <a href="<?php echo site_url('admin/page/add');?>">新增单页文档</a></th>
        </tr>
      <tr class="table_title">
        <td width="3%"><input type="checkbox" title="全选" /></td>
        <td>文档标题</td>
        <td>缩略标题</td>
        <td>作者</td>
        <td>发布日期</td>
        <td>模板</td>
        <td>操作</td>
      </tr>
      </thead>
     <tbody>
     <?php
     if(count($page)){
        foreach($page as $line){
     ?>
        <tr>
          <td><input type="checkbox" name="id[]" class="checkbox" value="<?php echo $line['id'];?>"></td>
          <td><a href="<?php echo site_url('admin/page/edit/'.$line['id']);?>" title="编辑文档"><?php echo $line['title'];?></a> <?php echo $line['ishidden'] ? '<span class="red">[隐]</span>' : ''; ?></td>
          <td><?php echo $line['slug'];?></td>
          <td><?php echo $line['author'];?></td>
          <td><?php echo $line['posttime'];?></td>
          <td><?php echo $line['template'];?></td>
		  <td><a href="<?php echo site_url('admin/page/edit/'.$line['id']);?>" title="编辑文档">编辑</a> | <a href="<?php echo site_url('admin/page/del/'.$line['id']);?>" title="删除文档">删除</a> | <a href="<?php echo site_url('admin/page/view/'.$line['id']);?>" title="预览文档" target="_blank">预览</a></td>
        </tr>
    <?php
        }
    }
    ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="9"><input type="submit" value="删除所选" class="roundbtn" /></td>
        </tr>
      </tfoot>
    </table>
</form>
  </div>
<?php $this->load->view('admin/footer');?>