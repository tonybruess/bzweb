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

// This file defines some functions for preventing exploits.

// Prevents directoy traversals (http://en.wikipedia.org/wiki/Directory_traversal)
// Should be run on every variable used in a file path.
function CleanFilePath($path)
{
	return preg_replace("/[^a-zA-Z0-9 -]/", "", $path);
}

function sanitize($str)
{
	if (function_exists( "mysql_real_escape_string" ))
	{
		// If PHP version > 4.3.0
		$str = mysql_real_escape_string($str) ;
	}
	else
	{
		// If PHP version < 4.3.0
 		die("Upgrade PHP to atleast version 4.3.0");
	}
	
	return $str;
}

?>