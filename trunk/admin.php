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
	session_start(); 
	header("Cache-control: private");
	$page = $_SERVER['PHP_SELF'];
	include_once("include/session.php");
	include_once("include/header.php");
	include_once("include/menu.php");
if($_SESSION['callsign']!=='mrapple'){
} else {
	?>
<h3>Admin CP</h3>
<?php
if(!$_GET['op']){
	echo "Please select an option below<br><br>";
}?>
<fieldset>
<legend><a href="?op=config">Site Configuration</a></legend>
<?php if($_GET['op']=='config'){
		$set_data = mysql_fetch_array(mysql_query("SELECT * FROM settings"));
		echo $err;
?>
<form method="post">
Site Name: <input type="text" name="site" value="<?php echo $set_data[0]?>">
<br>
Admin Email: <input type="text" name="email" value="<?php echo $set_data[1]?>">
<br>
BZFS Executable: <input type="text" name="bzfs" value="<?php echo $set_data[2]?>">
<br>
Domain: <input type="text" name="domain1" value="<?php echo $set_data[3]?>">
<br>
Global auth: <input name="global" type="checkbox" value="1" <?php if($set_data[7]=='1') echo ' checked';?>>
<br>
Local auth: <input name="local" type="checkbox" value="1"<?php if($set_data[8]=='1') echo ' checked';?>>
<br>
<input type="hidden" name="updatesettings" value="1">
<input type="submit" value="Save">
</form>
<?php
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?op=group">Permission Roles</a></legend>
<?php if($_GET['op']=='group' && !$_GET['mode']){
	$q = mysql_query("SELECT * FROM roles");
?>
			<table>
				<tr>
				  <th width="50%">Name</th>
				  <th width="20%">Edit</th>
				  <th width="20%">Delete</th>
				 </tr>
				 <?php while($roles = mysql_fetch_array($q)){ ?>
				 <tr class="a" bgcolor=#CCCCCC>
					<td><?php echo $roles['name']?></td>
				 	<td><a href="admin.php?op=group&mode=edit&role=<?php echo $roles['id'] ?>">Edit</a></td>
				 	<td>Delete</td>
				 </tr>
				 <?php
				 }
				 ?>
			</table><?php
			
}
if($_GET['mode']=='edit'){
	if($_REQUEST['save']){
	$_POST[0] = 1;
	if(!$_POST[1]) $_POST[1] = 0;
	if(!$_POST[2]) $_POST[2] = 0;
	if(!$_POST[3]) $_POST[3] = 0;
	if(!$_POST[4]) $_POST[4] = 0;
	if(!$_POST[5]) $_POST[5] = 0;
	if(!$_POST[6]) $_POST[6] = 0;
	if(!$_POST[7]) $_POST[7] = 0;
	if(!$_POST[8]) $_POST[8] = 0;
	if(!$_POST[9]) $_POST[9] = 0;
	if(!$_POST[10]) $_POST[10] = 0;
	if(!$_POST[11]) $_POST[11] = 0;
	if(!$_POST[12]) $_POST[12] = 0;
	if(!$_POST[13]) $_POST[13] = 0;
	if(!$_POST[14]) $_POST[14] = 0;
	if(!$_POST[15]) $_POST[15] = 0;
	if(!$_POST[16]) $_POST[16] = 0;
	if(!$_POST[17]) $_POST[17] = 0;
	$perm = $_POST[0].$_POST[1].$_POST[2].$_POST[3].$_POST[4].$_POST[5].$_POST[6].$_POST[7].$_POST[8].$_POST[9].$_POST[10].$_POST[11].$_POST[12].$_POST[13].$_POST[14].$_POST[15].$_POST[16].$_POST[17];
	echo $perm;
		mysql_query("UPDATE roles SET permissions='$perm' WHERE id=".$_GET['role']."");
	}
$roles = mysql_fetch_array(mysql_query("SELECT * FROM roles WHERE id=".$_GET['role'].""));
$perm = str_split($roles['permissions']);
?>
<form method="post">
<table width="100%">
				 <tr>
				  <th>User/Admin</th>
				  <th>Servers</th>
				  <th>Groups</th>
				  <th>Files</th>
				  <th>Global</th>
				  <th>Per User</th>
				 </tr>
<tr class="a" bgcolor=#CCCCCC>
<td><input name="0" type="checkbox" value="1"<?php if($perm[0]=='1') echo ' checked'?> disabled> Login</td>
<td><input name="2"  type="checkbox" value="1"<?php if($perm[2]=='1') echo ' checked'?>> Create Servers</td>
<td><input name="5"  type="checkbox" value="1"<?php if($perm[5]=='1') echo ' checked'?>> Create Groups</td>
<td><input name="8"  type="checkbox" value="1"<?php if($perm[8]=='1') echo ' checked'?>> Create Files</td>
<td><input name="9"  type="checkbox" value="1"<?php if($perm[9]=='1') echo ' checked'?>> Ban</td>
<td><input name="10"  type="checkbox" value="1"<?php if($perm[10]=='1') echo ' checked'?>> Ban on their servers</td>
</tr>

<tr class="a" bgcolor=#CCCCCC>
<td><input name="1"  type="checkbox" value="1"<?php if($perm[1]=='1') echo ' checked'?>> Admin CP</td>
<td><input name="3"  type="checkbox" value="1"<?php if($perm[3]=='1') echo ' checked'?>> Delete Servers</td>
<td><input name="6"  type="checkbox" value="1"<?php if($perm[6]=='1') echo ' checked'?>> Delete Groups</td>
<td><input name="17"  type="checkbox" value="1"<?php if($perm[17]=='1') echo ' checked'?>> Delete Files</td>
<td><input name="11"  type="checkbox" value="1"<?php if($perm[11]=='1') echo ' checked'?>>Player Info</td>
<td><input name="12"  type="checkbox" value="1"<?php if($perm[12]=='1') echo ' checked'?>> Player Info for their servers</td>
</tr>

<tr class="a" bgcolor=#CCCCCC>
<td><center>--</center></td>
<td><input name="4"  type="checkbox" value="1"<?php if($perm[4]=='1') echo ' checked'?>> Delete their servers</td>
<td><input name="7"  type="checkbox" value="1"<?php if($perm[7]=='1') echo ' checked'?>> Delete their groups</td>
<td><center>--</center></td>
<td><input name="13"  type="checkbox" value="1"<?php if($perm[13]=='1') echo ' checked'?>> Reports</td>
<td><input name="14"  type="checkbox" value="1"<?php if($perm[14]=='1') echo ' checked'?>> Reports for their servers</td>
</tr>

<tr class="a" bgcolor=#CCCCCC>
<td><center>--</center></td>
<td><center>--</center></td>
<td><center>--</center></td>
<td><center>--</center></td>
<td><input name="15"  type="checkbox" value="1"<?php if($perm[15]=='1') echo ' checked'?>> Logs</td>
<td><input name="16"  type="checkbox" value="1"<?php if($perm[16]=='1') echo ' checked'?>> Logs for their servers</td>
</tr>
</table>
<input type="hidden" name="save" value="1">
<input type="submit" value="Save">
</form>
<?php
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?op=roles">Users</a></legend>
<?php if($_GET['op']=='roles'){
?>
O hello
<?php
}
?>
</fieldset>
<?php
}
include_once("include/footer.php");

?>