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

if(!file_exists('./config.php'))
{
	require_once('./include/session.php');
	require_once('./include/install.php');
	require_once('./include/footer.php');
	die();
}

require('./config.php');
require('./include/session.php');
require('./include/mysql.php');
require('./include/security.php');

foreach ($_POST as $key => $value)
	$_POST[$key] = sanitize($value); 
foreach ($_GET as $key => $value)
	$_GET[$key] = sanitize($value); 
	
$name = $_SESSION['callsign'];
$authPage = urlencode('http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/authenticate.php?token=%TOKEN%&username=%USERNAME%');
$page = CleanFilePath($_GET['p']);

if(!$page)
	$page = 'index';

if(file_exists('./include/update.php'))
{
	require_once('./include/update.php');
	require_once('./include/footer.php');
	die();
}

require_once('./include/header.php');
require_once('./include/menu.php');	

if(!isset($_SESSION['callsign']) && $_GET['p'] != 'error')
{
	require_once('./pages/login.php');
}
else
{	
	if(file_exists("./pages/$page.php"))
	{
		require_once("./pages/$page.php");
	}
	else
	{
		require_once("./pages/index.php");
	}
}
require_once("./include/footer.php");
?>