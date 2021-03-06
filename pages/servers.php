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
<h3>Servers</h3>
<?php
/* Check for servers that are running */
chdir("servers/");
$dirs = glob("*");
exec("pidof bzfs", $pid);
foreach($dirs as $dir)
{
	if(file_exists("$dir/bzfs.pid"))
	{
		$pidc = file_get_contents("$dir/bzfs.pid");
		if(strstr($pid[0],$pidc))
			mysql_query("UPDATE servers SET `status`='1' WHERE `id`='$dir'");
		else
			mysql_query("UPDATE servers SET `status`='0' WHERE `id`='$dir'");
	}
}

chdir("../");

/* Adding a new server */

if ($_POST['createserver'] && $_POST['newserver'])
{
	$newserver = $_POST['newserver'];
	$group = $_POST['group'];
	$q = mysql_query("SELECT * FROM groups WHERE id='$group'");
	$e = mysql_query("SELECT name FROM servers WHERE name='$newserver' AND master='$group'");
	$g_ar = mysql_fetch_array($q);
	$e_ar = mysql_fetch_array($e);
	if($e_ar[0] == "$newserver")
		echo "Server Already Exists";
	elseif ($g_ar[2] == $name || $_SESSION['perm'][4])
	{
		if(!$_SESSION['perm'][14])
				mysql_query("INSERT INTO servers (`master`, `name`, `owner`, `enabled`) VALUES ('$g_ar[0]', '$newserver', '$name', '1')");
			else
				mysql_query("INSERT INTO servers (`master`, `name`, `owner`, `enabled`) VALUES ('$g_ar[0]', '$newserver', '$g_ar[2]', '1')");
			$a = mysql_query("SELECT id FROM servers WHERE `master` = '$g_ar[0]' AND `name` = '$newserver'");
			$a_ar = mysql_fetch_array($a);
			mysql_query("CREATE TABLE ".$a_ar[0]."serverlogs ( server INT, time TEXT, type TEXT, data TEXT)");
			mkdir("servers/$a_ar[0]/");
			chmod("servers/$a_ar[0]/", 0777);
			$pidCreate = "servers/$a_ar[0]/bzfs.pid";
			$pidHandle = fopen($pidCreate, 'w') or die("Can't create pid");
			fwrite($pidHandle,'9999999999');
			fclose($pidHandle);
			chmod("servers/$a_ar[0]/bzfs.pid", 0777);
			echo "Server Created Successfully";
		}
		else
			echo "No permission";
}

/* Adding a new group */

if ($_POST['creategroup'] && $_POST['newgroup'])
{
	$newgroup = $_POST['newgroup'];
	$q = mysql_query("SELECT * FROM groups WHERE name='$newgroup'");
	$g_ar = mysql_fetch_array($q);
	if($g_ar[0])
			echo "Group Already Exists";
	else
	{
		if(!$_POST['underuser'])
		{
			mysql_query("INSERT INTO groups (`name`, `owner`, `enabled`) VALUES ('$newgroup', '".$_SESSION['callsign']."', 1)");
			echo "Group Created Successfully!";
		}
		if($_POST['underuser'] && $_SESSION['perm'][8])
		{
			$underuser = $_POST['underuser'];
			mysql_query("INSERT INTO groups (`name`, `owner`, `status`, `enabled`) VALUES ('$newgroup', '$underuser', 0, 1)");
			echo "Group Created Successfully for user ".$_POST['underuser']."!";
		}
		else
			echo "No permission";
	}
}

/* Deleting a server */

if ($_POST['deleteserver'])
{
	$deleteserver = $_POST['server'];
	$master = $_POST['master'];
	$g = mysql_query("SELECT * FROM groups WHERE `owner`='$name' AND `id`='$master'");
	$e = mysql_query("SELECT * FROM servers WHERE `master`='$master' AND `id`='$deleteserver'");
	$g_ar = mysql_fetch_array($g);
	$e_ar = mysql_fetch_array($e);
	if ($name == $g_ar[2] && $e_ar[1]==$master || $_SESSION['perm'][6])
	{
		mysql_query("UPDATE servers SET `enabled`='0' WHERE `id`='$deleteserver'");
		echo "Server Deleted Successfully";
	}
	else
		echo "No Permission";	
}

/* Deleting a group */

if ($_POST['deletegroup']){
	$deletegroup = $_POST['group'];
	$g = mysql_query("SELECT * FROM groups WHERE `owner`='$name' AND `id`='$deletegroup'");
	$g_ar = mysql_fetch_array($g);
	if ($name == $g_ar[2] || $_SESSION['perm'][10])
	{
		mysql_query("DELETE FROM groups WHERE `id`='$deletegroup'");
		mysql_query("UPDATE servers SET `enabled`='0' WHERE `master`='$deletegroup'");
		echo "Group Deleted Successfully";
	}
	else
		echo "No Permission";
}
?>
<div id="info"><b>Click a folder to hide its contents or click a server to edit it</b><br></div>
<table width="100%">
<tr><th>Server</th><th>Port</th><th>Status</th><th>Owner</th><th>Logs</th><th>Reports</th><th>Delete</th></tr>
<?php
$i_group = 0;
if($_SESSION['perm'][18])
	$group = mysql_query("SELECT * FROM groups WHERE `enabled`='1'");
