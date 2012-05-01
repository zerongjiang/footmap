<?php
session_start();

include_once( 'weibo/config.php' );
include_once( 'weibo/saetv2.ex.class.php' );

if(!empty($_SESSION['oauth2']["user_id"])){
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$_SESSION['oauth2']['oauth_token'] ,'' );
	if(isset($_POST["status"]) && isset($_POST["url"])){
		$status = $_POST["status"]."#总有一天要环游世界#来看看你去过了哪些地方～ http://apps.weibo.com/travelworld";
		$url    = $_POST["url"];
		$status = urlencode($status);
		$rtn = $c->upload($status,$url);
		if(array_key_exists("error_code",$rtn)){
			echo $rtn['error_code'];
		}
		else if(array_key_exists("created_at",$rtn)){
			echo "success";
		}
	}
}


?>
