  <?php $this->load->view('admin/header');?>
  <div id="content">
  <form action="<?php echo site_url('admin/friendlink/save');?>" method="post" >
  <input type="hidden" name="id" value="<?php echo $friendlink['id'];?>" />
    <table class="table">
      <thead>
        <tr>
          <th colspan="2">编辑友情链接  <a href="<?php echo site_url('admin/friendlink');?>"> [返回列表]</a></th>
        </tr>
      </thead>
      <tbody>
            <tr>
              <td class="table_right"> 链接标题 ：</td>
              <td><input type="text" name="title" value="<?php echo $friendlink['title'];?>" title="链接标题" />
                <span><a href="<?php echo $friendlink['url'];?>" target="_blank">[预览]</a></span></td>
            </tr>
            <tr>
              <td class="table_right"> 链接描述 ：</td>
              <td><input type="text" name="dec" value="<?php echo $friendlink['dec'];?>" title="链接描述" />
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 网站logo ：</td>
              <td><input type="text" name="logo" value="<?php echo $friendlink['logo']?>" /> 
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 链接地址 ：</td>
              <td><input type="text" name="url" value="<?php echo $friendlink['url'];?>" />
                <span>不要忘了 http://</span></td>
            </tr> 
            <tr>
              <td class="table_right"> 是否隐藏 ：</td>
              <td><select name="ishidden">
                    <option value="0">否</option>
                    <option value="1" <?php echo $friendlink['ishidden'] ? 'selected' : '';?>>是</option>
                  </select>
              </td>
            </tr>
            <tr>
              <td class="table_right"> 链接排序 ：</td>
              <td><input type="text" name="sortrank" value="<?php echo $friendlink['sortrank'];?>" title="链接排序，数值越大越靠前" />
              </td>
            </tr>
            <tr>
              <td class="table_right"></td>
              <td><input type="submit" value="保存链接" class="roundbtn" /></td>
            </tr>
      </tbody>
    </table>
  </form>
  </div>
<?php $this->load->view('admin/footer');?>