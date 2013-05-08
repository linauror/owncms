  <?php $this->load->view('admin/header');?>
  <div id="content">
  <form action="<?php echo site_url('admin/user/alldel');?>" method="post">
      <table class="table fileslist">
        <thead>
          <tr>
            <th colspan="10"><a href="?">所有用户</a> 
            <select name="group" onchange="selectGoUrl(this, 'value')">
                <option value="">所有用户</option>
                <?php foreach($group as $key => $value){ ?>
                <option value="<?php echo $key;?>" <?php echo $this->input->get('group') == $key ? 'selected' : '';?>><?php echo $value;?></option>
                <?php } ?>
            </select>
            </th>
          </tr>
            <tr class="table_title">
                <td width="3%"><input type="checkbox" title="全选" /></td>
                <td>UID</td>
                <td>用户名</td>
                <td>用户邮箱</td>
                <td>最近登录时间</td>
                <td>最近登录IP</td>
                <td>用户组</td>
                <td>状态</td>
                <td>操作</td>
            </tr>
        </thead>
        <tbody>
         <?php
         if(count($users)){
            foreach($users as $line){
         ?>
        <tr>
            <td><input type="checkbox" name="id[]" class="checkbox" value="<?php echo $line['uid'];?>" /></td>
            <td><?php echo $line['uid']?></td>
            <td><a href="<?php echo site_url('admin/user/edit/'.$line['uid']);?>" title="编辑用户"><?php echo $line['username']?></a></td>
            <td><?php echo $line['usermail'];?></td>
            <td><?php echo $line['logintime'];?></td>
            <td><?php echo $line['loginip']?></td>
            <td><?php echo $group[$line['group']];?></td>
            <td><?php echo $line['isverify'] ? '[通过]' : '[验证中]'; echo $line['status'] ? ' [正常]' : ' [禁止]';?></td>
            <td><a href="<?php echo site_url('admin/user/edit/'.$line['uid']);?>" title="编辑用户">编辑</a> | <a href="<?php echo site_url('admin/user/del/'.$line['uid']);?>" title="删除用户">删除</a></td>
        </tr>
        <?php
            }
        }
        ?>
        </tbody>
          <tfoot>
            <tr>
              <td colspan="10"><input type="submit" value="删除所选" class="roundbtn"></td>
            </tr>
            <tr><td colspan="10" class="pages"><?php echo $pagination;?></td></tr>
          </tfoot>
        </table>
        </form>
        <table class="table">
        <thead>
          <tr>
            <th colspan="3">添加新用户</th>
          </tr>
        </thead>
        <tbody>
        <form action="<?php echo site_url('admin/user/save');?>" method="post">
        <tr>
          <td class="table_right"> 用户账号 ：</td>
          <td width="50%"><input type="text" name="username" value="" title="用户账号"  /></td>
          <td><span>* 6-20位字符，字母和数字组合</span></td>
        </tr>
        <tr>
          <td class="table_right"> 用户密码 ：</td>
          <td width="50%"><input type="password" name="password" value="" title="用户密码"  /></td>
          <td><span>* 6-20位字符，不修改留空即可</span></td>
        </tr>
        <tr>
          <td class="table_right"> 用户邮箱 ：</td>
          <td width="50%"><input type="text" name="usermail" value="" title="用户邮箱"  /></td>
          <td><span>*</span></td>
        </tr>
        <tr>
          <td class="table_right"> 用户网址 ：</td>
          <td width="50%"><input type="text" name="userurl" value="" title="用户网址"  /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 用户组 ：</td>
          <td width="50%">
            <select name="group">
                <?php foreach($group as $key => $value){ ?>
                <option value="<?php echo $key;?>"><?php echo $value;?></option>
                <?php } ?>
            </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="新增用户" class="roundbtn" /></td>
          <td></td>
        </tr>
        </form>
        </tbody>
      </table>
  </div>
  <?php $this->load->view('admin/footer');?>