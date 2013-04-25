<?php $this->load->view('admin/header');?>
  <div id="content">
      <table class="table">
        <thead>
          <tr>
            <th colspan="5">添加新菜单</th>
          </tr>
        </thead>
        <tbody>
        <tr><td width="30%">
        <form action="<?php echo site_url('admin/menu/save');?>" method="post">
        <input type="hidden" name="type" value="page" />
            <table class="table">
                <tbody>
                    <tr class="table_title"><td colspan="2">单页文档</td></tr>
                    <tr><td width="30%">页面：</td><td>
                    <select name="url">
                        <?php if (count($pages)) {
                                    foreach ($pages as $line) {    
                        ?>
                        <option value="<?php echo $line['slug'];?>"><?php echo $line['title'];?></option>
                        <?php }}?>
                    </select></td></tr>
                    <tr><td>上级菜单：</td><td><select name="reid"><option value="0">顶级菜单</option><?php rec_show($menus, '<option value="{id}"{selected}>{separator}{nav}</option>');?></select></td></tr>
                    <tr><td>打开方式：</td><td><select name="target"><?php foreach ($targets as $key => $value) {?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php }?></select></td></tr>
                    <tr><td>排序：</td><td><input type="text" name="sortrank" placeholder ="排序" style=" width:30%" /></td></tr>
                    <tr><td></td><td><input type="submit" value="添加至菜单" class="roundbtn" /></td></tr>
                </tbody>
            </table>
        </form>
        <form action="<?php echo site_url('admin/menu/save');?>" method="post">
        <input type="hidden" name="type" value="jump" />
            <table class="table">
                <tbody>
                    <tr class="table_title"><td colspan="2">自定义链接</td></tr>
                    <tr><td width="30%">URL：</td><td><input type="text" name="url" value="http://" /><span>支持uri模式</span></td></tr>
                    <tr><td>菜单名称：</td><td><input type="text" name="nav" /></td></tr>
                    <tr><td>上级菜单：</td><td><select name="reid"><option value="0">顶级菜单</option><?php rec_show($menus, '<option value="{id}"{selected}>{separator}{nav}</option>');?></select></td></tr>
                    <tr><td>打开方式：</td><td><select name="target"><?php foreach ($targets as $key => $value) {?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php }?></select></td></tr>
                    <tr><td>排序：</td><td><input type="text" name="sortrank" placeholder ="排序" style=" width:30%" /></td></tr>
                    <tr><td></td><td><input type="submit" value="添加至菜单" class="roundbtn" /></td></tr>
                </tbody>
            </table>
        </form>
        <form action="<?php echo site_url('admin/menu/save');?>" method="post">
        <input type="hidden" name="type" value="category" />
            <table class="table">
                <tbody>
                    <tr class="table_title"><td colspan="2">分类目录</td></tr>
                    <tr><td width="30%">分类：</td><td>
                    <select name="url">
                    <?php rec_show($categorys, '<option value = "{slug}">{separator}{typename}</option>');?>
                    </select></td></tr>
                    <tr><td>上级菜单：</td><td><select name="reid"><option value="0">顶级菜单</option><?php rec_show($menus, '<option value="{id}"{selected}>{separator}{nav}</option>');?></select></td></tr>
                    <tr><td>打开方式：</td><td><select name="target"><?php foreach ($targets as $key => $value) {?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php }?></select></td></tr>
                    <tr><td>排序：</td><td><input type="text" name="sortrank" placeholder ="排序" style=" width:30%" /></td></tr>
                    <tr><td></td><td><input type="submit" value="添加至菜单" class="roundbtn" /></td></tr>
                </tbody>
            </table>
        </form>
        </td>
        <td style="vertical-align: top;">
        <table class="table">
        <tbody>
        <tr class="table_header"><td>菜单</td><td>类型</td><td>链接</td><td>打开方式</td><td>操作</td></tr>
        <?php rec_show($menus, '<tr><td><a href="'.site_url('admin/menu/edit/{id}').'">{separator}{nav}</a></td><td>{type}</td><td>{url}</td><td>{target}</td><td><a href="'.site_url('admin/menu/edit/{id}').'">编辑</a> | <a href="'.site_url('admin/menu/del/{id}').'">删除</a> | <a href="'.site_url('admin/menu/view/{id}').'" target="_blank">预览</a>[{sortrank}]</td></tr>');?>
        </tbody>
        </table>
        </td></tr>        
        </tbody>
        </table>
  </div>
<?php $this->load->view('admin/footer');?>