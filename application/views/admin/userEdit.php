  <?php $this->load->view('admin/header');?>
  <div id="content">
  <form action="<?php echo site_url('admin/user/save');?>" method="post">
  <input type="hidden" name="uid" value="<?php echo $user['uid'];?>" />
        <table class="table fileslist">
        <thead>
          <tr>
            <th colspan="3">更新用户 <a href="<?php echo site_url('admin/user');?>"> [返回列表]</a></th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td class="table_right"> 用户账号 ：</td>
          <td width="50%"><input type="text" name="username" value="<?php echo $user['username'];?>" title="用户账号"  /></td>
          <td><span>* 6-20位字符，字母和数字组合</span></td>
        </tr>
        <tr>
          <td class="table_right"> 用户密码 ：</td>
          <td width="50%"><input type="password" name="password" value="" title="用户密码"  /></td>
          <td><span>6-20位字符，不修改留空即可</span></td>
        </tr>
        <tr>
          <td class="table_right"> 用户邮箱 ：</td>
          <td width="50%"><input type="text" name="usermail" value="<?php echo $user['usermail'];?>" title="用户邮箱"  /></td>
          <td><span>*</span></td>
        </tr>
        <tr>
          <td class="table_right"> 用户网址 ：</td>
          <td width="50%"><input type="text" name="userurl" value="<?php echo $user['userurl'];?>" title="用户网址"  /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 用户组 ：</td>
          <td width="50%">
            <select name="group">
                <?php foreach($group as $key => $value){ ?>
                <option value="<?php echo $key;?>" <?php echo $user['group'] == $key ? 'selected' : '';?>><?php echo $value;?></option>
                <?php } ?>
            </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 是否通过验证 ：</td>
          <td width="50%">
            <select name="isverify">
                <option value="1">已通过</option>
                <option value="0" <?php echo $user['isverify'] ? '' : 'selected';?>>验证中</option>
            </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 状态 ：</td>
          <td width="50%">
            <select name="status">
                <option value="1">正常</option>
                <option value="0" <?php echo $user['status'] ? '' : 'selected';?>>禁止</option>
            </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="更新用户" class="roundbtn" /></td>
          <td></td>
        </tr>
        </tbody>
      </table>
      </form>
  </div>
  <?php $this->load->view('admin/footer');?>