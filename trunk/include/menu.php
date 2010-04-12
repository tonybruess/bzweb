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
?>
<?php
if($_SESSION['callsign']){
	?>	<ul>
			<li><a href="index.php"<?php if($page=='index') echo ' class=active';?>>Home</a></li>
 			<li><a href="?p=servers"<?php if($page=='servers') echo ' class=active';?>>Servers</a></li>
 			<li><a href="?p=files"<?php if($page=='files') echo ' class=active';?>>Files</a></li>
 			<li><a href="?p=bans"<?php if($page=='bans') echo ' class=active';?>>Bans</a></li>
 			<li><a href="?p=player"<?php if($page=='player') echo ' class=active';?>>Player Info</a></li>
 			<li><a href="?p=reports"<?php if($page=='reports') echo ' class=active';?>>Reports</a></li>
 			<li><a href="?p=logs"<?php if($page=='logs') echo ' class=active';?>>Logs</a></li>
 			<li><a href="?p=logout"<?php if($page=='logout') echo ' class=active';?>>Logout</a></li>
		</ul>

	<?php } else { ?>		
			<ul>
				<li><a href="index.php">Login</a></li>
			</ul>
		<?php
		
		}
		?>
	</div>
</div>
<div id="Container">

	<div id="PageTop"></div>
	
	<div id="PageContent">		
		
