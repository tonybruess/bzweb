<?php
if($_SESSION['callsign']){
	?>	<div id="menu">
			<ul>
				<li><a href="index.php"<?php if($page=='index') echo ' class=active';?>>Home</a></li>
				<li><a href="?p=servers"<?php if($page=='servers') echo ' class=active';?>>Servers</a></li>
				<li><a href="?p=files"<?php if($page=='files') echo ' class=active';?>>Files</a></li>
				<li><a href="?p=bans"<?php if($page=='bans') echo ' class=active';?>>Bans</a></li>
				<li><a href="?p=player"<?php if($page=='player') echo ' class=active';?>>Player Info</a></li>
				<li><a href="?p=reports"<?php if($page=='reports') echo ' class=active';?>>Reports</a></li>
				<li><a href="?p=logs"<?php if($page=='logs') echo ' class=active';?>>Logs</a></li>
				<li><a href="?p=logout"<?php if($page=='logout') echo ' class=active';?>>Logout</a></li>
			</ul>
		</div>
	<?php } else { ?>		
	<div id="menu">
			<ul>
				<li><a href="index.php">Login</a></li>
			</ul>
		</div>
		<?php
		
		}
		?>
	</div>
</div>
<div id="main">
	<div id="main_inner" class="fixed">
		<div id="content">
			<div id="body">
