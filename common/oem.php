<?php
function get_web_title() 
{
	$file = '/mnt/web_title';

	if(file_exists($file)) {
		return file_get_contents('/mnt/web_title');
	}
	return LocalUtil::getCommonResource('web_title', 1);
}
?>
