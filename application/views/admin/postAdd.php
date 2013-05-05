  <?php $this->load->view('admin/header');?>
<script type="text/javascript" src="<?php echo base_url();?>static/xheditor/xheditor-1.1.14-zh-cn.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#xheditor').xheditor({upImgUrl:"<?php echo site_url('admin/upload');?>",upImgExt:"jpg,jpeg,gif,png", html5Upload : false});
})
</script>
  <div id="content">
  <form action="<?php echo site_url('admin/post/save');?>" method="post" enctype="multipart/form-data">
    <table class="table">
      <thead>
        <tr>
          <th colspan="2">新增文章 <a href="<?php echo site_url('admin/post');?>"> [返回列表]</a></th>
        </tr>
      </thead>
      <tbody>
            <tr>
              <td class="table_right"> 文章标题 ：</td>
              <td><input type="text" name="title" value="" title="文章标题" />
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 缩略标题：</td>
              <td><input type="text" name="slug" value="" title="缩略标题" />
                <span>缩略标题有利于搜索的友好URL，字母与-组合</span></td>
            </tr>
            <tr>
              <td class="table_right"> 所属栏目 ：</td>
              <td>
              <select name="category">
                <?php rec_show($categorys, '<option value="{id}"{selected}>{separator}{typename}</option>', 0, '', $category);?>
              </select>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章模板 ：</td>
              <td>
              <select name="template">
                <?php foreach($this->Post_mdl->templates as $key => $value) { ?>
                    <option value="<?php echo $key;?>" <?php echo $default_template == $key ? 'selected' : '';?>><?php echo $value;?></option>
                <?php } ?>                
              </select>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章属性 ：</td>
              <td><?php echo showflag();?>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 略缩图 ：</td>
              <td><input type="text" name="litpic" class="litpic" /> <input type="file" name="ajaxFileUploadInput" id="ajaxFileUploadInput" onchange="return ajaxFileUpload('<?php echo site_url('admin/upload');?>', 'ajaxFileUploadInput', 'litpic');" /> <a href="#" target="_blank" class="preview_link" title="点击新窗口打开图片">[预览]</a>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章内容 ：</td>
              <td ><textarea name="content" id="xheditor" style="height: 300px;"></textarea>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章关键词 ：</td>
              <td><input type="text" name="keyword" />
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章描述 ：</td>
              <td><textarea name="description" style="height: 50px;"></textarea>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 标签 ：</td>
              <td><input type="text" name="tag" />
                <span>多个标签之间用逗号(,)或者空格隔开</span></td>
            </tr>
            <tr>
              <td class="table_right"> 是否隐藏 ：</td>
              <td><select name="ishidden">
                    <option value="0">否</option>
                    <option value="1">是</option>
                  </select>
              </td>
            </tr>
            <tr>
              <td class="table_right"> 是否允许评论 ：</td>
              <td><select name="comment_status">
                    <option value="1">是</option>
                    <option value="0">否</option>
                  </select>
              </td>
            </tr>
            <tr>
              <td class="table_right"> 点击次数 ：</td>
              <td><input type="text" name="click" value="50" title="点击次数"  />
              </td>
            </tr>
            <tr>
              <td class="table_right"> 文章来源 ：</td>
              <td><input type="text" name="source" value="本站" title="文章来源" />
              </td>
            </tr>
            <tr>
              <td class="table_right"> 文章排序 ：</td>
              <td><input type="text" name="sortrank" value="50" title="文章排序，数值越大越靠前" />
              </td>
            </tr>
            <tr>
              <td class="table_right"> 发布时间 ：</td>
              <td><input type="text" name="posttime" value="<?php echo date('Y-m-d H:i:s');?>" title="发布时间" />
              </td>
            </tr>
            <tr>
              <td class="table_right"></td>
              <td><input type="submit" value="保存文章" class="roundbtn"></td>
            </tr>
      </tbody>
    </table>
  </form>
  </div>
  <?php $this->load->view('admin/footer');?>