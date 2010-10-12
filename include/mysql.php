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

mysql_connect(SQL_SERVER,SQL_USER,SQL_PASS) or die("Error: ".mysql_error());
mysql_select_db(SQL_DB) or die("Error: ".mysql_error());

if($_SESSION['callsign'])
{
	$userdata = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE `name`='".$_SESSION['callsign']."'"));	 
	$rolesdata = mysql_fetch_array(mysql_query("SELECT * FROM roles WHERE `id`=".$userdata['permissions'].""));
	$perm = str_split($rolesdata['permissions']);
	if($perm[1]=='0')
	{
		$_SESSION = array();
		session_destroy();
		header('Location: ?p=error&error=3');
	}
	else
	{
		$i = 0;
		while($i < 35)
		{
			$_SESSION['perm'][$i] = $perm[$i];
			$i++;
		}
		$i = 0;
	}
}
?>