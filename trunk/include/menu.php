<?php
if($_SESSION['callsign']){
	?>	<ul>
			<li><a href="index.php">Home</a></li> 
			<li><a href="?p=servers">Servers</a></li> 
			<li><a href="?p=files">Files</a></li> 
			<li><a href="?p=bans">Bans</a></li> 
			<li><a href="?p=player">Player Info</a></li> 
			<li><a href="?p=reports">Reports</a></li> 
			<li><a href="?p=logs">Logs</a></li> 
			<li><a href="?p=logout">Logout</a></li> 
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
		
