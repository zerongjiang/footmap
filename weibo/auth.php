<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>未授权时的页面</title>
</head>

<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
<script> 
function authLoad(){
 
	App.AuthDialog.show({
	client_id : '3703297609',    //必选，appkey
	redirect_uri : 'http://apps.weibo.com/travelworld',     //必选，授权后的回调地址
	height: 120    //可选，默认距顶端120px
	});
}
</script>
 
<body onload="authLoad();" style="background:url(imgs/auth.png) no-repeat">

</body>
</html>

