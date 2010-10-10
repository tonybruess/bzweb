<?php
/*
    BZWeb v1.0
    Copyright (c) 2010 Tony Bruess

	BZWeb is an online based tool developed by mrapple which allows multiple users to manage bzfs instances.
	For questions, join ##bzbureau on irc.freenode.net and ask mrapple.

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
include("include/mysql.php");
	if($_POST['updatesettings']){
		$site = $_POST['site'];
		$email = $_POST['email'];
		$bzfs = $_POST['bzfs'];
		$domain1 = $_POST['domain1'];
		$domain2 = $_POST['domain2'];
		$domain3 = $_POST['domain3'];
		$domain4 = $_POST['domain4'];
		$global = $_POST['global'];
		$local = $_POST['local'];
		$q = "UPDATE settings SET `site`='$site', `email`='$email', `bzfs`='$bzfs', `domain1`='$domain1', `domain2`='$domain2', `domain3`='$domain3', `domain4`='$domain4', `global`='$global', `local`='$local'";
		mysql_query($q);
		$err = "Settings updated successfully";
	}
$sitedata = mysql_fetch_array(mysql_query("SELECT * FROM settings"));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="global/style.css">
	<link rel="stylesheet" href="global/servers.css">
	<script type="text/javascript" src="global/servers.js"></script>
	<script type="text/javascript" src="global/Mootools-Core.js"></script>
	<script type="text/javascript" src="global/flags.js"></script>
	<title>BZWeb</title>
</head>

<body>

<noscript><div id="Header"><div id="PageNavigation"><div id="Logo"><h1><?php echo $sitedata['site'] ?></h1><h2>BZFS Administration</h2></div></div></div><div id="Container"><div id="PageContent"><h3>No Javascript Support Detected</h3><p>This website requires JavaScript support. Please enable JavaScript and reload the page.</p></div><div id="PageBottom"><div id="Copyright"><span><?php if(!$_SESSION['callsign'])$name="Guest";echo 'Logged in as '.$name.' from '.$_SERVER['REMOTE_ADDR']?> &copy; 2010 BZExtreme.com</span></div></div></div></noscript>

<div id="body" style="display: none;">
<script>document.getElementById("body").style.display = '';</script>
	<div id="Header">
		<div id="PageNavigation">
			<div id="Logo">
				<h1><?php echo $sitedata['site'] ?></h1> 
				<h2>BZFS Administration</h2> 
			</div>