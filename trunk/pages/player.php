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
<h3>Player Info</h3>
<?php
	date_default_timezone_set("America/Chicago"); 	
	if($_GET){
	$query_type = $_GET['query_type'];
	}	
	//check if search button was pressed
	if ($_GET){
		if ($_GET['query'] != ""){ // form was posted and isn't blank
			//Setup vars
			$search_query = $_GET['query'];
			$query_clean = sanitize($search_query);
			
			// Check query type
			if ($query_type == "NA") {
				$info = "<b>Search Type: </b>Name query<br><b>You Searched: </b>".$query_clean."<br><br>";
				// Setup correct mySQL query
				if(($_SESSION[perm][15])==1){
					$sql_query=("Select DISTINCT ip FROM players WHERE name LIKE '%$query_clean%'");
				} else {
					$sql_query=("Select DISTINCT ip FROM players WHERE name LIKE '%$query_clean%' And serverowner='$name'");
				}
			}else if ($query_type == "BZ") {
				$info = "<b>Search Type: </b>BZID query<br><b>You Searched: </b>".$query_clean."<br><br>";
				// Setup correct mySQL query
				if(($_SESSION[perm][15])==1){
					$sql_query=("Select DISTINCT ip FROM players WHERE bzid LIKE '%$query_clean%'");
				} else {
					$sql_query=("Select DISTINCT ip FROM players WHERE bzid LIKE '%$query_clean%' And serverowner='$name'");
				}
			}else if ($query_type == "HO") {
				$info = "<b>Search Type: </b>Host query<br><b>You Searched: </b>".$query_clean."<br><br>";
				// Setup correct mySQL query
				if(($_SESSION[perm][15])==1){
					$sql_query=("Select DISTINCT ip FROM players WHERE host LIKE '%$query_clean%'");
				} else {
					$sql_query=("Select DISTINCT ip FROM players WHERE host LIKE '%$query_clean%' And serverowner='$name'");
				}
			}else if ($query_type == "IP") {
				$info = "<b>Search Type: </b>IP address query<br><b>You Searched: </b>".$query_clean."<br><br>";
				// Setup correct mySQL query
				if(($_SESSION[perm][15])==1){
					$sql_query=("Select DISTINCT ip FROM players WHERE ip LIKE '%$query_clean%'");
				} else {
					$sql_query=("Select DISTINCT ip FROM players WHERE ip LIKE '%$query_clean%' And serverowner='$name'");
			}
			}
			
			// Run query
				$result_array=array();
					$query_result=mysql_query($sql_query);
					while($row = mysql_fetch_assoc($query_result)){ // Results found, add them to result array
						array_push($result_array, array($row['ip']));					
					}
					$name_array = array();
					foreach ($result_array as $result){
						$ip = $result[0];
						$q = "SELECT * FROM players WHERE `ip`='$ip'";
						$query = mysql_query($q);
						while($row = mysql_fetch_assoc($query)){
							array_push($name_array, array($row['ip'], $row['name'], $row['host'], $row['description'], $row['bzid'], $row['time'], ));
						}				
					}							
				// Setup result <table>
				$result=
				"<table width=\"100%\">
				 <tr>
				 <th>IP</th>
				 <th>Username</th>
				 <th>Host</th>
				 <th>BZID</th>
				 <th>Last Seen</th>
				 </tr>";
				// Add items to result <table>
				$num = count($name_array);
				$number_array = array();
				$lastIP = NULL;
				for ( $name = 0; $name < $num; $name++ ){
					if(strstr($name_array[$name][3],"VERIFIED")){ $bg = ' bgcolor=#99FF99'; } else { $bg = ' bgcolor=#CCCCCC'; }
					if(strstr($name_array[$name][3],"ADMIN")){ $bg = ' bgcolor=#FF9933'; }
					$ipdisplay = $name_array[$name][0];
					if($lastIP==$name_array[$name][0]){
						$ipdisplay = NULL;
					}
					if(!$ipdisplay){
					$temp_results=
					"<tr class=\"a\"".$bg.">"."<td style=\"text-align: center;\"></td>".
						"<td style=\"text-align: center;\">"."<a href=\"./index.php?p=player&query_type=NA&query=".$name_array[$name][1]."&search=Search\">".$name_array[$name][1]."</a></td>".
						"<td style=\"text-align: center;\">"."<a href=\"./index.php?p=player&query_type=HO&query=".$name_array[$name][2]."&search=Search\">".$name_array[$name][2]."</a></td>".
						"<td style=\"text-align: center;\">"."<a href=\"./index.php?p=player&query_type=BZ&query=".$name_array[$name][4]."&search=Search\">".$name_array[$name][4]."</a></td>".
						"<td style=\"text-align: center;\">".date("Y-m-d",$name_array[$name][5]).' '.date("h:i:s A",$name_array[$name][5])."</td>".
					"</tr>";
					} else {
					$temp_results=
					"<tr class=\"a\" bgcolor=#99999><td style=\"text-align: center;\">"."<a href=\"./index.php?p=player&query_type=IP&query=".$ipdisplay."&search=Search\">".$ipdisplay."</a></td><td style=\"text-align: center;\"></td><td style=\"text-align: center;\"></td><td style=\"text-align: center;\"></td><td style=\"text-align: center;\"></td></tr>";
					$temp_results .=
					"<tr class=\"a\"".$bg.">"."<td style=\"text-align: center;\"></td>".
						"<td style=\"text-align: center;\">"."<a href=\"./index.php?p=player&query_type=NA&query=".$name_array[$name][1]."&search=Search\">".$name_array[$name][1]."</a></td>".
						"<td style=\"text-align: center;\">"."<a href=\"./index.php?p=player&query_type=HO&query=".$name_array[$name][2]."&search=Search\">".$name_array[$name][2]."</a></td>".
						"<td style=\"text-align: center;\">"."<a href=\"./index.php?p=player&query_type=BZ&query=".$name_array[$name][4]."&search=Search\">".$name_array[$name][4]."</a></td>".
						"<td style=\"text-align: center;\">".date("Y-m-d",$name_array[$name][5]).' '.date("h:i:s A",$name_array[$name][5])."</td>".
					"</tr>";
					}
					$result.=$temp_results;
					$lastIP=$name_array[$name][0];
					}
				
				// Finish result by closing <table>
				$result.="</table>";
			}
		}
		if ($_GET['searchfor'] == "1" && $_GET['query'] == ""){ // form was posted but is blank
			$info = "<b>You need to enter a search string.</b>";
		}
?>

<form method="get" >
	<input type="hidden" name="p" value="player">
	<b>Search for:</b>
	<select name="query_type">
		<option value="NA"<?php if($query_type == "NA") echo " selected"; ?>>Username</option>
		<option value="BZ"<?php if($query_type == "BZ") echo " selected"; ?>>BZID</option>
		<option value="HO"<?php if($query_type == "HO") echo " selected"; ?>>Internet Host</option>
		<option value="IP"<?php if($query_type == "IP") echo " selected"; ?>>IP Address</option>
	</select>
	<input type="text" name="query"/>
	<input type="submit" value="Search" name="search">
</form>
<br>

<?php
	// Show info message
	if(isset($info)) 
	{ 
		echo $info;
	}
	// Show result table
	if(isset($result) || $_GET) 
	{ 
		echo $result;
	} else {
		echo '<h3>Last 20 players</h3>';
		
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
				  <th>Last Seen</th>
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
			}
?>