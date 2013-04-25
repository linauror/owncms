<?php $this->load->view('admin/header');?>
  <div id="content">
        <table class="table">
        <thead>
          <tr>
            <th colspan="3">更新分类目录 <a href="<?php echo site_url('admin/category');?>"> [返回列表]</a></th>
          </tr>
        </thead>
        <tbody>
        <form action="<?php echo site_url('admin/category/save');?>" method="post">
        <input type="hidden" name="id" value="<?php echo $category['id'];?>" />
        <tr>
          <td class="table_right"> 栏目名称 ：</td>
          <td width="50%"><input type="text" name="typename" value="<?php echo $category['typename'];?>" title="栏目名称"  /></td>
          <td><a href="<?php echo site_url('admin/category/view/'.$category['id']);?>" target="_blank">[预览]</a><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 栏目别名 ：</td>
          <td width="50%"><input type="text" name="slug" value="<?php echo $category['slug'];?>" title="栏目别名"  /></td>
          <td><span>“别名”是在 URL 中使用的别称，它可以令 URL 更美观</span></td>
        </tr>
        <tr>
          <td class="table_right"> 所属栏目 ：</td>
          <td><select name="reid">
                <option value="0">顶级栏目</option>
                <?php rec_show($categorys, '<option value="{id}"{selected}>{separator}{typename}</option>', 0, '', $category['reid'], $category['id']);?>
              </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr> 
          <td class="table_right"> 频道模型 ：</td>
          <td><select name="channeltype">
            <?php foreach($this->Category_mdl->channeltype as $key => $value) { ?>
                <option value="<?php echo $key;?>" <?php echo $category['channeltype'] == $key ? 'selected' : '';?>><?php echo $value;?></option>
            <?php } ?>
              </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 封面/列表模板 ：</td>
          <td><select name="tempindex">
            <?php foreach($this->Category_mdl->tempindex as $key => $value) { ?>
                <option value="<?php echo $key;?>" <?php echo $category['tempindex'] == $key ? 'selected' : '';?>><?php echo $value;?></option>
            <?php } ?>
              </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 文章模板 ：</td>
          <td><select name="temparticle">
            <?php foreach($this->Category_mdl->temparticle as $key => $value) { ?>
                <option value="<?php echo $key;?>" <?php echo $category['temparticle'] == $key ? 'selected' : '';?>><?php echo $value;?></option>
            <?php } ?>
              </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="保存" class="roundbtn" /></td>
          <td></td>
        </tr>
        </form>
        </tbody>
      </table>
  </div>
  <?php $this->load->view('admin/footer');?>