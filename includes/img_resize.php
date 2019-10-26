<?php
//Require Class
require_once("PThumb.php");

// $image_url = "../../../../wp-content/uploads/wpmarks/".$_GET["url"];

// auto detect the path since not all setups are alike
$paths = array(
		"../..",
		"../../..",
		"../../../..",
		"../../../../..",
		"../../../../../..",
		"../../../../../../.."
	);
	
foreach($paths as $path) {
	$cpath = $path . '/wp-content/uploads/wpmarks/' . $_GET["url"];
	if(@file_exists($cpath)) {
		$image_url = $cpath;
	}
}

class pthumb_example extends PThumb{
	var $use_cache = true;
	var $cache_dir = "cache/";	//Make sure to include trailing slash!
	var $error_mode = 2;
	
	function pthumb_example(){
		$this -> PThumb();
	}

    function display_x(){
    }
}

$thumbnail = new pthumb_example;

	if (!isset($image_url) || !isset($_GET["width"]) || !isset($_GET["height"])){
		$thumbnail -> display_x();
	}
	else{
		if (!$thumbnail -> fit_thumbnail($image_url,$_GET["width"],$_GET["height"])){
			$thumbnail -> display_x();
		}
	}

if ($thumbnail -> isError()){
    $thumbnail -> display_x();
}
?>
