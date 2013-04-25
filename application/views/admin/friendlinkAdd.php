  <?php $this->load->view('admin/header');?>
  <div id="content">
  <form action="<?php echo site_url('admin/friendlink/save');?>" method="post" >
    <table class="table">
      <thead>
        <tr>
          <th colspan="2">新增友情链接 <a href="<?php echo site_url('admin/friendlink');?>"> [返回列表]</a></th>
        </tr>
      </thead>
      <tbody>
            <tr>
              <td class="table_right"> 链接标题 ：</td>
              <td><input type="text" name="title" value="" title="链接标题" />
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 链接描述 ：</td>
              <td><input type="text" name="dec" value="" title="链接描述" />
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 网站logo ：</td>
              <td><input type="text" name="logo" />
                <span></span></td>
            </tr>
            <tr>
              <td class="table_right"> 链接地址 ：</td>
              <td><input type="text" name="url" />
                <span>不要忘了 http:// </span></td>
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
              <td class="table_right"> 链接排序 ：</td>
              <td><input type="text" name="sortrank" value="50" title="文档排序，数值越大越靠前" />
              </td>
            </tr>
            <tr>
              <td class="table_right"></td>
              <td><input type="submit" value="保存友情链接" class="roundbtn" /></td>
            </tr>
      </tbody>
    </table>
  </form>
  </div>
<?php $this->load->view('admin/footer');?>