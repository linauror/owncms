// JavaScript Document
//$(document).ready(function(){
//$(".table tr:even").addClass("alt"); //给class为table的表格的偶数行添加class值为alt
//});
$(document).ready(function(){
//复选框全选，以及选中背景之类	
$('.fileslist .table_title').click(
    function(){
       if($(this).hasClass('alt')) {
        	$('.fileslist').find('input[type="checkbox"]').removeAttr('checked');
        	$(this).removeClass('alt');
        	$('.fileslist tbody tr').removeClass('alt');
        } else {
    	  $('.fileslist').find('input[type="checkbox"]').attr('checked','checked'); 
    	  $(this).addClass('alt');
    	  $('.fileslist tbody tr').addClass('alt');
        }
    }
);		
 $('.fileslist tbody tr').click(
  function() {
   if ($(this).hasClass('alt')) {
    $(this).removeClass('alt');
    $(this).find('input[type="checkbox"]').removeAttr('checked');
   } else {
    $(this).addClass('alt');
    $(this).find('input[type="checkbox"]').attr('checked','checked');
   }
  }
 );
 
//顶部搜索框
$('.top_search input[type="text"]').focus(
	function(){
		$(this).val("");
			}
)

//隐藏提示框
setTimeout(function(){
    $('#result p').hide();
},3000);

//隐藏提示框
$('#result p').click(function(){
    $(this).hide();
})

//图片预览
$('.preview_link').hover(function(){
    var img = $(this).parent('td').children('.litpic').val();
    if (img.length) {
        $('.preview_box img').attr('src', img);
        $('.preview_box').show('fast');        
    }
}, function(){
    $('.preview_box').hide('fast');
})
 
});

//选择下拉框跳转对应url
function selectGoUrl(tag, by){
    var key = $(tag).attr('name');
    var value = $(tag).find('option:selected').attr(by);
    window.location.href = '?' + key + '=' + value;
}

//后台选中导航
function adminnav_hover(nav) {
    $('.' + nav + 'Page').addClass('hover');
}

//异步上传图片
function ajaxFileUpload(url, inputid, toinputclass)
{
    $('.'+toinputclass).val('上传中...');
	$.ajaxFileUpload
	(
		{
			url : url,
			secureuri : false,
			fileElementId : inputid,
			dataType: 'json',
            success : function(data) {
                if (data.err == '') {
                    $('.'+toinputclass).val(data.msg.url);
                    $('#'+inputid).next('.preview_link').attr('href', data.msg.url);
                }else {
                    alert(data.err);
                }
            }
		}
	)
	
	return false;

}