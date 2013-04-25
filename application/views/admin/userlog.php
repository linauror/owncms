  <?php $this->load->view('admin/header');?>
  <div id="content">
  <form action="<?php echo site_url('admin/user/userlog_alldel');?>" method="post">
      <table class="table fileslist">
        <thead>
          <tr>
            <th colspan="10"><a href="?">所有日志</a> 
            <select name="type" onchange="selectGoUrl(this, 'value')">
                <option value="">所有日志</option>
                <?php foreach($types as $key => $value){ ?>
                <option value="<?php echo $key;?>" <?php echo $this->input->get('type') == $key ? 'selected' : '';?>><?php echo $value;?></option>
                <?php } ?>
            </select>
            </th>
          </tr>
            <tr class="table_title">
                <td width="3%"><input type="checkbox" title="全选" /></td>
                <td>用户</td>
                <td>信息</td>
                <td>IP</td>
                <td>时间</td>
                <td>操作</td>
            </tr>
        </thead>
        <tbody>
         <?php
         if(count($userlog)){
            foreach($userlog as $line){
         ?>
        <tr>
            <td><input type="checkbox" name="id[]" class="checkbox" value="<?php echo $line['id'];?>" /></td>
            <td><a href="?uid=<?php echo $line['uid'];?>"><?php echo $line['username'];?></a></td>
            <td><?php echo $line['msg'];?></td>
            <td><?php echo $line['ip']?></td>
            <td><?php echo $line['time'];?></td>
            <td><a href="<?php echo site_url('admin/user/userlog_del/'.$line['id']);?>" title="删除日志">删除</a></td>
        </tr>
        <?php
            }
        }
        ?>
        </tbody>
          <tfoot>
            <tr>
              <td colspan="10"><input type="submit" value="删除所选" class="roundbtn" /></td>
            </tr>
            <tr><td colspan="10" class="pages"><?php echo $pagination;?></td></tr>
          </tfoot>
        </table>
        </form>
  </div>
  <?php $this->load->view('admin/footer');?>