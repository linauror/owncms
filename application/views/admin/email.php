  <?php $this->load->view('admin/header')?>
  <div id="content">
  <form action="<?php echo site_url('admin/email/save')?>" method="post" >
  <input type="hidden" name="mailtype" value="html" />
    <table class="table">
        <thead>
          <tr>
            <th colspan="3">邮件配置 <a href="<?php echo getrefer();?>"> [返回]</a></th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td class="table_right"> 邮件发送协议：</td>
          <td width="50%"><input type="text" name="protocol" value="<?php echo $config['protocol'];?>" /></td>
          <td><span>mail, sendmail, 或者 smtp</span></td>
        </tr>
        <tr>
          <td class="table_right"> Sendmail路径：</td>
          <td width="50%"><input type="text" name="mailpath" value="<?php echo $config['mailpath'];?>"/></td>
          <td><span>服务器上 Sendmail 的实际路径(协议为sendmail)</span></td>
        </tr>
        <tr>
          <td class="table_right"> SMTP 服务器地址：</td>
          <td width="50%"><input type="text" name="smtp_host" value="<?php echo $config['smtp_host'];?>"/></td>
          <td><span>(协议为smtp)</span></td>
        </tr>  
        <tr>
          <td class="table_right"> SMTP 用户账号：</td>
          <td width="50%"><input type="text" name="smtp_user" value="<?php echo $config['smtp_user'];?>"/></td>
          <td><span>(协议为smtp)</span></td>
        </tr> 
        <tr>
          <td class="table_right"> SMTP 密码：</td>
          <td width="50%"><input type="password" name="smtp_pass" value="<?php echo $config['smtp_pass'];?>"/></td>
          <td><span>(协议为smtp)</span></td>
        </tr> 
        <tr>
          <td class="table_right"> SMTP 端口：</td>
          <td width="50%"><input type="text" name="smtp_port" value="<?php echo $config['smtp_port'];?>"/></td>
          <td><span>默认值25 (协议为smtp)</span></td>
        </tr>      
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="保存" class="roundbtn" /></td>
          <td></td>
        </tr>
        <tr>
          <td class="table_right"> 测试发送邮件地址：</td>
          <td width="50%"><input type="text" class="testmailto" value=""/></td>
          <td><span>(协议为smtp)</span></td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="button" value="测试发送，请先保存！" class="roundbtn" onclick="return gotest();" /></td>
          <td></td>
        </tr> 
        </tbody>
      </table>
  </form>
  </div>
  <script type="text/javascript">
  function gotest() {
    var testmailto = $('.testmailto').val();
    if (testmailto == '') {
        alert('测试发送邮件地址不能为空！');
        return false;
    }
    $.post('<?php echo site_url('admin/email/test')?>', {testmailto : testmailto}, function(data) {
        if (data == 'success') {
            alert('发送成功，请前往'+testmailto+'查收！');
        } else {
            alert('发送失败，请检查配置！'+data);
        }
    })
  }
  </script>
  <?php $this->load->view('admin/footer')?>