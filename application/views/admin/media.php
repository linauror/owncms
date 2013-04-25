  <?php $this->load->view('admin/header');?>
  <style type="text/css">
  .table img{ max-height: 100px; max-width: 100px;}
  </style>
  <div id="content">
<form action="<?php echo site_url('admin/media/alldel');?>" method="post">
    <table class="table fileslist">
      <thead>
        <tr>
          <th colspan="11"><a href="?">所有媒体</a>   
          </th>
        </tr>
      <tr class="table_title">
        <td width="3%"><input type="checkbox" title="全选" /></td>
        <td width="5%">媒体ID</td>
        <td>标题</td>
        <td>说明</td>
        <td>上传者</td>
        <td>后缀</td>
        <td></td>
        <td>操作</td>
      </tr>
      </thead>
     <tbody>
     <?php
     if(count($media)){
        foreach($media as $line){
     ?>
        <tr>
          <td><input type="checkbox" name="id[]" class="checkbox" value="<?php echo $line['id'];?>" /></td>
          <td><?php echo $line['id'];?></td>
          <td><?php echo $line['title'];?></td>
          <td><?php echo $line['des'];?></td>
          <td><a href="?uid=<?php echo $line['uid'];?>"><?php echo $line['username']?></a></td>
          <td><a href="?suffix=<?php echo $line['suffix'];?>"><?php echo $line['suffix']?></a></td>
          <td><a href="<?php echo $line['filepath'];?>" target="_blank"><?php echo in_array($line['suffix'], $pic_types) ? '<img src="'.$line['filepath'].'" />' : '查看'?></a></td>
		  <td><a href="<?php echo site_url('admin/media/edit/'.$line['id']);?>" title="编辑媒体">编辑</a> | <a href="<?php echo site_url('admin/media/del/'.$line['id']);?>" title="删除媒体">删除</a></td>
        </tr>
    <?php
        }
    }
    ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="11"><input type="submit" value="删除所选" class="roundbtn" />
          <input type="text" class="litpic" value="增加媒体请选择文件..." /> <input type="file" name="ajaxFileUploadInput" id="ajaxFileUploadInput" onchange="return ajaxFileUpload('<?php echo site_url('admin/upload');?>', 'ajaxFileUploadInput', 'litpic');" /> <a href="#" target="_blank" class="preview_link" title="点击新窗口打开图片">[预览]</a>
          </td>
        </tr>
        <tr><td colspan="11" class="pages"><?php echo $pagination;?></td></tr>
      </tfoot>
    </table>
</form>
  </div>
  <?php $this->load->view('admin/footer');?>