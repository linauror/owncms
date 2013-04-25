  <?php $this->load->view('admin/header');?>
    <script type="text/javascript" src="<?php echo base_url();?>static/xheditor/xheditor-1.1.14-zh-cn.min.js"></script>
    <script type="text/javascript">
    $(function(){
        $('#xheditor').xheditor({upImgUrl:"<?php echo site_url('admin/upload');?>",upImgExt:"jpg,jpeg,gif,png", html5Upload : false});
    })
    </script>
  <div id="content">
   <form action="<?php echo site_url('admin/page/save');?>" method="post">
    <table class="table">
      <thead>
        <tr>
          <th colspan="2">新增单页文档 <a href="<?php echo site_url('admin/page');?>"> [返回列表]</a></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table_right"> 文档标题：</td>
          <td><input type="text" name="title" value="" title="文档标题" />
            <span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 缩略标题：</td>
          <td><input type="text" name="slug" value="" title="缩略标题" />
            <span>缩略标题不得重复</span></td>
        </tr>
        <tr>
          <td class="table_right"> 文档内容：</td>
          <td><textarea name="content" id="xheditor" style="height: 300px;"></textarea>
            <span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 文档模板：</td>
          <td><select name="template">
            <?php foreach($this->Page_mdl->templates as $key => $value) { ?>
                <option value="<?php echo $key;?>" ><?php echo $value;?></option>
            <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td class="table_right"> 是否隐藏：</td>
          <td><select name="ishidden">
                <option value="0">否</option>
                <option value="1">是</option>
              </select>
          </td>
        </tr>
        <tr>
          <td class="table_right"> 发布时间：</td>
          <td><input type="text" name="posttime" value="<?php echo date('Y-m-d H:i:s');?>" title="如发布时间晚于当前时间，则自动成为即将发布" />
          </td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="新增文档" class="roundbtn" /></td>
        </tr>
      </tbody>
    </table>
   </form>
  </div>
<?php $this->load->view('admin/footer');?>