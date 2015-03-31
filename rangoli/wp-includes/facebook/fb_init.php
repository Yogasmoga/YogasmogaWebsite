<?php
	require_once( ABSPATH . WPINC . '/facebook/facebook.php' );
	$appID='232593916790647';
	$appSecret='92bb50193bf6602df4107ae4e0b60b35';

	$facebook = new Facebook(array(
	  'appId'  => $appID,
	  'secret' => $appSecret,
	));

	if($_SERVER['HTTP_HOST']=='localhost'){
	$base_url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}else{
	$base_url='http://'.$_SERVER['HTTP_HOST'];	
	}

?>