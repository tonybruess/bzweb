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
<h3>Reports</h3>
<?php
date_default_timezone_set("America/Chicago"); 
$id_clean = sanitize($_GET['server']);

// Setup correct mySQL query
if(($_SESSION[perm][16])==1){
	$q = mysql_query("SELECT * FROM servers WHERE enabled='1'");
} else {
	$q = mysql_query("SELECT * FROM servers WHERE enabled='1' And owner='$name'");
}

?>
 <?php
if(!$id_clean){
?>
<form>
Please select a server:
<input type=hidden name="p" value="reports">
<select name="server">
<option value="x">All</option>
<?php
while($qr = mysql_fetch_array($q)){
?>
<option value="<?php echo $qr[0]?>"><?php echo $qr[2]?></option>
<?php
}
?>
</select>
<br>
Order by:<select name="order" onchange="this.form.submit();">
<option value="1"<?php if($_GET['order']=='1') echo " selected";?>>Newest</option>
<option value="2"<?php if($_GET['order']=='2') echo " selected";?>>Oldest</option>
</select>
<br>
<input type=submit value=Go>
</form>
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
} else {
?>
                <form name="form" method="get">
				Server:
				<input type=hidden name="p" value="logs">
				<select name="server" onchange="this.form.submit();">
				<option value="x">All</option>
				<?php
				while($qr = mysql_fetch_array($q)){
				?>
				<option value="<?php echo $qr[0]?>"<?php if($qr[0]==$id_clean) echo ' selected';?>><?php echo $qr[2]?></option>
				<?php
				}
				?>
				</select>
				<br>
                <input type=hidden name="p" value="reports">
                Order by:<select name="order" onchange="this.form.submit();">
                <option value="1"<?php if($_GET['order']=='1') echo " selected";?>>Newest</option>
                <option value="2"<?php if($_GET['order']=='2') echo " selected";?>>Oldest</option>
                </select>
                </form><br>
     <table cellpadding="5">
 	<tr>
 <?php if($id_clean=='x'){
 	echo '<td width="12%">Server</td>';
 }
 ?>
  		<td width="12%">Date</td>
  		<td width="11%">Time</td>
  		<td width="10%">Reporter</td>
  		<td width="60%">Report</td>
	</tr>
                <?php

if($id_clean !=='x'){
if($_SESSION[perm][16]==1){
	$q = 'SELECT * FROM reports WHERE `server`='.$id_clean;
} else {
	$q = 'SELECT * FROM reports WHERE `server`='.$id_clean.' And `serverowner`='.$name;
}
} else {
if($_SESSION['perm'][16]=='1' && $id_clean=='x'){
	$q = 'SELECT * FROM reports';
} else {
	$q = 'SELECT * FROM reports WHERE `serverowner`=\''.$name.'\'';
}
}
if($_GET['order']=='1' || !$_GET['order']){
	$q .= ' ORDER BY time DESC';
} else {
	$q .= ' ORDER BY time ASC';
}
$q = mysql_query($q);
while($report = mysql_fetch_array($q)){
$i_report++;
?>
<tr <?php if ($i_report % 2) {echo 'bgcolor="#99999"';} else {echo 'bgcolor="#CDCDCE"';}?>>
<?php
if($id_clean=='x'){
echo'<td>'.$report['server'].'</td>';
}
?><td><?php echo date("Y-m-d",$report['time']);?></td>
<td><?php echo date("h:i:s A",$report['time']);?></td>
<td><?php echo $report['reporter']?></td>
<td><?php echo $report['report']?></td>
</tr>
<?php
}
?>
</table>
<?php
}
?>