  <?php $this->load->view('admin/header')?>
  <div id="content">
  <form action="<?php echo site_url('admin/watermark/save')?>" method="post" >
    <table class="table">
        <thead>
          <tr>
            <th colspan="3">图片水印配置 <a href="<?php echo getrefer();?>"> [返回]</a></th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td class="table_right"> 是否开启水印：</td>
          <td width="50%"><select name="wm_ing"><option value="0" >关闭</option><option value="1" <?php echo $config['wm_ing'] == 1 ? 'selected' : '';?>>开启</option></select></td>
          <td><span><a href="<?php echo site_url('admin/watermark/test')?>" target="_blank" title="查看效果">查看效果</a></span></td>
        </tr>
        <tr>
          <td class="table_right"> 水印类型 ：</td>
          <td width="50%"><select name="wm_type"><option value="text">文字水印</option><option value="overlay" <?php echo $config['wm_type'] == 'overlay' ? 'selected' : '';?>>图片水印</option></select></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 图片质量 ：</td>
          <td width="50%"><input type="text" name="quality" value="<?php echo $config['quality']?>" title="图片质量" /></td>
          <td><span>1-100 设置图片的质量。数字越大，质量越高, 文件就越大。</span></td>
        </tr>
        <tr>
          <td class="table_right"> 距图片边缘距离 ：</td>
          <td width="50%"><input type="text" name="padding" value="<?php echo $config['padding']?>" title="距图片边缘距离" /></td>
          <td><span>px</span></td>
        </tr>
        <tr>
          <td class="table_right"> 设置水印图像的对齐方式 ：</td>
          <td width="50%">垂直方向：<select name="wm_vrt_alignment"><option value="top">上</option><option value="middle" <?php echo $config['wm_vrt_alignment'] == 'middle' ? 'selected' : '';?>>中</option><option value="bottom" <?php echo $config['wm_vrt_alignment'] == 'bottom' ? 'selected' : '';?>>下</option></select> 水平方向：<select name="wm_hor_alignment"><option value="left">左</option><option value="center" <?php echo $config['wm_hor_alignment'] == 'center' ? 'selected' : '';?>>中</option><option value="right" <?php echo $config['wm_hor_alignment'] == 'right' ? 'selected' : '';?>>右</option></select></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 水平偏移量 ：</td>
          <td width="50%"><input type="text" name="wm_hor_offset" value="<?php echo $config['wm_hor_offset']?>" title="水平偏移量" /></td>
          <td><span>px</span></td>
        </tr>
        <tr>
          <td class="table_right"> 垂直偏移量 ：</td>
          <td width="50%"><input type="text" name="wm_vrt_offset" value="<?php echo $config['wm_vrt_offset']?>" title="垂直偏移量" /></td>
          <td><span>px</span></td>
        </tr>
        <tr>
          <td class="table_right"> 测试图片路径 ：</td>
          <td width="50%"><input type="text" name="source_image" value="<?php echo $config['source_image']?>" title="测试图片路径" /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> [文字水印]文本 ：</td>
          <td width="50%"><input type="text" name="wm_text" value="<?php echo $config['wm_text']?>" title="文本" /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> [文字水印]字体路径 ：</td>
          <td width="50%"><input type="text" name="wm_font_path" value="<?php echo $config['wm_font_path']?>" title="字体路径" /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> [文字水印]文字大小 ：</td>
          <td width="50%"><input type="text" name="wm_font_size" value="<?php echo $config['wm_font_size']?>" title="文字大小" /></td>
          <td><span>px</span></td>
        </tr>
        <tr>
          <td class="table_right"> [文字水印]字体颜色 ：</td>
          <td width="50%"><input type="text" name="wm_font_color" value="<?php echo $config['wm_font_color']?>" title="字体颜色" /></td>
          <td><span>十六进制值，六位数</span></td>
        </tr>
        <tr>
          <td class="table_right"> [文字水印]阴影颜色 ：</td>
          <td width="50%"><input type="text" name="wm_shadow_color" value="<?php echo $config['wm_shadow_color']?>" title="阴影颜色" /></td>
          <td><span>十六进制值，六位数</span></td>
        </tr>
        <tr>
          <td class="table_right"> [文字水印]阴影与文字之间的距离 ：</td>
          <td width="50%"><input type="text" name="wm_shadow_distance" value="<?php echo $config['wm_shadow_distance']?>" title="阴影与文字之间的距离" /></td>
          <td><span>px</span></td>
        </tr>
        <tr>
          <td class="table_right"> [图片水印]图片路径 ：</td>
          <td width="50%"><input type="text" name="wm_overlay_path" value="<?php echo $config['wm_overlay_path']?>" title="图片路径" /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> [图片水印]不透明度 ：</td>
          <td width="50%"><input type="text" name="wm_opacity" value="<?php echo $config['wm_opacity']?>" title="不透明度" /></td>
          <td><span>1-100</span></td>
        </tr>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="保存" class="roundbtn" /></td>
          <td></td>
        </tr>
        </tbody>
      </table>
  </form>
  </div>
  <?php $this->load->view('admin/footer')?>