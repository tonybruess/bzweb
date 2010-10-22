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
if($_SESSION['callsign']){
?>

		<ul>
			<?php   if($_SESSION['perm']['2']){?><li><a href="index.php?p=admin"<?php if($page=='admin') echo ' class=active';?>>Admin</a></li>
			<?php } ?><li><a href="index.php"<?php if($page=='index') echo ' class=active';?>>Home</a></li>
 			<li><a href="index.php?p=servers"<?php if($page=='servers') echo ' class=active';?>>Servers</a></li>
 			<li><a href="index.php?p=files"<?php if($page=='files') echo ' class=active';?>>Files</a></li>
 			<?php   if($_SESSION['perm'][28] || $_SESSION['perm'][14]){?><li><a href="index.php?p=bans"<?php if($page=='bans') echo ' class=active';?>>Bans</a></li>
 			<?php } if($_SESSION['perm'][29] || $_SESSION['perm'][15]){?><li><a href="index.php?p=player"<?php if($page=='player') echo ' class=active';?>>PlayerInfo</a></li>
 			<?php } if($_SESSION['perm'][31] || $_SESSION['perm'][16]){?><li><a href="index.php?p=reports"<?php if($page=='reports') echo ' class=active';?>>Reports</a></li>
 			<?php } if($_SESSION['perm'][30] || $_SESSION['perm'][17]){?><li><a href="index.php?p=logs"<?php if($page=='logs') echo ' class=active';?>>Logs</a></li>
 			<?php } ?><li><a href="index.php?p=feedback"<?php if($page=='feedback') echo ' class=active';?>>Feedback</a>
			<li><a href="index.php?p=logout"<?php if($page=='logout') echo ' class=active';?>>Logout</a></li>
 		</ul>
	<?php } else { ?>		
			<ul>
				<li><a href='index.php'>Login</a></li>
			</ul>
	<?php } ?>
	</div>
</div>
<div id="Container">
	
	<div id="PageContent">		