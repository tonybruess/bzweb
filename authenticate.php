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

require('./config.php');
require('./include/mysql.php');
require('./include/session.php');
require('./include/checktoken.php');

if(!$_GET['token'] || !$_GET['username']){
	die("Incorrect information submitted.");
}
else
{	
	$result = validate_token($_GET['token'], $_GET['username']);
	$users = mysql_query("SELECT * FROM users WHERE `name`='".$result['username']."'");
	$userar = mysql_fetch_array($users);
	
	if(count($userar['name']) > 0) { 
		$ts = time();
		$_SESSION['callsign'] = $userar['name'];
		$_SESSION['pass'] = $_GET['token'];
		$_SESSION['id'] = $userar['id'];
		mysql_query("UPDATE users SET `last login`='$ts' WHERE `name`='".$_SESSION['callsign']."'");
		header('Location: index.php');
	}
	else
	{
		header('Location: index.php?p=error&error=4');
	}
}
?>