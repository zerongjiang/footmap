<?php	
	session_start();	

	$uid = $_SESSION['oauth2']["user_id"];

	if($_POST){
		//var_dump($_POST);
		if(isset($_POST["footmap"])){
			$footmap = $_POST["footmap"];
		}
		else{
			$footmap = array();
		}
		$svgbgcolor = $_POST["svgbgcolor"];
		$msg	    = $_POST["msg"];



	function renderMsg($msg,$x,$y,$angle,$im){
		$im_msg = new ImagickDraw();
		$im_msg->setFont( 'res/STHeiti-Light.ttc');
		$im_msg->setFontSize( 20 );
		$im_msg->setStrokeAntialias(true);
		$im_msg->setTextAntialias(true);
		$im_msg->setFillColor('black');

		return $im->annotateImage($im_msg, $x, $y, $angle, $msg);
	}

	function renderShadow($im){
		$shadow = $im->clone();
		$shadow->setImageBackgroundColor( new ImagickPixel( 'black' ) );
		$shadow->shadowImage( 80, 2, 0, 0 );
		return $shadow;
		$im->compositeImage($shadow, Imagick::COMPOSITE_DSTOVER,-4 ,-4 );
		//$shadow->compositeImage($im, Imagick::COMPOSITE_OVER,-3 ,-3 );
	}
	
	
	
	function renderSVG($file,$footmap){
		$svgfile = file_get_contents($file);
			//var_dump($footmap);	
			if(!empty($footmap)){
			foreach ($footmap as $pcode => $color) {
					$s1 = "id=\"svg".$pcode."\" style=\"fill:#808080";
					$s2 = "id=\"svg".$pcode."\" style=\"fill:".$color;
					$svgfile = str_replace($s1,$s2,$svgfile);
			}}
		$imsvg	 = new Imagick();
		$imsvg->setFont('res/STHeiti-Light.ttc');
		$imsvg->setBackgroundColor(new ImagickPixel('transparent'));
		$imsvg->readImageBlob($svgfile);
		return $imsvg;
	}


	$imborder = new Imagick("res/previewbg.jpg");

	$bg = new Imagick();
	$bg->newImage(600,800,"#ffffff");


	//add background
	$svgbg = new Imagick();
	$svgbg->newImage(600,600,$svgbgcolor);
	$bg->compositeImage( $svgbg, Imagick::COMPOSITE_DEFAULT, 0, 0);

	//add svg
	$imsvg = renderSVG("res/china.svg",$footmap);
	//$imsvg->setImageFormat('png');
	//$imsvg->writeImage("footmap/china.png");

	//add shadow
	//$shadow = renderShadow($imsvg);
	$shadow = new Imagick("res/svgshadow.png");

	$bg->compositeImage( $shadow, Imagick::COMPOSITE_DEFAULT, 0, 0 );
	$bg->compositeImage( $imsvg, Imagick::COMPOSITE_DEFAULT, 0, 55 );
	
	//add msg	
	renderMsg($msg,20,636,0,$bg);

        $imborder->compositeImage($bg,Imagick::COMPOSITE_DEFAULT,10,6);
        $imborder->setImageFormat( 'png' );

	$filepath = "footmap/$uid";
        $filename = "$filepath/".time().".png";
        if(!file_exists($filepath)){
                mkdir($filepath,0755,true);
        }
        $imborder->writeImage("$filename");
        echo $filename;
	}
?>
