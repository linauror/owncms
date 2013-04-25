<?php $this->load->view('admin/header');?>
  <div id="content">
      <table class="table">
        <thead>
          <tr>
            <th colspan="5">分类目录</th>
          </tr>
        </thead>
        <tbody>
        <tr class="table_title"><td>栏目名称</td><td>栏目别名</td><td>频道模型/封面(列表)模板/文章模板</td><td>文章数</td><td>操作</td></tr>
        <?php echo rec_show($category, '<tr><td><a href="category/edit/{id}.html">{separator}{typename}<a/></td><td>{slug}</td><td>{channeltype} / {tempindex} / {temparticle}</td><td><a href="post.html?category={slug}">{postcount}</a></td><td><a href="category/edit/{id}.html">编辑</a> | <a href="category/del/{id}.html">删除</a> | <a href="category/view/{id}.html" target="_blank">预览</a></td></tr>');?>
        </tbody>
        </table>
        <table class="table">
        <thead>
          <tr>
            <th colspan="3">添加新栏目</th>
          </tr>
        </thead>
        <tbody>
        <form action="<?php echo site_url('admin/category/save');?>" method="post">
        <tr>
          <td class="table_right"> 栏目名称 ：</td>
          <td width="50%"><input type="text" name="typename" value="" title="栏目名称"  /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 栏目别名 ：</td>
          <td width="50%"><input type="text" name="slug" value="" title="栏目别名"  /></td>
          <td><span>“别名”是在 URL 中使用的别称，它可以令 URL 更美观</span></td>
        </tr>
        <tr>
          <td class="table_right"> 所属栏目 ：</td>
          <td><select name="reid">
                <option value="0">顶级栏目</option>
                <?php echo rec_show($category);?>
              </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr> 
          <td class="table_right"> 频道模型 ：</td>
          <td><select name="channeltype">
            <?php foreach($this->Category_mdl->channeltype as $key => $value) { ?>
                <option value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php } ?>
              </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 封面/列表模板 ：</td>
          <td><select name="tempindex">
            <?php foreach($this->Category_mdl->tempindex as $key => $value) { ?>
                <option value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php } ?>
              </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td class="table_right"> 文章模板 ：</td>
          <td><select name="temparticle">
            <?php foreach($this->Category_mdl->temparticle as $key => $value) { ?>
                <option value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php } ?>
              </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="添加新分类目录" class="roundbtn" /></td>
          <td></td>
        </tr>
        </form>
        </tbody>
      </table>
  </div>
<?php $this->load->view('admin/footer');?>