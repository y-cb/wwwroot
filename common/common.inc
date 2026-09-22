<?php
$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];

define('IN_HOVERUI', TRUE);
define('S_ROOT', substr(dirname(__FILE__), 0, -7));

require_once S_ROOT.'/common/xml_public.php';

$timestamp = time();
?>
