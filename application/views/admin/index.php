  <?php $this->load->view('admin/header');?>
  <div id="content">
    <table class="table">
      <thead>
        <tr>
          <th colspan="4">系统信息概览</th>
        </tr>
      </thead>
      <tbody>
      <tr><td width="10%">系统环境</td><td width="50%"><?php echo $_SERVER['SERVER_SOFTWARE'].' Mysql/'.mysql_get_server_info(); ?></td><td width="10%">网站路径</td><td width="30%"><?php echo getcwd();?></td></tr>
      <tr><td>文件上传</td><td>最大<?php echo str_replace('M','',ini_get('upload_max_filesize')) > str_replace('M','',ini_get('post_max_size')) ? ini_get('post_max_size') : ini_get('upload_max_filesize');?></td><td>磁盘空余</td><td><?php echo number_format(disk_free_space(getcwd())/1024/1024/1024,2);?>GB</td></tr>
      </tbody>
    </table>
    <p>&nbsp;</p>
    <table class="table">
      <thead>
        <tr>
          <th colspan="4">其他操作</th>
        </tr>
      </thead>
      <tbody>
        <tr><td><a href="<?php echo site_url('admin/user/userlog?type=1');?>">用户日志</a></td><td><a href="<?php echo site_url('admin/db');?>">数据库备份/还原</a></td><td><a href="<?php echo site_url('admin/watermark');?>">图片水印设置</a></td><td><a href="<?php echo site_url('admin/online_edit');?>">文件在线编辑</a></td> </tr>
      </tbody>
    </table>    
  </div>
</div>
</body>
</html>