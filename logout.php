<?php
session_start();
$chk = @md5(
$_SERVER[ 'HTTP_ACCEPT_CHARSET' ] .
$_SERVER[ 'HTTP_ACCEPT_ENCODING' ] .
$_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] .
$_SERVER[ 'HTTP_USER_AGENT' ]);

if (empty($_SESSION))
	$_SESSION['key'] = $chk;
else if ($_SESSION['key'] != $chk)
	session_destroy();


session_unset();  // remove all session variables
session_destroy();
header("Location:welcome.php");
?>
