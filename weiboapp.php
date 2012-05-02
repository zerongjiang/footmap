<?php
session_start();
include_once( 'weibo/config.php' );
include_once( 'weibo/saetv2.ex.class.php' );
//从POST过来的signed_request中提取oauth2信息
if(!empty($_REQUEST["signed_request"])){
	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY  );
	$data=$o->parseSignedRequest($_REQUEST["signed_request"]);
	if($data=='-2'){
		 die('签名错误!');
	}else{
		$_SESSION['oauth2']=$data;
	}
}
//判断用户是否授权
if (empty($_SESSION['oauth2']["user_id"])) {
		include "weibo/auth.php";
		exit;
} else {
		$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$_SESSION['oauth2']['oauth_token'] ,'' );
		$myuid = $_SESSION['oauth2']["user_id"];
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=3703297609" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
</script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" />
</head>
<body>
<script type="text/javascript">
</script>
	<div id="wrapper">
	<div id="header">
		<div id="avatar">
		<div class="avatar_img">
		<?php 
		$myinfo = $c->show_user_by_id($myuid);
		echo "<img src='$myinfo[avatar_large]'/>";
		?>
		<span></span>	
		</div></div>
		<div id="username"><?php echo $myinfo['screen_name'];?><span id="status">在路上。。。</span></div>
		<div id="searchbox">
		<input id="search" autocomplete="off" value="搜索地名。。。">
		<table id="result"></table>
		</div>
		<div id="ontheroad" title="On the Road" note="larry 3d">
		<pre id="movie">
        _ __          _ __                    __    __        Travel THE WORLD                  __       _ __          _ __          _ __          _ __          _ __          _ __          _ __  
       (_|_ '.       (_|_ '.                 /\ \__/\ \                                        /\ \     (_|_ '.       (_|_ '.       (_|_ '.       (_|_ '.       (_|_ '.       (_|_ '.       (_|_ '.
           '-'           '-'   ___    ___    \ \ ,_\ \ \___      __       _ __  ___     __     \_\ \        '-'           '-'           '-'           '-'           '-'           '-'           '-'
 _ _.-.        _ _.-.         / __`\/' _ `\   \ \ \/\ \  _ `\  /'__`\    /\`'__\ __`\ /'__`\   /'_` \           _ _.-.        _ _.-.        _ _.-.        _ _.-.        _ _.-.        _ _.-.        
(_|__.'       (_|__.'        /\ \L\ \\ \/\ \   \ \ \_\ \ \ \ \/\  __/    \ \ \/\ \L\ \\ \L\.\_/\ \L\ \         (_|__.'       (_|__.'       (_|__.'       (_|__.'       (_|__.'       (_|__.'        
        _ __          _ __   \ \____/ \_\ \_\   \ \__\\ \_\ \_\ \____\    \ \_\ \____/ \__/.\_\ \___,_\  _ __          _ __          _ __          _ __          _ __          _ __          _ __  
       (_|_ '.       (_|_ '.  \/___/ \/_/\/_/    \/__/ \/_/\/_/\/____/     \/_/\/___/ \/__/\/_/\/__,_ / (_|_ '.       (_|_ '.       (_|_ '.       (_|_ '.       (_|_ '.       (_|_ '.       (_|_ '.
           '-'           '-'                                                                                '-'           '-'           '-'           '-'           '-'           '-'           '-'
		</pre>
		<a id="play" title="play!"></a>
		</div>	
 		</div>
		<div class="clear"></div>

<div id="visited">
<span>去过的地方:</span>
<div class="clear"></div>
</div>

<div id="main">

<div id="mypublisher">
<div class="toolbar">
	<div id="backstep"><a title="返回" class="btn" href="javascript:void(0)">↺</a></div>
	<div id="post"><a title="发布微博" class="btn" href="javascript:void(0)">发布微博</a></div>
	<div id='saveas'><a title="另存为" class="btn" href='' target='_blank'>保存图片</a></div>
	<div id="fselector"><a title="选择@好友" class="btn" href="javascript:void(0)">选择@好友</a></div>

</div>
<div id="weibostatus"><textarea><?php echo $myinfo['screen_name'];?></textarea></div>
<div id="renderedimg"></div>
</div>

<div id="step1">
	<div class="toolbar">
		<div class="labels">地图色:</div>
		<div id="mapcolorpicker" class="mycolorpicker" title="单色"><div></div></div>
		<div id="rainbow" title="彩虹色"></div>
		<div id="colorthemes"></div>
		<div class="labels">背景色:</div>
		<div id="bgcolorpicker" class="mycolorpicker" title="选择背景色"><div></div></div>
		<div id="submit"><a class="btn" href="javascript:void(0)">预览</a></div>
	</div>
		<div class="clear"></div>
	<div id="preview">
	<div id="svgdiv">
	<?php require('map.php');?>
	</div> <!-- end of svgdiv-->
	<div id="msg" title="点击修改"><pre><?php
	include_once( 'quotes.php' );
	quotes();
	?></pre></div>
</div>
</div>
</div>
<div class="clear"></div>
<div id="footer">
<span>总有一天要环游世界 @ 2012 | 感谢爱我和我爱的人 | <a href='mailto:admin@jzr.me'>Zerong Jiang</a></span>
</div>
</div><!-- end of wrapper-->
<div id="mytip"><a href="javascript:void(0)">x</a><span></span></div>
<span id="debug"></span>

<?php require('movie.php');?>
<script tyoe="text/javascript" src="js/movie.js"></script>
<script type="text/javascript">
var movie = new Movie();
var ontheroad;
movie.init("movie");
$('#play').click(function(){
	if(movie.running == false ){
		movie.autostart = true;
		ontheroad = $('#movie').html();
		movie.start();
		$(this).css('background-image','url("imgs/stop.gif")');
		$(this).attr('title','停下看风景～～');
	}
	else{
		movie.stop();
		$(this).css('background-image','url("imgs/play.gif")');
		$(this).attr('title','上路吧,少年!!!');
		$('#movie').html(ontheroad);
	}
});
$('#ontheroad').mouseenter(function(){
	$('#play').css("visibility","visible");
});
$('#ontheroad').mouseleave(function(){
	$('#play').css("visibility","hidden");
});
</script>

</body>

<script type="text/javascript">
var myfoot = {};
var svgcolor = "#ef0000";
var svgbgcolor = "#8fb9e1"
var msg = "";
var colorful = false;
var colornum = -1;

var colorthemes =[];

colorthemes.push(["#9FDE00", "#E7000C", "#EC008C", "#FF7404", "#FFBE2A", "#8FB9E1"]); //colorful rainbow
colorthemes.push(["#FF0000", "#FF6000", "#FF9A00", "#FFCD00", "#FEFF00", "#BAE806", "#2ECE0C", "#0C99CE", "#0C5BCE", "#1F0CCE"]); //屏幕犀利色系
colorthemes.push(["#6989BA", "#8CA5CA", "#AFC0DA", "#95BDCE", "#B3AFDA", "#DAAFC9", "#E1A9A8", "#E1CBA8", "#E0E1A8", "#CBD79D"]); //淡雅
colorthemes.push(["#8569CF", "#0D9FD8", "#8AD749", "#EECE00", "#F8981F", "#F80E27", "#F640AE"]); // ipod nano colors
colorthemes.push(["#684F19", "#86723D", "#A49561", "#C3B984", "#E1DCA8", "#FFFFCC"]); // cappuccino
colorthemes.push(["#04BFBF","#F7E967","#A9CF54","#588F27"]); //pear lemon fizz
colorthemes.push(["#906352","#EA856F","#EEBA6A","#BB9B71"]); //old map

$('#colorthemes').css({"top":$('#rainbow').offset()["top"]+$('#rainbow').height()+5,"left":$('#rainbow').offset()["left"]});

for(var i in colorthemes){
	var colordiv="<div class='colortheme'>";
	for(var j in colorthemes[i]){
		colordiv = colordiv + "<div class='colorblk' style='background:"+colorthemes[i][j]+"'></div>";
	}
	colordiv = colordiv + "<div class='clear'></div>";
	colordiv = colordiv + "</div>";
	colordiv = colordiv + "<div class='clear'></div>";
	$('#colorthemes').append(colordiv);
}

$('#rainbow').click(function(){
	$('#colorthemes').toggle(100);
});

$('#colorthemes').mouseleave(function(){
	$('#colorthemes').hide(100);
});

$('.colortheme').mouseenter(function(){
	$(this).addClass("color-shine");
});
$('.colortheme').mouseleave(function(){
	$(this).removeClass("color-shine");
});
$('.colortheme').click(function(){
	colorful = true;
	colornum = $(this).index()/2;
	colorfulsvg(colorthemes[colornum]);	
	$('#colorthemes').toggle(100);
});

var china = {"province":[{"code":110000,"name":"北京市","py":"beijingshi"},{"code":120000,"name":"天津市","py":"tianjinshi"},{"code":130000,"name":"河北省","py":"hebeisheng","city":[{"code":130100,"name":"石家庄市","py":"shijiazhuangshi"},{"code":130200,"name":"唐山市","py":"tangshanshi"},{"code":130300,"name":"秦皇岛市","py":"qinhuangdaoshi"},{"code":130400,"name":"邯郸市","py":"handanshi"},{"code":130500,"name":"邢台市","py":"xingtaishi"},{"code":130600,"name":"保定市","py":"baodingshi"},{"code":130700,"name":"张家口市","py":"zhangjiakoushi"},{"code":130800,"name":"承德市","py":"chengdeshi"},{"code":130900,"name":"沧州市","py":"cangzhoushi"},{"code":131000,"name":"廊坊市","py":"langfangshi"},{"code":131100,"name":"衡水市","py":"hengshuishi"}]},{"code":140000,"name":"山西省","py":"shanxisheng","city":[{"code":140100,"name":"太原市","py":"taiyuanshi"},{"code":140200,"name":"大同市","py":"datongshi"},{"code":140300,"name":"阳泉市","py":"yangquanshi"},{"code":140400,"name":"长治市","py":"changzhishi"},{"code":140500,"name":"晋城市","py":"jinchengshi"},{"code":140600,"name":"朔州市","py":"shuozhoushi"},{"code":140700,"name":"晋中市","py":"jinzhongshi"},{"code":140800,"name":"运城市","py":"yunchengshi"},{"code":140900,"name":"忻州市","py":"xinzhoushi"},{"code":141000,"name":"临汾市","py":"linfenshi"},{"code":141100,"name":"吕梁市","py":"lvliangshi"}]},{"code":150000,"name":"内蒙古自治区","py":"neimengguzizhiqu","city":[{"code":150100,"name":"呼和浩特市","py":"huhehaoteshi"},{"code":150200,"name":"包头市","py":"baotoushi"},{"code":150300,"name":"乌海市","py":"wuhaishi"},{"code":150400,"name":"赤峰市","py":"chifengshi"},{"code":150500,"name":"通辽市","py":"tongliaoshi"},{"code":150600,"name":"鄂尔多斯市","py":"eerduosishi"},{"code":150700,"name":"呼伦贝尔市","py":"hulunbeiershi"},{"code":150800,"name":"巴彦淖尔市","py":"bayannaoershi"},{"code":150900,"name":"乌兰察布市","py":"wulanchabushi"},{"code":152200,"name":"兴安盟","py":"xinganmeng"},{"code":152500,"name":"锡林郭勒盟","py":"xilinguolemeng"},{"code":152900,"name":"阿拉善盟","py":"alashanmeng"}]},{"code":210000,"name":"辽宁省","py":"liaoningsheng","city":[{"code":210100,"name":"沈阳市","py":"shenyangshi"},{"code":210200,"name":"大连市","py":"dalianshi"},{"code":210300,"name":"鞍山市","py":"anshanshi"},{"code":210400,"name":"抚顺市","py":"fushunshi"},{"code":210500,"name":"本溪市","py":"benxishi"},{"code":210600,"name":"丹东市","py":"dandongshi"},{"code":210700,"name":"锦州市","py":"jinzhoushi"},{"code":210800,"name":"营口市","py":"yingkoushi"},{"code":210900,"name":"阜新市","py":"fuxinshi"},{"code":211000,"name":"辽阳市","py":"liaoyangshi"},{"code":211100,"name":"盘锦市","py":"panjinshi"},{"code":211200,"name":"铁岭市","py":"tielingshi"},{"code":211300,"name":"朝阳市","py":"chaoyangshi"},{"code":211400,"name":"葫芦岛市","py":"huludaoshi"}]},{"code":220000,"name":"吉林省","py":"jilinsheng","city":[{"code":220100,"name":"长春市","py":"changchunshi"},{"code":220200,"name":"吉林市","py":"jilinshi"},{"code":220300,"name":"四平市","py":"sipingshi"},{"code":220400,"name":"辽源市","py":"liaoyuanshi"},{"code":220500,"name":"通化市","py":"tonghuashi"},{"code":220600,"name":"白山市","py":"baishanshi"},{"code":220700,"name":"松原市","py":"songyuanshi"},{"code":220800,"name":"白城市","py":"baichengshi"},{"code":222400,"name":"延边朝鲜族自治州","py":"yanbianchaoxianzuzizhizhou"}]},{"code":230000,"name":"黑龙江省","py":"heilongjiangsheng","city":[{"code":230100,"name":"哈尔滨市","py":"haerbinshi"},{"code":230200,"name":"齐齐哈尔市","py":"qiqihaershi"},{"code":230300,"name":"鸡西市","py":"jixishi"},{"code":230400,"name":"鹤岗市","py":"hegangshi"},{"code":230500,"name":"双鸭山市","py":"shuangyashanshi"},{"code":230600,"name":"大庆市","py":"daqingshi"},{"code":230700,"name":"伊春市","py":"yichunshi"},{"code":230800,"name":"佳木斯市","py":"jiamusishi"},{"code":230900,"name":"七台河市","py":"qitaiheshi"},{"code":231000,"name":"牡丹江市","py":"mudanjiangshi"},{"code":231100,"name":"黑河市","py":"heiheshi"},{"code":231200,"name":"绥化市","py":"suihuashi"},{"code":232700,"name":"大兴安岭地区","py":"daxinganlingdequ"}]},{"code":310000,"name":"上海市","py":"shanghaishi"},{"code":320000,"name":"江苏省","py":"jiangsusheng","city":[{"code":320100,"name":"南京市","py":"nanjingshi"},{"code":320200,"name":"无锡市","py":"wuxishi"},{"code":320300,"name":"徐州市","py":"xuzhoushi"},{"code":320400,"name":"常州市","py":"changzhoushi"},{"code":320500,"name":"苏州市","py":"suzhoushi"},{"code":320600,"name":"南通市","py":"nantongshi"},{"code":320700,"name":"连云港市","py":"lianyungangshi"},{"code":320800,"name":"淮安市","py":"huaianshi"},{"code":320900,"name":"盐城市","py":"yanchengshi"},{"code":321000,"name":"扬州市","py":"yangzhoushi"},{"code":321100,"name":"镇江市","py":"zhenjiangshi"},{"code":321200,"name":"泰州市","py":"taizhoushi"},{"code":321300,"name":"宿迁市","py":"suqianshi"}]},{"code":330000,"name":"浙江省","py":"zhejiangsheng","city":[{"code":330100,"name":"杭州市","py":"hangzhoushi"},{"code":330200,"name":"宁波市","py":"ningboshi"},{"code":330300,"name":"温州市","py":"wenzhoushi"},{"code":330400,"name":"嘉兴市","py":"jiaxingshi"},{"code":330500,"name":"湖州市","py":"huzhoushi"},{"code":330600,"name":"绍兴市","py":"shaoxingshi"},{"code":330700,"name":"金华市","py":"jinhuashi"},{"code":330800,"name":"衢州市","py":"quzhoushi"},{"code":330900,"name":"舟山市","py":"zhoushanshi"},{"code":331000,"name":"台州市","py":"taizhoushi"},{"code":331100,"name":"丽水市","py":"lishuishi"}]},{"code":340000,"name":"安徽省","py":"anhuisheng","city":[{"code":340100,"name":"合肥市","py":"hefeishi"},{"code":340200,"name":"芜湖市","py":"wuhushi"},{"code":340300,"name":"蚌埠市","py":"bangbushi"},{"code":340400,"name":"淮南市","py":"huainanshi"},{"code":340500,"name":"马鞍山市","py":"maanshanshi"},{"code":340600,"name":"淮北市","py":"huaibeishi"},{"code":340700,"name":"铜陵市","py":"tonglingshi"},{"code":340800,"name":"安庆市","py":"anqingshi"},{"code":341000,"name":"黄山市","py":"huangshanshi"},{"code":341100,"name":"滁州市","py":"chuzhoushi"},{"code":341200,"name":"阜阳市","py":"fuyangshi"},{"code":341300,"name":"宿州市","py":"suzhoushi"},{"code":341500,"name":"六安市","py":"liuanshi"},{"code":341600,"name":"亳州市","py":"bozhoushi"},{"code":341700,"name":"池州市","py":"chizhoushi"},{"code":341800,"name":"宣城市","py":"xuanchengshi"}]},{"code":350000,"name":"福建省","py":"fujiansheng","city":[{"code":350100,"name":"福州市","py":"fuzhoushi"},{"code":350200,"name":"厦门市","py":"xiamenshi"},{"code":350300,"name":"莆田市","py":"putianshi"},{"code":350400,"name":"三明市","py":"sanmingshi"},{"code":350500,"name":"泉州市","py":"quanzhoushi"},{"code":350600,"name":"漳州市","py":"zhangzhoushi"},{"code":350700,"name":"南平市","py":"nanpingshi"},{"code":350800,"name":"龙岩市","py":"longyanshi"},{"code":350900,"name":"宁德市","py":"ningdeshi"}]},{"code":360000,"name":"江西省","py":"jiangxisheng","city":[{"code":360100,"name":"南昌市","py":"nanchangshi"},{"code":360200,"name":"景德镇市","py":"jingdezhenshi"},{"code":360300,"name":"萍乡市","py":"pingxiangshi"},{"code":360400,"name":"九江市","py":"jiujiangshi"},{"code":360500,"name":"新余市","py":"xinyushi"},{"code":360600,"name":"鹰潭市","py":"yingtanshi"},{"code":360700,"name":"赣州市","py":"ganzhoushi"},{"code":360800,"name":"吉安市","py":"jianshi"},{"code":360900,"name":"宜春市","py":"yichunshi"},{"code":361000,"name":"抚州市","py":"fuzhoushi"},{"code":361100,"name":"上饶市","py":"shangraoshi"}]},{"code":370000,"name":"山东省","py":"shandongsheng","city":[{"code":370100,"name":"济南市","py":"jinanshi"},{"code":370200,"name":"青岛市","py":"qingdaoshi"},{"code":370300,"name":"淄博市","py":"ziboshi"},{"code":370400,"name":"枣庄市","py":"zaozhuangshi"},{"code":370500,"name":"东营市","py":"dongyingshi"},{"code":370600,"name":"烟台市","py":"yantaishi"},{"code":370700,"name":"潍坊市","py":"weifangshi"},{"code":370800,"name":"济宁市","py":"jiningshi"},{"code":370900,"name":"泰安市","py":"taianshi"},{"code":371000,"name":"威海市","py":"weihaishi"},{"code":371100,"name":"日照市","py":"rizhaoshi"},{"code":371200,"name":"莱芜市","py":"laiwushi"},{"code":371300,"name":"临沂市","py":"linyishi"},{"code":371400,"name":"德州市","py":"dezhoushi"},{"code":371500,"name":"聊城市","py":"liaochengshi"},{"code":371600,"name":"滨州市","py":"binzhoushi"},{"code":371700,"name":"菏泽市","py":"hezeshi"}]},{"code":410000,"name":"河南省","py":"henansheng","city":[{"code":410100,"name":"郑州市","py":"zhengzhoushi"},{"code":410200,"name":"开封市","py":"kaifengshi"},{"code":410300,"name":"洛阳市","py":"luoyangshi"},{"code":410400,"name":"平顶山市","py":"pingdingshanshi"},{"code":410500,"name":"安阳市","py":"anyangshi"},{"code":410600,"name":"鹤壁市","py":"hebishi"},{"code":410700,"name":"新乡市","py":"xinxiangshi"},{"code":410800,"name":"焦作市","py":"jiaozuoshi"},{"code":410900,"name":"濮阳市","py":"puyangshi"},{"code":411000,"name":"许昌市","py":"xuchangshi"},{"code":411100,"name":"漯河市","py":"luoheshi"},{"code":411200,"name":"三门峡市","py":"sanmenxiashi"},{"code":411300,"name":"南阳市","py":"nanyangshi"},{"code":411400,"name":"商丘市","py":"shangqiushi"},{"code":411500,"name":"信阳市","py":"xinyangshi"},{"code":411600,"name":"周口市","py":"zhoukoushi"},{"code":411700,"name":"驻马店市","py":"zhumadianshi"},{"code":419000,"name":"省直辖县级行政区划","py":"shengzhixiaxianjixingzhengquhua"}]},{"code":420000,"name":"湖北省","py":"hubeisheng","city":[{"code":420100,"name":"武汉市","py":"wuhanshi"},{"code":420200,"name":"黄石市","py":"huangshishi"},{"code":420300,"name":"十堰市","py":"shiyanshi"},{"code":420500,"name":"宜昌市","py":"yichangshi"},{"code":420600,"name":"襄阳市","py":"xiangyangshi"},{"code":420700,"name":"鄂州市","py":"ezhoushi"},{"code":420800,"name":"荆门市","py":"jingmenshi"},{"code":420900,"name":"孝感市","py":"xiaoganshi"},{"code":421000,"name":"荆州市","py":"jingzhoushi"},{"code":421100,"name":"黄冈市","py":"huanggangshi"},{"code":421200,"name":"咸宁市","py":"xianningshi"},{"code":421300,"name":"随州市","py":"suizhoushi"},{"code":422800,"name":"恩施土家族苗族自治州","py":"enshitujiazumiaozuzizhizhou"},{"code":429000,"name":"省直辖县级行政区划","py":"shengzhixiaxianjixingzhengquhua"}]},{"code":430000,"name":"湖南省","py":"hunansheng","city":[{"code":430100,"name":"长沙市","py":"changshashi"},{"code":430200,"name":"株洲市","py":"zhuzhoushi"},{"code":430300,"name":"湘潭市","py":"xiangtanshi"},{"code":430400,"name":"衡阳市","py":"hengyangshi"},{"code":430500,"name":"邵阳市","py":"shaoyangshi"},{"code":430600,"name":"岳阳市","py":"yueyangshi"},{"code":430700,"name":"常德市","py":"changdeshi"},{"code":430800,"name":"张家界市","py":"zhangjiajieshi"},{"code":430900,"name":"益阳市","py":"yiyangshi"},{"code":431000,"name":"郴州市","py":"chenzhoushi"},{"code":431100,"name":"永州市","py":"yongzhoushi"},{"code":431200,"name":"怀化市","py":"huaihuashi"},{"code":431300,"name":"娄底市","py":"loudishi"},{"code":433100,"name":"湘西土家族苗族自治州","py":"xiangxitujiazumiaozuzizhizhou"}]},{"code":440000,"name":"广东省","py":"guangdongsheng","city":[{"code":440100,"name":"广州市","py":"guangzhoushi"},{"code":440200,"name":"韶关市","py":"shaoguanshi"},{"code":440300,"name":"深圳市","py":"shenzhenshi"},{"code":440400,"name":"珠海市","py":"zhuhaishi"},{"code":440500,"name":"汕头市","py":"shantoushi"},{"code":440600,"name":"佛山市","py":"foshanshi"},{"code":440700,"name":"江门市","py":"jiangmenshi"},{"code":440800,"name":"湛江市","py":"zhanjiangshi"},{"code":440900,"name":"茂名市","py":"maomingshi"},{"code":441200,"name":"肇庆市","py":"zhaoqingshi"},{"code":441300,"name":"惠州市","py":"huizhoushi"},{"code":441400,"name":"梅州市","py":"meizhoushi"},{"code":441500,"name":"汕尾市","py":"shanweishi"},{"code":441600,"name":"河源市","py":"heyuanshi"},{"code":441700,"name":"阳江市","py":"yangjiangshi"},{"code":441800,"name":"清远市","py":"qingyuanshi"},{"code":441900,"name":"东莞市","py":"dongguanshi"},{"code":442000,"name":"中山市","py":"zhongshanshi"},{"code":445100,"name":"潮州市","py":"chaozhoushi"},{"code":445200,"name":"揭阳市","py":"jieyangshi"},{"code":445300,"name":"云浮市","py":"yunfushi"}]},{"code":450000,"name":"广西壮族自治区","py":"guangxizhuangzuzizhiqu","city":[{"code":450100,"name":"南宁市","py":"nanningshi"},{"code":450200,"name":"柳州市","py":"liuzhoushi"},{"code":450300,"name":"桂林市","py":"guilinshi"},{"code":450400,"name":"梧州市","py":"wuzhoushi"},{"code":450500,"name":"北海市","py":"beihaishi"},{"code":450600,"name":"防城港市","py":"fangchenggangshi"},{"code":450700,"name":"钦州市","py":"qinzhoushi"},{"code":450800,"name":"贵港市","py":"guigangshi"},{"code":450900,"name":"玉林市","py":"yulinshi"},{"code":451000,"name":"百色市","py":"baiseshi"},{"code":451100,"name":"贺州市","py":"hezhoushi"},{"code":451200,"name":"河池市","py":"hechishi"},{"code":451300,"name":"来宾市","py":"laibinshi"},{"code":451400,"name":"崇左市","py":"chongzuoshi"}]},{"code":460000,"name":"海南省","py":"hainansheng","city":[{"code":460100,"name":"海口市","py":"haikoushi"},{"code":460200,"name":"三亚市","py":"sanyashi"},{"code":469000,"name":"省直辖县级行政区划","py":"shengzhixiaxianjixingzhengquhua"}]},{"code":500000,"name":"重庆市","py":"chongqingshi"},{"code":510000,"name":"四川省","py":"sichuansheng","city":[{"code":510100,"name":"成都市","py":"chengdoushi"},{"code":510300,"name":"自贡市","py":"zigongshi"},{"code":510400,"name":"攀枝花市","py":"panzhihuashi"},{"code":510500,"name":"泸州市","py":"luzhoushi"},{"code":510600,"name":"德阳市","py":"deyangshi"},{"code":510700,"name":"绵阳市","py":"mianyangshi"},{"code":510800,"name":"广元市","py":"guangyuanshi"},{"code":510900,"name":"遂宁市","py":"suiningshi"},{"code":511000,"name":"内江市","py":"neijiangshi"},{"code":511100,"name":"乐山市","py":"leshanshi"},{"code":511300,"name":"南充市","py":"nanchongshi"},{"code":511400,"name":"眉山市","py":"meishanshi"},{"code":511500,"name":"宜宾市","py":"yibinshi"},{"code":511600,"name":"广安市","py":"guanganshi"},{"code":511700,"name":"达州市","py":"dazhoushi"},{"code":511800,"name":"雅安市","py":"yaanshi"},{"code":511900,"name":"巴中市","py":"bazhongshi"},{"code":512000,"name":"资阳市","py":"ziyangshi"},{"code":513200,"name":"阿坝藏族羌族自治州","py":"abazangzuqiangzuzizhizhou"},{"code":513300,"name":"甘孜藏族自治州","py":"ganzizangzuzizhizhou"},{"code":513400,"name":"凉山彝族自治州","py":"liangshanyizuzizhizhou"}]},{"code":520000,"name":"贵州省","py":"guizhousheng","city":[{"code":520100,"name":"贵阳市","py":"guiyangshi"},{"code":520200,"name":"六盘水市","py":"liupanshuishi"},{"code":520300,"name":"遵义市","py":"zunyishi"},{"code":520400,"name":"安顺市","py":"anshunshi"},{"code":520500,"name":"毕节市","py":"bijieshi"},{"code":520600,"name":"铜仁市","py":"tongrenshi"},{"code":522300,"name":"黔西南布依族苗族自治州","py":"qianxinanbuyizumiaozuzizhizhou"},{"code":522600,"name":"黔东南苗族侗族自治州","py":"qiandongnanmiaozudongzuzizhizhou"},{"code":522700,"name":"黔南布依族苗族自治州","py":"qiannanbuyizumiaozuzizhizhou"}]},{"code":530000,"name":"云南省","py":"yunnansheng","city":[{"code":530100,"name":"昆明市","py":"kunmingshi"},{"code":530300,"name":"曲靖市","py":"qujingshi"},{"code":530400,"name":"玉溪市","py":"yuxishi"},{"code":530500,"name":"保山市","py":"baoshanshi"},{"code":530600,"name":"昭通市","py":"zhaotongshi"},{"code":530700,"name":"丽江市","py":"lijiangshi"},{"code":530800,"name":"普洱市","py":"puershi"},{"code":530900,"name":"临沧市","py":"lincangshi"},{"code":532300,"name":"楚雄彝族自治州","py":"chuxiongyizuzizhizhou"},{"code":532500,"name":"红河哈尼族彝族自治州","py":"honghehanizuyizuzizhizhou"},{"code":532600,"name":"文山壮族苗族自治州","py":"wenshanzhuangzumiaozuzizhizhou"},{"code":532800,"name":"西双版纳傣族自治州","py":"xishuangbannadaizuzizhizhou"},{"code":532900,"name":"大理白族自治州","py":"dalibaizuzizhizhou"},{"code":533100,"name":"德宏傣族景颇族自治州","py":"dehongdaizujingpozuzizhizhou"},{"code":533300,"name":"怒江傈僳族自治州","py":"nujianglisuzuzizhizhou"},{"code":533400,"name":"迪庆藏族自治州","py":"diqingzangzuzizhizhou"}]},{"code":540000,"name":"西藏自治区","py":"xizangzizhiqu","city":[{"code":540100,"name":"拉萨市","py":"lasashi"},{"code":542100,"name":"昌都地区","py":"changdoudequ"},{"code":542200,"name":"山南地区","py":"shannandequ"},{"code":542300,"name":"日喀则地区","py":"rikazedequ"},{"code":542400,"name":"那曲地区","py":"naqudequ"},{"code":542500,"name":"阿里地区","py":"alidequ"},{"code":542600,"name":"林芝地区","py":"linzhidequ"}]},{"code":610000,"name":"陕西省","py":"shanxisheng","city":[{"code":610100,"name":"西安市","py":"xianshi"},{"code":610200,"name":"铜川市","py":"tongchuanshi"},{"code":610300,"name":"宝鸡市","py":"baojishi"},{"code":610400,"name":"咸阳市","py":"xianyangshi"},{"code":610500,"name":"渭南市","py":"weinanshi"},{"code":610600,"name":"延安市","py":"yananshi"},{"code":610700,"name":"汉中市","py":"hanzhongshi"},{"code":610800,"name":"榆林市","py":"yulinshi"},{"code":610900,"name":"安康市","py":"ankangshi"},{"code":611000,"name":"商洛市","py":"shangluoshi"}]},{"code":620000,"name":"甘肃省","py":"gansusheng","city":[{"code":620100,"name":"兰州市","py":"lanzhoushi"},{"code":620200,"name":"嘉峪关市","py":"jiayuguanshi"},{"code":620300,"name":"金昌市","py":"jinchangshi"},{"code":620400,"name":"白银市","py":"baiyinshi"},{"code":620500,"name":"天水市","py":"tianshuishi"},{"code":620600,"name":"武威市","py":"wuweishi"},{"code":620700,"name":"张掖市","py":"zhangyeshi"},{"code":620800,"name":"平凉市","py":"pingliangshi"},{"code":620900,"name":"酒泉市","py":"jiuquanshi"},{"code":621000,"name":"庆阳市","py":"qingyangshi"},{"code":621100,"name":"定西市","py":"dingxishi"},{"code":621200,"name":"陇南市","py":"longnanshi"},{"code":622900,"name":"临夏回族自治州","py":"linxiahuizuzizhizhou"},{"code":623000,"name":"甘南藏族自治州","py":"gannanzangzuzizhizhou"}]},{"code":630000,"name":"青海省","py":"qinghaisheng","city":[{"code":630100,"name":"西宁市","py":"xiningshi"},{"code":632100,"name":"海东地区","py":"haidongdequ"},{"code":632200,"name":"海北藏族自治州","py":"haibeizangzuzizhizhou"},{"code":632300,"name":"黄南藏族自治州","py":"huangnanzangzuzizhizhou"},{"code":632500,"name":"海南藏族自治州","py":"hainanzangzuzizhizhou"},{"code":632600,"name":"果洛藏族自治州","py":"guoluozangzuzizhizhou"},{"code":632700,"name":"玉树藏族自治州","py":"yushuzangzuzizhizhou"},{"code":632800,"name":"海西蒙古族藏族自治州","py":"haiximengguzuzangzuzizhizhou"}]},{"code":640000,"name":"宁夏回族自治区","py":"ningxiahuizuzizhiqu","city":[{"code":640100,"name":"银川市","py":"yinchuanshi"},{"code":640200,"name":"石嘴山市","py":"shizuishanshi"},{"code":640300,"name":"吴忠市","py":"wuzhongshi"},{"code":640400,"name":"固原市","py":"guyuanshi"},{"code":640500,"name":"中卫市","py":"zhongweishi"}]},{"code":650000,"name":"新疆维吾尔自治区","py":"xinjiangweiwuerzizhiqu","city":[{"code":650100,"name":"乌鲁木齐市","py":"wulumuqishi"},{"code":650200,"name":"克拉玛依市","py":"kelamayishi"},{"code":652100,"name":"吐鲁番地区","py":"tulufandequ"},{"code":652200,"name":"哈密地区","py":"hamidequ"},{"code":652300,"name":"昌吉回族自治州","py":"changjihuizuzizhizhou"},{"code":652700,"name":"博尔塔拉蒙古自治州","py":"boertalamengguzizhizhou"},{"code":652800,"name":"巴音郭楞蒙古自治州","py":"bayinguolengmengguzizhizhou"},{"code":652900,"name":"阿克苏地区","py":"akesudequ"},{"code":653000,"name":"克孜勒苏柯尔克孜自治州","py":"kezilesukeerkezizizhizhou"},{"code":653100,"name":"喀什地区","py":"kashendequ"},{"code":653200,"name":"和田地区","py":"hetiandequ"},{"code":654000,"name":"伊犁哈萨克自治州","py":"yilihasakezizhizhou"},{"code":654200,"name":"塔城地区","py":"tachengdequ"},{"code":654300,"name":"阿勒泰地区","py":"aletaidequ"},{"code":659000,"name":"自治区直辖县级行政区划","py":"zizhiquzhixiaxianjixingzhengquhua"}]},{"code":710000,"name":"台湾","py":"taiwan","city":[{"code":710100,"name":"台北市","py":"taibeishi"},{"code":710200,"name":"新北市","py":"xinbeishi"},{"code":710300,"name":"台中市","py":"taizhongshi"},{"code":710400,"name":"台南市","py":"tainanshi"},{"code":710500,"name":"高雄市","py":"gaoxiongshi"},{"code":710600,"name":"基隆市","py":"jilongshi"},{"code":710700,"name":"新竹市","py":"xinzhushi"},{"code":710800,"name":"嘉义市","py":"jiayishi"},{"code":710900,"name":"桃园县","py":"taoyuanxian"},{"code":711000,"name":"新竹县","py":"xinzhuxian"},{"code":711100,"name":"苗栗县","py":"miaolixian"},{"code":711200,"name":"彰化县","py":"zhanghuaxian"},{"code":711300,"name":"南投县","py":"nantouxian"},{"code":711400,"name":"云林县","py":"yunlinxian"},{"code":711500,"name":"嘉义县","py":"jiayixian"},{"code":711600,"name":"屏东县","py":"pingdongxian"},{"code":711700,"name":"宜兰县","py":"yilanxian"},{"code":711800,"name":"花莲县","py":"hualianxian"},{"code":711900,"name":"宜兰县","py":"yilanxian"},{"code":712000,"name":"澎湖县","py":"penghuxian"}]},{"code":810000,"name":"香港","py":"xianggang"},{"code":820000,"name":"澳门","py":"aomen"}]};
var map ={
	"110000":["120000","130000"],
	"120000":["110000","130000"],
	"130000":["110000","120000","140000","150000","210000","370000","410000"],
	"140000":["130000","150000","410000","610000"],
	"150000":["130000","140000","210000","220000","230000","610000","620000","640000"],
	"210000":["130000","150000","220000","230000"],
	"220000":["150000","210000","230000"],
	"230000":["150000","220000"],
	"310000":["320000","330000"],
	"320000":["310000","330000","340000","370000"],
	"330000":["310000","320000","340000","350000","360000"],
	"340000":["320000","330000","360000","370000","410000","420000"],
	"350000":["330000","360000","440000"],
	"360000":["330000","340000","350000","420000","430000","440000"],
	"370000":["130000","320000","340000","410000"],
	"410000":["130000","140000","340000","370000"],
	"420000":["340000","360000","410000","430000","500000","520000","610000"],
	"430000":["360000","420000","440000","450000","500000","520000"],
	"440000":["350000","360000","430000","450000","460000","810000","820000"],
	"450000":["430000","440000","520000","530000"],
	"460000":["440000"],
	"500000":["420000","430000","510000","520000","610000"],
	"510000":["500000","520000","530000","540000","610000","620000","630000"],
	"520000":["430000","450000","500000","510000","530000"],
	"530000":["450000","510000","520000","540000"],
	"540000":["510000","530000","630000","650000"],
	"610000":["140000","150000","410000","420000","500000","510000","620000","640000"],
	"620000":["150000","510000","610000","630000","640000","650000"],
	"630000":["510000","540000","620000","650000"],
	"640000":["150000","610000","620000"],
	"650000":["540000","620000","630000"],
	"710000":[],
	"810000":["440000","820000"],
	"820000":["440000","810000"]
};
function paintsvg(svgid,hexcolor){
	document.getElementById(svgid).setAttributeNS(null,"style","fill:"+hexcolor+";fill-opacity:1;stroke:#ffffff;stroke-width:1;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:none");
};

function repaintsvg(){
	for(pcode in myfoot){
		paintsvg("svg"+pcode,myfoot[pcode]);
	}
};

function colorfulprovince(myKeys,i,colortheme){
	var pcolor = colortheme.slice();
	while(pcolor.length != 0){
		var used = false;
		var x  = Math.floor(Math.random()*pcolor.length);
		var c  = pcolor[x];
		for( var j in map[myKeys[i]]){
			if( typeof(myfoot[map[myKeys[i]][j]])== "undefined"){
				continue;
			}
			else if( myfoot[map[myKeys[i]][j]] != c ){
				continue;
			}	
			else{
				used = true;
				pcolor.splice(x,1);
				break;
			}
		}
		if( used == false){
			myfoot[myKeys[i]] = c ;
			if( i+1 == myKeys.length){
				return true;
			}
			else if( colorfulprovince(myKeys,i+1,colortheme) ){
				return true;
			}
			else{
				pcolor.splice(x,1);
			}
		}
	}
	myfoot[myKeys[i]] = "#808080" ;
	return false;
}
function colorfulsvg(colortheme){
	var myKeys = [];
	for(var key in myfoot){
		myfoot[key] = "#808080";
		myKeys.push(key);
	}
	if( myKeys.length != 0){
		colorfulprovince(myKeys,0,colortheme);
		repaintsvg();
	}
};


function paintprovince(pcode){
		var svgid = "svg"+pcode;
		if(!colorful){
			paintsvg(svgid,svgcolor);
			myfoot[pcode] = svgcolor;
		}
		else{
			myfoot[pcode] = "#808080";
			var pcolor = colorthemes[colornum].slice();
			while(pcolor.length!=0){
				var used = false;
				var x  = Math.floor(Math.random()*pcolor.length);
				var c  = pcolor[x];
				for( var j in map[pcode]){
					if( typeof(myfoot[map[pcode][j]])== "undefined"){
						continue;
					}
					else if( myfoot[map[pcode][j]] != c ){
						continue;
					}	
					else{
						used = true;
						pcolor.splice(x,1);
						break;
					}
				}
				if( used == false){
					myfoot[pcode] = c;
					repaintsvg();
					return;
				}
			}
			colorfulsvg(colorthemes[colornum]);
		}

}

$('#mapcolorpicker').ColorPicker({
	color: '#ef0000',
	onShow: function (colpkr) {
		$(colpkr).toggle(100);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).toggle(100);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		colorful = false;
		svgcolor = '#'+hex; 
		$('#mapcolorpicker div').css('backgroundColor', svgcolor);
		$('#mapcolorpicker div').attr('name', svgcolor);
		for(pcode in myfoot){
			myfoot[pcode] = svgcolor;
		}
		repaintsvg();	
	},
	onSubmit: function (hsb, hex, rgb) {
		svgcolor = '#'+hex; 
		$('#mapcolorpicker div').css('backgroundColor', svgcolor);
		$('#mapcolorpicker div').attr('name', svgcolor);
		for(pcode in myfoot){
			myfoot[pcode] = svgcolor;
		}
		repaintsvg();	
	}
});
$('#bgcolorpicker').ColorPicker({
	color: '#8fb9e1',
	onShow: function (colpkr) {
		$(colpkr).toggle(100);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).toggle(100);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		svgbgcolor = '#'+hex;
		$('#bgcolorpicker div').css('backgroundColor',svgbgcolor );
		$('#svgdiv').css('backgroundColor',svgbgcolor );
	},
	onSubmit: function (hsb, hex, rgb) {
	
	}
});


$('#submit').click(function(){
	if($('#msg pre').length != 0){
		msg = $('#msg pre').html();
	}
	else if($('#msg textarea').length != 0){
		msg = $('#msg textarea').val();
	}
	$.post("svg.php",{"footmap":myfoot,"svgbgcolor":svgbgcolor,"msg":msg},function(data){
		mapurl = data;
		$('#step1').hide();
		var wbstatus = $('#weibostatus textarea').val();
		wbstatus += " 已经去过了 "+Object.keys(myfoot).length+" 个省市自治区！";
		$('#weibostatus textarea').val(wbstatus);
		$('#saveas a').attr("href",mapurl);
		$('#mypublisher').fadeIn(300);
		$('#renderedimg').html("<img src='"+mapurl+"'/>");
		//$('#debug').html(data);
	});
});

$('#backstep').click(function(){
	$('#mypublisher').fadeOut(300);
	$('#step1').show();
});

function atfriend(data){
	var wbstatus = $('#weibostatus textarea').val();
	for(var i=0; i < data.length ; i++){
		wbstatus += " @"+data[i].screen_name;
	}
	wbstatus += " ";
	$('#weibostatus textarea').val(wbstatus);
}


WB2.anyWhere(function(W){
	W.widget.selector({
		id : "fselector",
		title: "选择要@的好友",
		callback: atfriend
	});
});

function showtip(tip){
	$('#mytip span').html(tip);
	$('#mytip').fadeIn(300);
	window.setTimeout(function(){
		$('#mytip').fadeOut(300);

	},30000);
};

$('#mytip a').click(function(){
	$('#mytip').fadeOut(300);
});

$('#post').click(function(){
	var wbstatus = $('#weibostatus textarea').val();
		$.post("post.php",{"status":wbstatus,"url":mapurl},function(data){
			if(data == "success"){
				showtip("发布成功 ^_^");
			}
			else{
				showtip("T_T 发生错误")
			}
		});
});


$('#msg').click(function(){
	if($('#msg pre').length != 0){
		var text = $('#msg pre').html();
		$('#msg').html("<textarea rows='8' cols='56'>"+text+"</textarea>");
		$('#msg textarea').keyup(function(){
			var text = $('#msg textarea').val();
			//$('#debug').html(text.length);
		});
		$('#msg textarea').blur(function(){
			var text = $('#msg textarea').val();
			$('#msg').html("<pre>"+text+"</pre>");
		});
	}
});


function setStatus(str){
	$('#status').hide();
	$('#status').html(str);
	$('#status').fadeIn(1000);
}

function checkSpeed(){
		if(movie.running == false && Object.keys(myfoot).length >= 8 && movie.autostart == false ){
			movie.autostart = true;
			ontheroad = $('#movie').html();
			movie.start();
			$('#play').css('background-image','url("imgs/stop.gif")');
			$('#play').attr('title','停下看风景～～');
		}
		var speed =Math.pow(2,(8-Math.floor(Object.keys(myfoot).length/4)));
		if(movie.speed != speed){
			if(movie.running == true){
				movie.setSpeed(speed);
			}
			else{
				movie.speed = speed;
			}

			switch(speed)
			{
				case 256:
					setStatus("在路上。。。");
					break;
				case 128:
					setStatus("学会了凌波微步，走路轻快多了。。。");
					break;
				case 64:
					setStatus("身影模糊地在路上狂奔。。。");
					break;
				case 32:
					setStatus("3秒100km/s，把法拉利远远甩在了后面。。。");
					break;
				case 16:
					setStatus("突破音障，快要飞起来了。。。");
					break;
				case 8:
					break;
				case 4:
					setStatus("脱离了宇宙第一速度，即将飞离地球。。。");
					break;
				case 2:
					break;
				case 1:
					setStatus("正以光速前进。。。已经成为了传说。。。");
					break;
			}

		}
}
function addprovince(pcode){
	if(typeof(myfoot[pcode]) == "undefined"){
		for(var i in china.province){
			if(china.province[i].code == pcode){
				var pname = china.province[i].name;
				break;
			}
		}
		paintprovince(pcode);
		$('#visited').append("<div class='place'>"+pname+"<a href='javascript:void(0)' title='删除' pcode='"+pcode+"'>X</a></div>");
		$('.place a').bind("click",function(){
			var pcode = $(this).attr("pcode");
			myfoot[pcode] = "#808080";
			repaintsvg();
			delete myfoot[pcode];
			checkSpeed();
			$(this).parent().remove();     
		});
		checkSpeed();
	}
}


$('#search').focus(function(){
	if($(this).val()=="搜索地名。。。"){
		$(this).val("");
	}
});
$('#search').blur(function(){
	if($(this).val()==''){
		$(this).val("搜索地名。。。");
	}
});
$('#search').bind("keyup", function(e){
	setTimeout(function(){
		var kc = e.keyCode || e.which;
		//$('#debug').append(kc);
		if( kc != 38 && kc != 40 && kc!= 13){
		ss = $('#search').val(); //search string
		$('#result').empty();
		if(ss.length >= 1){
			var num_result = 0;
			var max_num_result = 6;
			var patt = new RegExp("^"+ss,"i");
			for( i in china.province){
				p = china.province[i];
				if(patt.test(p.name) || patt.test(p.py)){
					$('#result').append("<tr id='"+p.code+"'><td>"+p.name+"</td></tr>");
					num_result++;
				}
				if(num_result == max_num_result){
					break;
				}
			}
			if(num_result != max_num_result){
				for( i in china.province){
					p = china.province[i];
					if(typeof(p.city) == "object"){
						for( j in p.city){
							c = p.city[j];
							if(patt.test(c.name) || patt.test(c.py)){
								$('#result').append("<tr id='"+c.code+"'><td><span>"+p.name+"-</span>"+c.name+"</td></tr>");
								num_result++;
							}
							if(num_result == max_num_result){
								break;
							}
						}
					}
					if(num_result == max_num_result){
								break;
					}
				}
			}
		}
		if(num_result == 0){
			$('#result').html("找不到。。。T_T<br/>请输入拼音或汉字，支持到二级城市")
		}
		$('#result tr').mouseenter(function(){$(this).addClass("select");});
		$('#result tr').mouseleave(function(){$(this).removeClass("select");});
		$('#result tr').bind("click",function(){
			var pcode = Math.floor($(this).attr("id")/10000)*10000;
			var pname = $(this).children().html();
			addprovince(pcode);
			$('#result').empty();
			$('#search').val("");
		});
		}
		else{
			if( kc == 40){
				if($('#result tr.select').length == 0){
					$('#result tr:first').addClass("select");
				}
				else{
					var sel = $('#result tr.select');
					sel.removeClass("select");
					if( $('#result tr:last').index(sel) == 0 )
						$('#result tr:first').addClass("select");
					else	
						sel.next().addClass("select");
				}
			}
			else if( kc == 38){
				if($('#result tr.select').length == 0){
					$('#result tr:last').addClass("select");
				}
				else{
					var sel = $('#result tr.select');
					sel.removeClass("select");
					if( $('#result tr:first').index(sel) == 0 )
						$('#result tr:last').addClass("select");
					else
						sel.prev().addClass("select");
				}
			}
			else if( kc == 13){
				if($('#result tr.select').length == 1){
					var pcode = Math.floor($('#result tr.select').attr("id")/10000)*10000;
					var pname = $("#result .select td").html();
					addprovince(pcode);	
					$('#result').empty();
					$('#search').val("");
				}
			}
		}
	},0);
});



$('svg').children().bind("click",function(e){
	pcode = $(this).attr("id").substr(3);	
	for(var i in china.province){
		if(china.province[i].code == pcode){
			var pname = china.province[i].name;
			break;
		}
	}
	addprovince(pcode);
});




</script>
</html>
