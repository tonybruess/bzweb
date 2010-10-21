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
<div id="info"><h3>Dashboard</h3>
Use the dashboard to see what's going on. Most recent activity is displayed below</div>
			<h3>Current Up Server(s)</h3>
<?php
				if($_SESSION['perm'][18]){
					$query_result=mysql_query("SELECT * FROM servers WHERE `status`='1'");
				} else {
					$query_result=mysql_query("SELECT * FROM servers WHERE `status`='1' AND owner='$name'");
				}

				$result_array=array();
				while($row = mysql_fetch_assoc($query_result)){ // Results found, add them to result array
					array_push($result_array, array($row['name'],$row['owner'],$row['id'],$row['domain'],$row['p']));
				}
				// Setup result <table>
				$result=
				"<table width=\"100%\">
				 <tr>
				  <th>Server name</th>
				  <th>Where</th>
				  <th>Owner</th>
				  <th>Logs</th>
				  <th>Reports</th>
				 </tr>";
				
				// Add items to result <table>
				$num_results=count($result_array);			
				for ( $row = 0; $row < $num_results; $row++ )
				{				
					$bg = ' bgcolor=#CCCCCC';
					$temp_results=
					"<tr class=\"a\"".$bg.">".
						"<td style=\"text-align: center;\">".$result_array[$row][0]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][3].':'.$result_array[$row][4]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][1]."</td>".
						"<td style=\"text-align: center;\"><a href=\"?p=logs&server=".$result_array[$row][2]."&order=1&admin=1&slash=1&filtered=1&chat=1&join=1&report=1&status=1&player=1\">Logs</a></td>".
						"<td style=\"text-align: center;\"><a href=\"?p=reports&server=".$result_array[$row][2]."\">Reports</a></td>".
						"</tr>";
					
					// Add table row to result
					$result.=$temp_results;
				}
				// Finish result by closing <table>
				$result.="</table>";
					if($result_array){
						echo $result;
					} else {
						echo "<center>No servers currently up</center>";
					}
			?>
			<br>
			<form>
			<input type=hidden name="p" value="servers">
			<input type=submit value="All servers">
			</form>
<?php
if($_SESSION['perm'][28] || $_SESSION['perm'][14]){
?>

			<h3>Most Recent Bans</h3>
<?php
				$sql_query=("SELECT * FROM bans");
				$query_result=mysql_query($sql_query);
				$result_array=array();
				while($row = mysql_fetch_assoc($query_result)){ // Results found, add them to result array
					array_push($result_array, array($row['banner'], $row['ip'], $row['length'], $row['reason'], $row['time'], ));
				}
				// Setup result <table>
				$result=
				"<table width=\"100%\">
				 <tr>
				  <th>Banner</th>
				  <th>Address</th>
				  <th>Length</th>
				  <th>Reason</th>
				  <th width=\"20%\">When</th>
				 </tr>";
				
				// Add items to result <table>
				$num_results=count($result_array);			
				for ( $row = 0; $row < $num_results; $row++ )
				{				
					$bg = ' bgcolor=#CCCCCC';
					$temp_results=
					"<tr class=\"a\"".$bg.">".
						"<td style=\"text-align: center;\">".$result_array[$row][0]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][1]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][2]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][3]."</td>".
						"<td style=\"text-align: center;\">".date("Y-m-d",$result_array[$row][4]).' '.date("h:i:s A",$result_array[$row][4])."</td>".
					"</tr>";
					
					// Add table row to result
					$result.=$temp_results;
				}
				// Finish result by closing <table>
				$result.="</table>";
					echo $result;
			?>
			<br>
			<form>
			<input type=hidden name="p" value="bans">
			<input type=submit value="More...">
			</form>