else
	$group = mysql_query("SELECT * FROM groups WHERE `enabled`='1' AND owner='$name'");
while ($g_row = mysql_fetch_array($group))
{
	$i_groups++;
	echo '<tr id="'.$i_groups.'" class="a"><td id="p1"><div id="p2" class="tier1"><a id="p3" onclick="toggleRows(this)" class="folder"></a>'.$g_row[1].'</div></td><td><center>--</center></td><td><center>--</center></td><td><center>'.$g_row[2].'</center></td><td><center>--</center></td><td><center>--</center></td>';
	if ($name == $g_row[2] || $_SESSION['perm'][10])
		echo '<td><center><form method="post"><input type="submit" value="Delete"><input type="hidden" name="deletegroup" value="1" ><input type="hidden" name="group" value="'.$g_row[0].'"></form>';
	else
	  	echo '<td><center>--';
	echo '</center></td></tr>';
	$server = mysql_query("SELECT * FROM servers WHERE master='$g_row[0]' AND `enabled`='1'");
	while ($s_row = mysql_fetch_array($server))
	{
		$i_servers++;
		echo '  <tr id="'.$i_groups.'-'.$i_servers.'" class="a"><td><div class="tier2">';
		if($name == $g_row[2] && $_SESSION['perm'][21] || $_SESSION['perm'][22])
			echo '<a href="?p=edit&mode=conf&group='.$g_row[0].'&server='.$s_row[0].'"><div class="doc"></div>'.$s_row[2].'</a></div></td>';
		else
			echo '<a><div class="doc"></div></a>'.$s_row[2].'</div></td>';
		echo '<td><center>'; if($s_row['p']){ echo $s_row['p']; }else{ echo '--'; } echo '</center></td>';
		if($s_row[4]==1)
		{
  	  		if($name == $g_row[2] && $_SESSION['perm'][19] || $_SESSION['perm'][20])
  	  			echo "<td><center><a class=\"tooltip\" href=\"?p=exec&mode=stop&g=$g_row[0]&s=$s_row[0]\">Up<span>Click to Stop</span></center></a></td>";
  			else
  				echo "<td><center>Up</center></td>";
		}
		else
		{
  	  		if($name == $g_row[2] && $_SESSION['perm'][19] || $_SESSION['perm'][20])
  	  			echo "<td><center><a class=\"tooltip\" href=\"?p=exec&mode=start&g=$g_row[0]&s=$s_row[0]\">Down<span>Click to Start</span></center></a></td>";
			else
				echo "<td><center>Down</center></td>";
  		}
		echo '<td><center>--</center></td><td>';
		if($_SESSION['perm'][17]=='1' || $name == $g_row[2])
			echo'<center><a href="?p=logs&server='.$s_row[0].'&admin=1&slash=1&filtered=1&chat=1&join=1&report=1&status=1&player=1">Logs</a></center>';
		else
			echo '<center>--</center>';
  		echo'</td><td><center><a href="?p=reports&server='.$s_row[0].'">Reports</a></center></td><td>';
  		if ($name == $g_row[2] || $_SESSION['perm'][10])
			echo '<center><form method="post"><input type="submit" value="Delete"><input type="hidden" name="deleteserver" value="1" ><input type="hidden" name="server" value="'.$s_row[0].'"><input type="hidden" name="master" value="'.$g_row[0].'"></form></center></td></tr>';
	}
}
?>
</table>
<br>
<?php
if($_SESSION['perm'][3]=='1'||$_SESSION['perm'][4]=='1'){
	if($_SESSION['perm'][4]=='1')
		$servera = mysql_query("SELECT * FROM groups WHERE enabled='1'");
	else
		$servera = mysql_query("SELECT * FROM groups WHERE owner='$name' AND enabled='1'");
?>
<form method="post">
<b>Add a server to group: </b><select name="group">
<?php
while ($sa_row = mysql_fetch_array($servera))
	echo '<option value="'.$sa_row[0].'">'.$sa_row[1].'</option>';
 ?>
 </select> <b>Give it the name:</b>
 <input type="text" name="newserver"> <input type="submit" value="Create it">
 <input type="hidden" name="createserver" value="1" >
</form>
<br>
<?php
}
if($_SESSION['perm'][7]=='1'||$_SESSION['perm'][8]=='1'){
?><form method="post">
<b>Create a group: </b>
<input type="text" name="newgroup">
<?php if($_SESSION['perm'][8]=='1'){?>
<b>For user: </b>
<select name="underuser">
<?php
$userq = mysql_query("SELECT * FROM users");
while ($users = mysql_fetch_array($userq))
	echo '<option value="'.$users[1].'">'.$users[1].'</option>';
 ?></select>
 <?php
}
?>
 <input type="submit" value="Create it">
<input type="hidden" name="creategroup" value="1" >
</form>
<?php
}
?>
<div id="info2"><br><small>NOTE: Servers can be recovered, Groups can not.</small></div>