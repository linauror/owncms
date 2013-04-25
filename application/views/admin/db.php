  <?php $this->load->view('admin/header');?>
  <div id="content">
    <form action="<?php echo site_url('admin/db/alldel');?>" method="post">
        <table class="table fileslist" width="100%">
          <thead>
            <tr>
              <th colspan="5">数据库备份/还原 [备份目录：<?php echo $db_backup_path;?>] <a href="<?php echo getrefer();?>"> [返回]</a></th>
            </tr>
          <tr class="table_title">
            <td width="4%"><input type="checkbox" title="全选"></td>
            <td width="50%">文件名称</td>
            <td width="10%">文件大小</td>
            <td width="20%">备份时间</td>
            <td width="16%">操作</td>
          </tr>
          </thead>
         <tbody>
         <?php
         if($dbfiles){
            foreach($dbfiles as $line){   
         ?>
            <tr>
              <td><input type="checkbox" name="id[]" class="checkbox" value="<?php echo $line;?>"></td>
              <td><?php echo preg_replace("/[^0-9]/","",$line);?>.sql</td>
              <td><?php echo number_format(filesize($line)/1024,0)?>kb</td>
              <td><?php echo date('Y-m-d H:i:s',strtotime(preg_replace("/[^0-9]/","",$line)));?></td>
              <td><a href="<?php echo site_url('admin/db/down').'?db='.$line;?>">下载</a> | <a href="<?php echo site_url('admin/db/del').'?db='.$line;?>">删除</a> </td>
            </tr>
        <?php
            }
        }
        ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="6"><input type="submit" value="删除所选" class="roundbtn"> <a href="<?php echo site_url('admin/db/backup');?>">备份数据库</a></td>
            </tr>
          </tfoot>
        </table>
    </form>
  </div>
  <?php $this->load->view('admin/footer');?>