<?php
}
if($_SESSION['perm'][29] || $_SESSION['perm'][15]){
?>
			<h3>Most Recent Players</h3>
<?php
				if(($_SESSION[perm][15])==1){
					$sql_query=("SELECT * FROM players ORDER BY time DESC LIMIT 20");
				} else {
					$sql_query=("Select * From players Where serverowner='$name' ORDER BY time DESC LIMIT 20");
				}
				$query_result=mysql_query($sql_query);
				$result_array=array();
				while($row = mysql_fetch_assoc($query_result)){ // Results found, add them to result array
					array_push($result_array, array($row['name'], $row['ip'], $row['host'], $row['description'], $row['bzid'], $row['time'], ));
				}
				// Setup result <table>
				$result=
				"<table width=\"100%\">
				 <tr>
				  <th>Username</th>
				  <th>Ip Address</th>
				  <th>Host</th>
				  <th>BZID</th>
				  <th width=\"20%\">Last Seen</th>
				 </tr>";
				
				// Add items to result <table>
				$num_results=count($result_array);			
				for ( $row = 0; $row < $num_results; $row++ )
				{				
					if(strstr($result_array[$row][3],"VERIFIED")){ $bg = ' bgcolor=#99FF99'; } else { $bg = ' bgcolor=#CCCCCC'; }
					if(strstr($result_array[$row][3],"ADMIN")){ $bg = ' bgcolor=#FF9933'; }
					$temp_results=
					"<tr class=\"a\"".$bg.">".
						"<td style=\"text-align: center;\">".$result_array[$row][0]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][1]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][2]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][4]."</td>".
						"<td style=\"text-align: center;\">".date("Y-m-d",$result_array[$row][5]).' '.date("h:i:s A",$result_array[$row][5])."</td>".
					"</tr>";
					
					// Add table row to result
					$result.=$temp_results;
				}
				// Finish result by closing <table>
				$result.="</table>";
					echo $result;
			?>
			<br>
			<form>
			<input type=hidden name="p" value="player">
			<input type=submit value="More...">
			</form>
<?php
}
if($_SESSION['perm'][31] || $_SESSION['perm'][16]){
?>
<h3>Most Recent Reports</h3>
<?php
	if($_SESSION['perm'][16]==1){
		$q = "SELECT * FROM reports ORDER BY time DESC LIMIT 20";
	} else {
		$q = "SELECT * FROM reports WHERE serverowner='$name' ORDER BY time DESC LIMIT 20";
	}
				$query_result=mysql_query($q);
				$result_array=array();
				while($row = mysql_fetch_assoc($query_result)){ // Results found, add them to result array
					array_push($result_array, array($row['name'], $row['server'], $row['reporter'], $row['report'], $row['time']));
				}
				// Setup result <table>
				$result=
				"<table width=\"100%\">
				 <tr>
				  <th width=\"20%\">When</th>
				  <th width=\"15%\">Server</th>
				  <th width=\"10%\">Owner</th>
				  <th width=\"10%\">Reporter</th>
				  <th>Report</th>
				 </tr>";
				
				// Add items to result <table>
				$num_results=count($result_array);			
				for ( $row = 0; $row < $num_results; $row++ )
				{				
					$serverdetails = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id=".$result_array[$row][1]));
					if(strstr($result_array[$row][3],"VERIFIED")){ $bg = ' bgcolor=#99FF99'; } else { $bg = ' bgcolor=#CCCCCC'; }
					if(strstr($result_array[$row][3],"ADMIN")){ $bg = ' bgcolor=#FF9933'; }
					$temp_results=
					"<tr class=\"a\"".$bg.">".
						"<td style=\"text-align: center;\">".date("Y-m-d",$result_array[$row][4]).' '.date("h:i:s A",$result_array[$row][4])."</td>".
						"<td style=\"text-align: center;\">".$serverdetails[2]."</td>".
						"<td style=\"text-align: center;\">".$serverdetails[3]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][2]."</td>".
						"<td style=\"text-align: center;\">".$result_array[$row][3]."</td>".
					"</tr>";
					
					// Add table row to result
					$result.=$temp_results;
				}
				// Finish result by closing <table>
				$result.="</table>";
					echo $result;
			?>
			<br>
			<form>
			<input type=hidden name="p" value="reports">
			<input type=submit value="More...">
			</form>
			<?php
}
?>