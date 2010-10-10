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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="global/style.css">
	<link rel="stylesheet" href="global/servers.css">
	<script type="text/javascript" src="global/global.js"></script>
	<script type="text/javascript" src="global/servers.js"></script>
	<title>BZWeb - Update</title>
</head>


<body onload="collapseAllRows();">
<div id="Header">
	<div id="PageNavigation">
		<div id="Logo">
			<h1>BZWeb</h1> 
			<h2>BZFS Administration</h2> 
		</div>
			<ul>
				<li><a href="index.php">Update</a></li>
			</ul>
	</div>
</div>
<div id="Container">
	
	<div id="PageContent">
	<h3>Performing updates...</h3>
	<?php if(!$_POST){ ?>
	<p>To perform the necessary updates, click continue</p>
	<form method="POST">
	<input type="submit" name="2" value="Continue">
	</form>
<?php
	} else {
		$ts = time();
		rename("include/update.php","include/update-done-$ts.php");
		//Perform any file renaminings, mysql updates, etc here!
		?>
		Done!
	<form method="POST">
	<input type="submit" name="3" value="Continue">
	</form>
		<?php
	}
include_once("include/footer.php");
?>