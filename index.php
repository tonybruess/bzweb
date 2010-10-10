<?php
/*
    BZWeb v1.0
    Copyright (c) 2010 Tony Bruess

	BZWeb is an online based tool developed by mrapple which allows multiple users to manage bzfs instances.
	For questions, join #bzextreme on irc.freenode.net and ask mrapple.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public
    License along with this program.  If not, see
    <http://www.gnu.org/licenses/>.
*/
require('./include/security.php');
include('./include/session.php');

$name = $_SESSION['callsign'];
$authPage = urlencode('http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/authenticate.php?token=%TOKEN%&username=%USERNAME%');

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

if(!isset($_SESSION['callsign']) && $_GET['p'] != 'error')
{
	include_once("./include/header.php");
	include_once("./include/menu.php");
	
	?>
		<h3>Please login</h3>
		<p>
			Before accessing this page you must <a href='http://my.bzflag.org/weblogin.php?url=<?php echo $authPage; ?>'>login.</a>
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