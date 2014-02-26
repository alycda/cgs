<?php
date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);

function clean_url($url){
	$url = strtolower(trim($url));
	$remove_chars  = array( "([\40])" , "([^a-zA-Z0-9-])", "(-{2,})" );
	$replace_with = array("-", "", "-");
	return preg_replace($remove_chars, $replace_with, $url);
}
?>