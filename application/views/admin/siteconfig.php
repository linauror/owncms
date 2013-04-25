  <?php $this->load->view('admin/header');?>
  <div id="content">
    <table class="table">
      <thead>
        <tr>
          <th colspan="3">网站基本信息</th>
        </tr>
      </thead>
      <tbody>
        <tr class="table_title">
          <td>参数说明</td>
          <td width="50%">参数值</td>
          <td>变量名</td>
        </tr>
      <form action="<?php echo site_url('admin/siteconfig/save');?>" method="post">
        <?php if(count($siteconfig)){
            foreach($siteconfig as $line){
        ?>
        <tr>
          <td class="table_right"><?php echo $line['description']?>：</td>
          <td><?php 
            if($line['inputtype'] == 'text'){
          ?>
            <input type="text" name="<?php echo $line['varname'] ?>" value="<?php echo $line['value'] ?>" title="<?php echo $line['description']?>" />
            <?php
          }else{
          ?>
            <textarea name="<?php echo $line['varname'] ?>" title="<?php echo $line['description']?>"><?php echo $line['value'] ?></textarea>
            <?php
          }
          ?></td>
          <td><span><?php echo $line['varname'] ?></span> <a href="<?php echo site_url('admin/siteconfig/del/'.$line['id']);?>" title="删除此变量" onclick="return window.confirm(' 请保证删除此变量能保证网站的正常运行！');">X</a></td>
        </tr>
        <?php   
            }  
        } 
        ?>
        <tr>
          <td class="table_right"></td>
          <td><input type="submit" value="更新" class="roundbtn" /></td>
          <td></td>
        </tr>
      </form>
        </tbody>
      
      <thead>
        <tr>
          <th colspan="3">添加新配置信息</th>
        </tr>
      </thead>
      <tbody>
      <form action="<?php echo site_url('admin/siteconfig/add');?>" method="post">
        <tr>
          <td class="table_right"> 参数说明 ：</td>
          <td><input type="text" name="description" value="" title="参数说明" /></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 参数值 ：</td>
          <td><input type="text" name="value" value=""  title="参数值"/></td>
          <td><span></span></td>
        </tr>
        <tr>
          <td class="table_right"> 变量名 ：</td>
          <td><input type="text" name="varname" value="" title="变量名" /></td>
          <td><span>* 英文字母 不得重复已有的</span></td>
        </tr>
        <tr>
          <td class="table_right"> 参数类型 ：</td>
          <td><select name="inputtype">
              <option value="text">单行文本</option>
              <option value="textarea">多行文本</option>
            </select></td>
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