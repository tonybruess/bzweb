<?php
require('./include/security.php');
include('./include/session.php');
$name = $_SESSION['callsign'];
if(!file_exists("./include/mysql.php"))
{
	include_once("./include/install.php");
	die();
}
if(file_exists("./include/update.php"))
{
	include_once("./include/update.php");
	die();
}

if(!isset($_SESSION['callsign']) && isset($_GET['p']) && $_GET['p'] != 'error')
{
	include_once("./include/header.php");
	include_once("./include/menu.php");
	
	?>
		<h3>Please login</h3>
		<p>
			Before accessing this page you must <a href="http://my.bzflag.org/weblogin.php?url=http://<?php echo $_SERVER['HTTP_HOST']; ?>%2Fauthenticate.php%3Ftoken%3D%25TOKEN%25%26username%3D%25USERNAME%25">login.</a>
		</p>
	<?php
	
	include_once("./include/footer.php");
}
else
{
	include_once("./include/header.php");
	
	if(!isset($_GET['p']))
		$_GET['p'] = 'index';
		
	$page = CleanFilePath($_GET['p']);
	if($page == true && file_exists("./pages/$page.pag"))
	{
		include_once("./include/menu.php");
		require_once("./pages/$page.pag");
	}
	else
	{
		$page = 'index';
		include_once("./include/menu.php");
		include_once("./pages/index.pag");
	}
	include_once("./include/footer.php");
}
?>