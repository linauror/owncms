$(function(){
    $.post(base_url+'uapi/checklogin', {uid : uid}, function(data){
        if (data) {
            html = '';
            data = eval('(' + data + ')');
            html += '<h3>欢迎登录</h3>' +
                    '<img src="'+data.avatar+'?s=44" class="avatar" title="'+data.username+'" />' +
                    '<p><strong>'+data.username+'</strong></p>' + 
                    '<p><a href="'+base_url+'author/'+data.username+'.html" title="我的作品">我的作品</a>&nbsp;&nbsp;&nbsp;' + 
                    (data.userurl ? '<a href="'+data.userurl+'" target="_blank">我的网站</a></p>' : '</p>') + 
                    '<p>上次登录：'+data.logedtime+'</p>' + 
                    '<p><a href="'+base_url+'login/loginout?refer='+current_url+'" title="退出登录">登出</a>&nbsp;&nbsp;&nbsp;' +
                    (data.group == 1 ? '<a href="'+base_url+'admin">后台管理</a></p>' : '</p>');
            $('.right_con .user_info').html(html).show();
            $('.right_con .login').html('<p><a href="'+base_url+'login/loginout?refer='+current_url+'" title="退出登录">登出</a>');
        }
    })
    
})