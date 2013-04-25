<?php $this->load->view('admin/header');?>
<style type="text/css">
img{ max-height: 500px; max-width: 500px;}
</style>
  <div id="content">
        <table class="table">
        <thead>
          <tr>
            <th colspan="3">更新媒体 <a href="<?php echo site_url('admin/media');?>"> [返回列表]</a></th>
          </tr>
        </thead>
        <tbody>
        <form action="<?php echo site_url('admin/media/save');?>" method="post">
        <input type="hidden" name="id" value="<?php echo $media['id'];?>" />
        <tr>
          <td class="table_right"> 标题 ：</td>
          <td><input type="text" name="title" value="<?php echo $media['title'];?>" title="标题"  /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 说明 ：</td>
          <td><textarea name="des" title="说明"><?php echo $media['des'];?></textarea></td>
          <td><span></span></td>
        </tr>
        <tr> 
          <td class="table_right"> 上传者 ：</td>
          <td><?php echo $this->User_mdl->get('username', $media['uid']);?></td>
          <td><span></span></td>
        </tr>
        <tr> 
          <td class="table_right"> 后缀 ：</td>
          <td><?php echo $media['suffix'];?></td>
          <td><span></span></td>
        </tr>
        <tr> 
          <td class="table_right"> 文件路径 ：</td>
          <td><?php echo $media['filepath'].' ['.(strstr($media['filepath'], base_url()) ? '本地文件' : '远程文件').']';?></td>
          <td><span></span></td>
        </tr>
        <tr> 
          <td class="table_right"> 查看 ：</td>
          <td><a href="<?php echo $media['filepath']?>" target="_blank"><?php echo in_array($media['suffix'], $pic_types) ? '<img src="'.$media['filepath'].'" />' : '新页面查看'?></a></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="保存" class="roundbtn" /></td>
          <td></td>
        </tr>
        </form>
        </tbody>
      </table>
  </div>
  <?php $this->load->view('admin/footer');?>