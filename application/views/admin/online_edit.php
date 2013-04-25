  <?php $this->load->view('admin/header');?>
  <div id="content">
    <form action="<?php echo site_url('admin/online_edit/save');?>" method="post">
        <input type="hidden" name="path" value="<?php echo $this->input->get('path');?>" />
        <table class="table fileslist" width="100%">
          <thead>
            <tr>
              <th colspan="5">文件在线编辑 <a href="<?php echo site_url('admin/online_edit?path='.$prev_path);?>">返回上一层</a></th>
            </tr>
          </thead>
          <tbody>
          <?php 
          if ($type == 'dir') {
                foreach ($thefile as $line) {
          ?>
            <tr><td><a href="<?php echo site_url('admin/online_edit?path='.$line);?>"><?php echo str_replace('\\', '/', $line);?></td></a><td><?php echo substr(sprintf('%o', fileperms($line)), -4);?></td><td><?php echo number_format(filesize($line)/1024, 2);?>KB</td></tr>
          <?php }} else {?>
          <tr><td><textarea style="height: 400px;" name="content"><?php echo $thefile;?></textarea></td></tr>
          <?php }?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="6"><input type="submit" value="保存文件" class="roundbtn" /></td>
            </tr>
          </tfoot>
        </table>
    </form>
  </div>
  <?php $this->load->view('admin/footer');?>