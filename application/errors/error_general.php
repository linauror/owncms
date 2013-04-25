<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $heading ?></title>
<style type="text/css">
::selection { background-color: #E13300; color: white; }
::moz-selection {
background-color: #E13300;
color: white;
}
::webkit-selection {
background-color: #E13300;
color: white;
}
body { background-color: #fff; margin: 40px; font: 13px/20px normal Helvetica, Arial, sans-serif; color: #4F5155; }
a { color: #003399; background-color: transparent; font-weight: normal; }
h1 { color: #444; background-color: transparent; border-bottom: 1px solid #D0D0D0; font-size: 19px; font-weight: normal; margin: 0 0 14px 0; padding: 14px 15px 10px 15px; }
code { font-family: Consolas, Monaco, Courier New, Courier, monospace; font-size: 12px; background-color: #f9f9f9; border: 1px solid #D0D0D0; color: #002166; display: block; margin: 14px 0 14px 0; padding: 12px 10px 12px 10px; }
#container { margin: 10px; border: 1px solid #D0D0D0; -webkit-box-shadow: 0 0 8px #D0D0D0; }
p { margin: 12px 15px 12px 15px; }
</style>
</head>

<body>
<div id="container">
  <h1><?php echo $heading ?></h1>
  <?php echo $message; ?>
  <p><a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'javascript:history.go(-1);'?>" title="返回上页" >返回上页</a> <a href="/" title="返回首页">返回首页</a></p>
</div>
</body>
</html>
