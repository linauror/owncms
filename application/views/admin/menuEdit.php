<?php $this->load->view('admin/header');?>
  <div id="content">
        <table class="table">
        <thead>
          <tr>
            <th colspan="3">更新菜单 <a href="<?php echo site_url('admin/menu');?>"> [返回列表]</a></th>
          </tr>
        </thead>
        <tbody>
        <form action="<?php echo site_url('admin/menu/save');?>" method="post">
        <input type="hidden" name="id" value="<?php echo $menu['id'];?>" />
        <tr>
          <td class="table_right"> 菜单名称 ：</td>
          <td width="50%"><input type="text" name="nav" value="<?php echo $menu['nav'];?>" title="菜单名称"  /></td>
          <td><a href="<?php echo site_url('admin/menu/view/'.$menu['id']);?>" target="_blank">[预览]</a> <span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 菜单类型 ：</td>
          <td width="50%"> <?php $types = $types; echo $this->Menu_mdl->types[$menu['type']]?>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 菜单链接 ：</td>
          <td><input type="text" name="url" value="<?php echo $menu['url'];?>" title="菜单链接"  /></td>
          <td><span></span></td>
        </tr>
        <tr> 
          <td class="table_right"> 上级菜单 ：</td>
          <td><select name="reid"><option value="0">顶级菜单</option><?php echo rec_show($menus, '<option value="{id}"{selected}>{separator}{nav}</option>', 0, '', $menu['reid'], $menu['id']);?></select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 打开方式 ：</td>
          <td><select name="target">
            <?php foreach ($targets as $key => $value) {?><option value="<?php echo $key;?>" <?php echo $key==$menu['target'] ? 'selected' : '';?> ><?php echo $value;?></option><?php }?>
              </select>
          </td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 排序 ：</td>
          <td><input type="text" name="sortrank" value="<?php echo $menu['sortrank'];?>" title="排序"  /></td>
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