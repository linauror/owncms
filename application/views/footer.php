<div id="footer">
Powered By <a href="http://owncms.linauror.com" target="_blank">OWNCMS</a> Design By Wordpress
<p>查询：<?php echo $this->db->query_count;?>次 &nbsp;&nbsp;用时：{elapsed_time}秒 &nbsp;&nbsp;占用内存{memory_usage} 
<script type="text/javascript" src="<?php echo base_url();?>static/js/owncms.js"></script>
<script type="text/javascript">
var base_url = '<?php echo base_url().(index_page() != '' ? index_page().'/' : '' );?>';
var current_url = '<?php echo current_url();?>';
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F81e53d2f17ac8709fc7ee1c91813ee9b' type='text/javascript'%3E%3C/script%3E"));
</script>
</p>
</div>