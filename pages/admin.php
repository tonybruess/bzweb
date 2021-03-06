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
date_default_timezone_set("America/Chicago"); 
if($_SESSION['perm'][2]!=='1'){
} else {
	?>
<h3>Admin CP</h3>
<fieldset>
<legend><a href="?p=admin&op=config">Site Configuration</a></legend>
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
Domain 1: <input type="text" name="domain1" value="<?php echo $set_data[3]?>">
<br>
Domain 2: <input type="text" name="domain2" value="<?php echo $set_data[4]?>">
<br>
Domain 3: <input type="text" name="domain3" value="<?php echo $set_data[5]?>">
<br>
Domain 4: <input type="text" name="domain4" value="<?php echo $set_data[6]?>">
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
<legend><a href="?p=admin&op=roles">Permission Roles</a></legend>
<?php if($_GET['op']=='roles' && !$_GET['mode']){
	if($_POST['deleterole']){
	mysql_query("DELETE FROM roles WHERE id=".$_POST['deleterole']);
	}
	if($_POST['newrole']){
	$newrole = "INSERT INTO roles (`name`) VALUES ('".$_POST['newrole']."')";
	mysql_query($newrole);
	echo mysql_error();
	}
	$q = mysql_query("SELECT * FROM roles ORDER BY `name` ASC");
?>
			<table cellpadding=5>
				<tr>
				  <th width="50%">Name</th>
				  <th width="20%">Edit</th>
				  <th width="20%">Delete</th>
				 </tr>
				 <?php while($roles = mysql_fetch_array($q)){ ?>
				 <tr class="a" bgcolor=#CCCCCC>
					<td><?php echo $roles['name']?></td>
				 	<td><a href="?p=admin&op=group&mode=edit&role=<?php echo $roles['id'] ?>">Edit</a></td>
				 	<td><form method="post">
					<input type="submit" value="Delete">
					<input type="hidden" name="deleterole" value="<?php echo $roles['id']?>" >
					</form></td>
				 </tr>
				 <?php
				 }
				 ?>
			</table>
			<form method=post>
			New Role:
			<input type=text name=newrole>
			<input type=submit value=Create>
			</form>
<?php			
}
if($_GET['mode']=='edit'){
	if($_REQUEST['save']){
	$_POST[0] = 9;
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
	if(!$_POST['vs'] && !$_POST['vg']){ $_POST['vs'] = 0; } else { $_POST['vs'] = 1; } 
	if(!$_POST[19]) $_POST[19] = 0;
	if(!$_POST[20]) $_POST[20] = 0;
	if(!$_POST[21]) $_POST[21] = 0;
	if(!$_POST[22]) $_POST[22] = 0;
	if(!$_POST[23]) $_POST[23] = 0;
	if(!$_POST[24]) $_POST[24] = 0;
	if(!$_POST[25]) $_POST[25] = 0;
	if(!$_POST[26]) $_POST[26] = 0;
	if(!$_POST[27]) $_POST[27] = 0;
	if(!$_POST[28]) $_POST[28] = 0;
	if(!$_POST[29]) $_POST[29] = 0;
	if(!$_POST[30]) $_POST[30] = 0;
	if(!$_POST[31]) $_POST[31] = 0;
	if(!$_POST[32]) $_POST[32] = 0;
	if(!$_POST[33]) $_POST[33] = 0;
	$perm = $_POST[0].$_POST[1].$_POST[2].$_POST[3].$_POST[4].$_POST[5].$_POST[6].$_POST[7].$_POST[8].$_POST[9].$_POST[10].$_POST[11].$_POST[12].$_POST[13].$_POST[14].$_POST[15].$_POST[16].$_POST[17].$_POST[18].$_POST['vs'].$_POST[19].$_POST[20].$_POST[21].$_POST[22].$_POST[23].$_POST[24].$_POST[25].$_POST[26].$_POST[27].$_POST[28].$_POST[29].$_POST[30].$_POST[31].$_POST[32].$_POST[33];
		mysql_query("UPDATE roles SET permissions='$perm' WHERE id=".$_GET['role']."");
		echo '<div id="info">Role updated sucesfully<br></div>';
	}
$roles = mysql_fetch_array(mysql_query("SELECT * FROM roles WHERE id=".$_GET['role'].""));
$perm = str_split($roles['permissions']);
if(empty($roles)){
	echo "That role does not exist";
} else {
?>
You are editing permissions for: <b><?php echo $roles['name']?></b><br>
<form method="post" name="form">
<table width="100%" cellpadding=5>
				 <tr>
				  <th>Basic</th>
				  <th>Per User</th>
				  <th>Global</th>
				  <th>Per User</th>
				  <th>Global</th>
				 </tr>
<tr class="a" bgcolor=#CCCCCC>
<td><input name="1" id="1" type="checkbox" value="1"<?php if($perm[1]=='1') echo ' checked'?>> <label for="1"> Login</label></label></td>
<td><input name="3"  id="3" type="checkbox" value="1"<?php if($perm[3]=='1') echo ' checked'?>> <label for="3"> Create Servers</label></td>
<td><input name="4"  id="4" type="checkbox" value="1"<?php if($perm[4]=='1') echo ' checked'?>> <label for="4"> Create Any Server</label></td>
<td><input name="7"  id="7" type="checkbox" value="1"<?php if($perm[7]=='1') echo ' checked'?>> <label for="7"> Create Groups</label></td>
<td><input name="8"  id="8" type="checkbox" value="1"<?php if($perm[8]=='1') echo ' checked'?>> <label for="8"> Create Any Group</label></td>
</tr>

<tr class="a" bgcolor=#CCCCCC>
<td><input name="2"  id="2" type="checkbox" value="1"<?php if($perm[2]=='1') echo ' checked'?>> <label for="2"> Admin CP</label></td>
<td><input name="5"  id="5" type="checkbox" value="1"<?php if($perm[5]=='1') echo ' checked'?>> <label for="5"> Delete Servers</label></td>
<td><input name="6"  id="6" type="checkbox" value="1"<?php if($perm[6]=='1') echo ' checked'?>> <label for="6"> Delete Any Server</label></td>
<td><input name="9"  id="9" type="checkbox" value="1"<?php if($perm[9]=='1') echo ' checked'?>> <label for="9"> Delete Groups</label></td>
<td><input name="10"  id="10" type="checkbox" value="1"<?php if($perm[10]=='1') echo ' checked'?>> <label for="10"> Delete Any Group</label></td>
</tr>

<tr class="a" bgcolor=#CCCCCC>
<td><input name="32" id="32" type="checkbox" value="1"<?php if($perm[32]=='1') echo ' checked'?>> <label for="32"> Custom Conf Options</label></label></td>
<td><input name="19"  id="19" type="checkbox" value="1"<?php if($perm[19]=='1') echo ' checked'?>> <label for="19"> Start/Stop Servers</label></td>
<td><input name="20"  id="20" type="checkbox" value="1"<?php if($perm[20]=='1') echo ' checked'?>> <label for="20"> Start/Stop Any Server</label></td>
<td><center>--</center></td>
<td><center>--</center></td>
</tr>
<tr class="a" bgcolor=#CCCCCC>
<td><input name="33" id="33" type="checkbox" value="1"<?php if($perm[33]=='1') echo ' checked'?>> <label for="33"> Disable Master Conf</label></label></td>
<td><input name="21"  id="21" type="checkbox" value="1"<?php if($perm[21]=='1') echo ' checked'?>> <label for="21"> Edit Confs</label></td>
<td><input name="22"  id="22" type="checkbox" value="1"<?php if($perm[22]=='1') echo ' checked'?>> <label for="22"> Edit Any Conf</label></td>
<td><input name="vg"  id="vg" type="checkbox" value="1" onclick="this.form.vs.checked = this.checked;"<?php if($perm[18]=='1') echo ' checked'?>> <label for="vg"> View All Groups</label></td>
<td><input name="vs"  id="vs" type="checkbox" value="1" onclick="this.form.vg.checked = this.checked;"<?php if($perm[18]=='1') echo ' checked'?>> <label for="vs"> View All Servers</label></td>
</tr>
</table>
<table width="100%" cellpadding=5>
				 <tr>
				  <th>Per User</th>
				  <th>Global</th>
				  <th>Per User</th>
				  <th>Global</th>
				 </tr>

<tr class="a" bgcolor=#CCCCCC>
<td><input name="25"  id="25" type="checkbox" value="1"<?php if($perm[25]=='1') echo ' checked'?>> <label for="25"> Create Files</label></td>
<td><input name="11"  id="11" type="checkbox" value="1"<?php if($perm[11]=='1') echo ' checked'?>> <label for="11"> Create Any File</label></td>
<td><input name="28"  id="28" type="checkbox" value="1"<?php if($perm[28]=='1') echo ' checked'?>> <label for="28"> Ban</label></td>
<td><input name="14"  id="14" type="checkbox" value="1"<?php if($perm[14]=='1') echo ' checked'?>> <label for="14"> All Ban</label></td>
</tr>
<tr class="a" bgcolor=#CCCCCC>
<td><input name="26"  id="26" type="checkbox" value="1"<?php if($perm[26]=='1') echo ' checked'?>> <label for="26"> Edit Files</label></td>
<td><input name="12"  id="12" type="checkbox" value="1"<?php if($perm[12]=='1') echo ' checked'?>> <label for="12"> Edit Any File</label></td>
<td><input name="29"  id="29" type="checkbox" value="1"<?php if($perm[29]=='1') echo ' checked'?>> <label for="29"> Player Info</label></td>
<td><input name="15"  id="15" type="checkbox" value="1"<?php if($perm[15]=='1') echo ' checked'?>> <label for="15"> All Player Info</label></td>
</tr>
<tr class="a" bgcolor=#CCCCCC>
<td><input name="23"  id="23" type="checkbox" value="1"<?php if($perm[23]=='1') echo ' checked'?>> <label for="23"> Upload</label></td>
<td><input name="24"  id="24" type="checkbox" value="1"<?php if($perm[24]=='1') echo ' checked'?>> <label for="24"> Upload Any File</label></td>
<td><input name="30"  id="30" type="checkbox" value="1"<?php if($perm[30]=='1') echo ' checked'?>> <label for="30"> Logs</label></td>
<td><input name="17"  id="17" type="checkbox" value="1"<?php if($perm[17]=='1') echo ' checked'?>> <label for="17"> All Logs</label></td>
</tr>
<tr class="a" bgcolor=#CCCCCC>
<td><input name="27"  id="27" type="checkbox" value="1"<?php if($perm[27]=='1') echo ' checked'?>> <label for="27"> Delete Files</label></td>
<td><input name="13"  id="13" type="checkbox" value="1"<?php if($perm[13]=='1') echo ' checked'?>> <label for="13"> Delete Any File</label></td>
<td><input name="31"  id="31" type="checkbox" value="1"<?php if($perm[31]=='1') echo ' checked'?>> <label for="31"> Reports</label></td>
<td><input name="16"  id="16" type="checkbox" value="1"<?php if($perm[16]=='1') echo ' checked'?>> <label for="16"> All Reports</label></td>
</tr>
</table>
<input type="hidden" name="save" value="1">
<input type="submit" value="Save">
</form>
<?php
}
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?p=admin&op=users">Users</a></legend>
<?php if($_GET['op']=='users'){
?>
<table cellpadding=5>
<th>User</th>
<th>Role</th>
<th>Port Range</th>
<th>Last Login</th>
<?php
if($_POST['role']){
	mysql_query("UPDATE users SET `permissions`=".$_POST['role']." WHERE id=".$_POST['id']);
}
if($_POST['pstart']){
	if(!is_numeric($_POST['pstart']) || !isset($_POST['pstart'])) $_POST['pstart'] = '0';
	if(!is_numeric($_POST['pend']) || !isset($_POST['pend'])) $_POST['pend'] = '0';
	mysql_query("UPDATE users SET `pstart`='".$_POST['pstart']."', `pend`='".$_POST['pend']."' WHERE id=".$_POST['id']."");
}
if($_POST['newuser']){
	$userm = mysql_query("SELECT * FROM users WHERE name='".$_POST['newuser']."'");
	$q = mysql_fetch_array($userm);
	if($q[0]){
		echo '<div id="info">User already exists</div>';
	} else {
	$ts = time();
	mysql_query("INSERT INTO users (`name`,`permissions`,`last login`) VALUES ('".$_POST['newuser']."','".$_POST['role']."','$ts')");
	mkdir('banfiles/'.$_POST['newuser']);
	chmod('banfiles/'.$_POST['newuser'], 0777);
	}
}
$q = mysql_query("SELECT * FROM users ORDER BY `name` ASC");
while($users = mysql_fetch_array($q)){
?>
<tr class="a" bgcolor=#CCCCCC>
<td><?php echo $users['name']?></td>
<td>
<form method="post">
<select name= "role" onchange="this.form.submit();">
<?php
$roleq = mysql_query("SELECT * FROM roles ORDER BY `name` ASC");
while($role = mysql_fetch_array($roleq)){
	?>
	<option value="<?php echo $role['id'] ?>" <?php if($role['id'] == $users['permissions']) echo 'selected'?>><?php echo $role['name'] ?></option>
<?php
}
?>
	<input type="hidden" name="id" value="<?php echo $users['id']?>">
</form>
</td>
<td><form method="post">Start: <input name="pstart" type="text" size="5" maxlength="5" value="<?php echo $users['pstart']; ?>"> End: <input name="pend" type="text" size="5" maxlength="5" value="<?php echo $users['pend']; ?>"><input type="hidden" name="id" value="<?php echo $users['id']?>"> <input type="submit" name="portrange" value="Save"></form></td>
<td><?php echo date("Y-m-d",$users['last login']).' '.date("h:i:s A",$users['last login']);?></td>
</tr>
<?php
}
?>
</table>
<br>
<form method=post>
Callsign: <input type=text name=newuser>
<br>
Role: <select name="role">
<?php
$q2 = mysql_query("SELECT * FROM roles ORDER BY `name` ASC");
while($role = mysql_fetch_array($q2)){
	?>
	<option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
<?php
}
?>
</select>
<br>
<input type="submit" value="Add User">
</form>
<br>
<small>NOTE: If you change a role the form submits automatically</small>
<br>
<small>NOTE: You can only save one port range at a time</small>
<?php
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?p=admin&op=conf">Master Conf/Group DB</a></legend>
<?php if($_GET['op']=='conf'){
if($_POST['updatemaster']){
	$group = $_POST['group'];
	$conf = $_POST['conf'];
	$q = "UPDATE settings SET `groupmaster` = '$group', `confmaster` = '$conf'";
	mysql_query($q);
	echo '<div id="info">Updated</div>';
}
$data = mysql_fetch_array(mysql_query("SELECT confmaster,groupmaster,plugins FROM settings"));
?>
<form method="post">
<p>Enter a configuration file that will be included in ALL servers that are started</p>
<textarea name="conf" cols=50 rows=10><?php echo $data['confmaster'];?></textarea>
<p>Enter a group file that will be included in ALL servers that are started</p>
<textarea name="group" cols=50 rows=10><?php echo $data['groupmaster'];?></textarea>
<br>
<input type="hidden" name="updatemaster" value="1">
<input type="submit" value="Save">
</form><?php
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?p=admin&op=plugins">Plugins</a></legend>
<?php
if($_GET['op']=='plugins')
{
	if($_POST['new'])
	{
		if(mysql_query("INSERT INTO plugins SET `name`='".$_POST['name']."', `location`='".$_POST['location']."', `enabled`='1'"))
			echo '<div id="info">Plugin added successfully</div>';
	}
	if($_POST['delete'])
	{
		if(mysql_query("DELETE FROM plugins WHERE `id`='".$_POST['id']."'"))
			echo '<div id="info">Plugin deleted successfully</div>';
	}
	if($_POST['update'])
	{
		if($_POST['enabled']) $enabled = true;
		if(mysql_query("UPDATE plugins SET `name`='".$_POST['name']."', `location`='".$_POST['location']."', `enabled`='$enabled' WHERE `id`='".$_POST['id']."'"))
			echo '<div id="info">Plugin updated successfully</div>';
	}
	
	$plugins = mysql_query("SELECT * FROM plugins");
?>
<table>
<tr>
<th>Name</th>
<th>Location</th>
<th>Enabled</th>
<th>Save</th>
<th>Delete</th>
</tr>
<?php
while($plugin = mysql_fetch_assoc($plugins))
{
?>
<tr><form method="post"><td><input type="text" name="name" value="<?php echo $plugin['name']; ?>"></td><td><input type="text" name="location" value="<?php echo $plugin['location']; ?>"></td><td><input type="checkbox" name="enabled"<?php if($plugin['enabled']) echo ' checked'; ?>></td><td><input type="hidden" name="id" value="<?php echo $plugin['id']; ?>"><input type="submit" name="update" value="Save"></form></td><td><form method="post"><input type="hidden" name="id" value="<?php echo $plugin['id'] ?>"><input type="submit" name="delete" value="Delete"></form></td></tr>
<?php
}
?>
</table>
<br>
<b>Add a new plugin:</b>
<br>
<form method="post">
Name: <input type="text" name="name">
<br>
Location: <input type="text" name="location">
<br>
<input type="submit" name="new" value="Add">
</form>
<?php
}
?>
</fieldset>
<?php
}
?>