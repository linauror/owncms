  <?php $this->load->view('admin/header');?>
<script type="text/javascript" src="<?php echo base_url();?>static/xheditor/xheditor-1.1.14-zh-cn.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#xheditor').xheditor({upImgUrl:"<?php echo site_url('admin/upload');?>",upImgExt:"jpg,jpeg,gif,png", html5Upload : false});
})
</script>
  <div id="content">
  <form action="<?php echo site_url('admin/post/save');?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo $post['id'];?>" />
    <table class="table">
      <thead>
        <tr>
          <th colspan="2">更新文章 <a href="<?php echo site_url('admin/post');?>"> [返回列表]</a></th>
        </tr>
      </thead>
      <tbody>
            <tr>
              <td class="table_right"> 文章标题 ：</td>
              <td><input type="text" name="title" value="<?php echo $post['title']?>" title="文章标题" />
                <span><a href="<?php echo site_url('admin/post/view/'.$post['id']);?>" target="_blank">[预览]</a></span></td>
            </tr>
            <tr>
              <td class="table_right"> 缩略标题：</td>
              <td><input type="text" name="slug" value="<?php echo $post['slug']?>" title="缩略标题" />
                <span>缩略标题有利于搜索的友好URL，字母与-组合</span></td>
            </tr>
            <tr>
              <td class="table_right"> 所属栏目 ：</td>
              <td>
              <select name="category">
                <?php rec_show($categorys, '<option value="{id}"{selected}>{separator}{typename}</option>', 0, '', $post['category']);?>
              </select>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章模板 ：</td>
              <td>
              <select name="template">
                <?php foreach($this->Post_mdl->templates as $key => $value) { ?>
                    <option value="<?php echo $key;?>" <?php echo $post['template'] == $key ? 'selected' : '';?>><?php echo $value;?></option>
                <?php } ?>                
              </select>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章属性 ：</td>
              <td><?php echo showflag('checkbox', $post['flag']);?>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 略缩图 ：</td>
              <td><input type="text" name="litpic" class="litpic" value="<?php echo $post['litpic']?>" /> <input type="file" name="ajaxFileUploadInput" id="ajaxFileUploadInput" onchange="return ajaxFileUpload('<?php echo site_url('admin/upload');?>', 'ajaxFileUploadInput', 'litpic');" /> <a href="<?php echo $post['litpic']?>" target="_blank" class="preview_link" title="点击新窗口打开图片">[预览]</a>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章内容 ：</td>
              <td ><textarea name="content" id="xheditor" style="height: 300px;"><?php echo $post['content']?></textarea>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章关键词 ：</td>
              <td><input type="text" name="keyword" value="<?php echo $post['keyword']?>" />
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 文章描述 ：</td>
              <td><textarea name="description" style="height: 50px;"><?php echo $post['description']?></textarea>
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 标签 ：</td>
              <td><input type="text" name="tag" value="<?php echo $post['tag'] ? showtag($post['tag'], $this->Post_mdl->get_taglist_by_tagids($post['tag']), '%s', ',') : '';?>" />
                <span>多个标签之间用逗号(,)隔开</span></td>
            </tr>
            <tr>
              <td class="table_right"> 是否隐藏 ：</td>
              <td><select name="ishidden">
                    <option value="0">否</option>
                    <option value="1" <?php echo $post['ishidden'] ? 'checked' : '';?>>是</option>
                  </select>
              </td>
            </tr>
            <tr>
              <td class="table_right"> 是否允许评论 ：</td>
              <td><select name="comment_status">
                    <option value="1">是</option>
                    <option value="0" <?php echo !$post['comment_status'] ? 'checked' : '';?>>否</option>
                  </select>
              </td>
            </tr>
            <tr>
              <td class="table_right"> 点击次数 ：</td>
              <td><input type="text" name="click" value="<?php echo $post['click'];?>" title="点击次数"  />
              </td>
            </tr>
            <tr>
              <td class="table_right"> 文章来源 ：</td>
              <td><input type="text" name="source" value="<?php echo $post['source'];?>" title="文章来源" />
              </td>
            </tr>
            <tr>
              <td class="table_right"> 文章排序 ：</td>
              <td><input type="text" name="sortrank" value="<?php echo $post['sortrank'];?>" title="文章排序，数值越大越靠前" />
              </td>
            </tr>
            <tr>
              <td class="table_right"> 发布时间 ：</td>
              <td><input type="text" name="posttime" value="<?php echo $post['posttime'];?>" title="发布时间" />
              </td>
            </tr>
            <tr>
              <td class="table_right"></td>
              <td><input type="submit" value="保存文章" class="roundbtn" /></td>
            </tr>
      </tbody>
    </table>
  </form>
  </div>
  <?php $this->load->view('admin/footer');?>