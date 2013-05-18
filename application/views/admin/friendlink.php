  <?php $this->load->view('admin/header');?>
  <div id="content">
<form action="<?php echo site_url('admin/friendlink/alldel/');?>" method="post">
    <table class="table fileslist">
      <thead>
        <tr>
          <th colspan="9">友情链接 <a href="<?php echo site_url('admin/friendlink/add');?>">新增友情链接+</a></th>
        </tr>
      <tr class="table_title">
        <td width="3%"><input type="checkbox" title="全选" /></td>
        <td width="5%">链接ID</td>
        <td>链接标题</td>
        <td>链接描述</td>
        <td>链接LOGO</td>
        <td>链接地址</td>
        <td>操作</td>
      </tr>
      </thead>
     <tbody>
     <?php
     if(count($friendlink)){
        foreach($friendlink as $line){
     ?>
        <tr>
          <td><input type="checkbox" name="id[]" class="checkbox" value="<?php echo $line['id'];?>"></td>
          <td><?php echo $line['id'];?></td>
          <td><a href="<?php echo site_url('admin/friendlink/edit/'.$line['id']);?>" title="<?php echo $line['title']; ?>"><?php echo $line['title']; ?></a> <?php echo $line['ishidden'] ? '<span class="red">[隐]</span>' : ''; ?> </td>
          <td><?php echo $line['dec'];?></td>
          <td><?php echo $line['logo'] ? '<img src="'.$line['logo'].'" class="litpic" />' : '';?></td>
          <td><a href="<?php echo $line['url'];?>" target="_blank" title="新窗口打开"><?php echo $line['url'];?></a></td>
		  <td><a href="<?php echo site_url('admin/friendlink/edit/'.$line['id']);?>" title="编辑链接">编辑</a> | <a href="<?php echo site_url('admin/friendlink/del/'.$line['id']);?>" title="删除链接">删除</a> | 排序[<?php echo $line['sortrank'];?>]</td>
        </tr>
    <?php
        }
    }
    ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="9"><input type="submit" value="删除所选" class="roundbtn"></td>
        </tr>
      </tfoot>
    </table>
</form>
  </div>
<?php $this->load->view('admin/footer');?>