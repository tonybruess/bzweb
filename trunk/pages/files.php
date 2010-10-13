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
$op = $_GET['op'];
?>
<h3>File Management</h3>
<fieldset>
<legend><a href="?p=files&op=create">Create Group DB, Ban DB, or Help File</a></legend>
<?php
if($op=='create'){
	if($_SESSION['perm'][11]){
		$id = $_POST['for'];
		$for = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE id='$id'"));
		$owner = $for[0];
	} else {
		$owner = $name;
	}
 if ( $_POST['type'] == "groupdb") {
  	$nameclean = sanitize($_POST['name']);
  	$contentsclean = sanitize($_POST['contents']);
  	if(mysql_query("INSERT INTO files (`name`,`owner`,`type`,`contents`) VALUES ('$nameclean','$owner','groupdb','$contentsclean')"))
  		echo "Created successfully";
  	else
  		echo "Failed";
  } elseif ( $_POST['type'] == "helpf") {
  	$nameclean = sanitize($_POST['name']);
  	$contentsclean = sanitize($_POST['contents']);
  	if(mysql_query("INSERT INTO files (`name`,`owner`,`type`,`contents`) VALUES ('$nameclean','$owner','helpf','$contentsclean')"))
  		echo "Created successfully";
  	else
  		echo "Failed";
  }elseif ( $_POST['type'] == "bandb") {
  	mkdir("banfiles/$owner/",0777);
  	$nameclean = sanitize($_POST['name']);
  	$contentsclean = sanitize($_POST['contents']);
	$file = "banfiles/$owner/$nameclean";
  	$fh = fopen($file, 'w');
  	fwrite($fh,"");
	fclose($fh);
  	if(file_exists("banfiles/$owner/".$e['nameclean']))
  		echo "Created successfully";
  	else
  		echo "Failed";
}
?>
<form id="form" action="?p=files&op=create" method="POST">
Type:
<input type="radio" name="type" value="groupdb" onclick="show('contents');" id="groupdb" checked><label for="groupdb"> Group Database</label>
<input type="radio" name="type" value="bandb" onclick="hide('contents');" id="bandb"><label for="bandb"> Ban Database</label>
<input type="radio" name="type" value="helpf" onclick="show('contents');" id="helpf"><label for="helpf"> Help File</label>
<br>
<?php if($_SESSION['perm'][5]){ ?>
For: <select name="for">
<?php
$q = mysql_query("SELECT * FROM users");
while($users = mysql_fetch_array($q)){
?>
<option value="<?php echo $users['id'];?>"<?php if($users['id']==$_SESSION['id']) echo ' selected';?>><?php echo $users['name']?></option>
<?php
}
?>
</select>
<br>
<?php
}
?>
Name: <input  name="name" type="text">
<input name="create" type="hidden" value="1">
<br>
<textarea name="contents" id="contents" cols="40" rows="15"></textarea>
<br>
<input value="Create" type="submit" >
</form>
<?php
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?p=files&op=upload">Upload a Map File</a></legend>
<?php
if($op=='upload'){
  if ($_POST) {
  
    	$fileName = sanitize($_FILES['map']['name']);
    	$tmpName  = $_FILES['map']['tmp_name'];
    	$fileSize = $_FILES['map']['size'];
    	$fileType = $_FILES['map']['type'];
    	
    	echo "Uploading map file: ".$fileName;
    	
    	$ext = substr($fileName, strpos($fileName,'.'), strlen($fileName)-1); // Get the extension from the filename.
    	
    	if(!strstr($ext,'.bzw'))
    	   die('The file you attempted to upload is not allowed.');
    	
    	// Now check the filesize, if it is too large then DIE and inform the user.
    	if(filesize($fileSize > 5242880))// check if file size is greater that 5MB
    	   die('The file you attempted to upload is too large.');
    	
    	
    	
    	$fp      = fopen($tmpName, 'r');
    	$content = fread($fp, filesize($tmpName));
    	$content = sanitize($content);
    	fclose($fp);
    	
    	$query = "INSERT INTO files (name, owner, type, contents ) ".
    	"VALUES ('$fileName', '$name', 'bzw', '$content')";
    	
    	mysql_query($query) or die('Error, query failed'); 
    	
    	echo "<br>File $fileName uploaded<br>";
   
    }
?>
<form action="?p=files&op=upload" enctype="multipart/form-data" method="POST">
<input type="file" name="map" >
<input type="hidden" name="upload" value="1">
<br><br>
<?php if($_SESSION['perm'][5]){ ?>
For: <select name="for">
<?php
$q = mysql_query("SELECT * FROM users");
while($users = mysql_fetch_array($q)){
?>
<option value="<?php echo $users['id'];?>"<?php if($users['id']==$_SESSION['id']) echo ' selected';?>><?php echo $users['name']?></option>
<?php
}
?>
</select>
<br><br>
<?php
}
?>
<input type="submit" value="Upload" >
</form>
<?php
}
?>
</fieldset>
<br>
<fieldset>
<legend><a href="?p=files&op=edit">Edit or Delete Files</a></legend>
<?php
if($op=='edit'){
	if($_GET['mode']=='del'){
		if(!$_SESSION['perm'][27]){
			echo "You do not have permission to delete files";
		} else {
			if(!is_numeric($_GET['id']))
			{
				$banfile = $_GET['id'];
				$owner = explode('/',$banfile);
				$owner = $owner[1];
				if($owner == $name || $_SESSION['perm']['13'])
				{
					if(unlink($banfile))
						echo 'Deleted!';
					else
						echo 'Failed to delete';
				}
			}
			else
			{
				$id = $_GET['id'];
				$confirm = mysql_fetch_array(mysql_query("SELECT * FROM files WHERE id='$id' AND owner='$name'"));
				if($confirm || $_SESSION['perm']['13'])
				{
					if(mysql_query("DELETE FROM files WHERE id='$id'"))
						echo 'Deleted!';
					else
						echo 'Failed to delete';
				}
				else
				{
					echo 'Not your file!';
				}
			}
		}
	}

if($_SESSION['perm'][12]){?>
<form method="POST">
Files for: <select name="uid" onchange="this.form.submit();">
<?php
$uid = $_POST['uid'];
if(!$uid) $uid = $_SESSION['id'];
$q = mysql_query("SELECT * FROM users");
while($users = mysql_fetch_array($q)){
?>
<option value="<?php echo $users['id'];?>" <?php if($users['id']==$uid){ echo 'selected'; $name = $users['name']; }?>><?php echo $users['name']?></option>
<?php
}
?>
</select>
</form>
<?php
}
?>
<fieldset>
<legend>Maps</legend>
<table border="0px" cellpadding="3" cellspacing="3" width="500px">
	<tr  style="text-align: left; font-weight: bold;">
		<td>Map Name</td>
		<td width="50px">Edit</td>
		<td width="50px">Delete</td>
	</tr>
<?php
$m = mysql_query("SELECT * FROM files WHERE owner='$name' AND `type`='bzw'");
while($mr = mysql_fetch_array($m)){
	echo '<tr bgcolor="#DDDDDD"><td>';
	echo $mr['name'];
	echo '</td><td><a href="?p=edit&mode=file&file='.$mr['id'].'">Edit</a></td><td><a href="?p=files&op=edit&mode=del&id='.$mr['id'].'">Delete</a></td></tr>';
}
?>
</table></fieldset><br>
<fieldset>
<legend>Group Databases</legend>
<table border="0px" cellpadding="3" cellspacing="3" width="500px">
	<tr style="text-align: left; font-weight: bold;">
		<td>Database Name</td>
		<td width="50px">Edit</td>
		<td width="50px">Delete</td>
	</tr>
<?php
$g = mysql_query("SELECT * FROM files WHERE owner='$name' AND `type`='groupdb'");
while($gr = mysql_fetch_array($g)){
	echo '<tr bgcolor="#DDDDDD"><td>';
	echo $gr['name'];
	echo '</td><td><a href="?p=edit&mode=file&file='.$gr['id'].'">Edit</a></td><td><a href="?p=files&op=edit&mode=del&id='.$gr['id'].'">Delete</a></td></tr>';
}
?>
</table></fieldset><br><fieldset>
<legend>Help Files</legend>
<table border="0px" cellpadding="3" cellspacing="3" width="500px">
	<tr style="text-align: left; font-weight: bold;">
		<td>File Name</td>
		<td width="50px">Edit</td>
		<td width="50px">Delete</td>
	</tr>
<?php
$h = mysql_query("SELECT * FROM files WHERE owner='$name' AND `type`='helpf'");
while($hr = mysql_fetch_array($h)){
	echo '<tr bgcolor="#DDDDDD"><td>';
	echo $hr['name'];
	echo '</td><td><a href="?p=edit&mode=file&file='.$hr['id'].'">Edit</a></td><td><a href="?p=files&op=edit&mode=del&id='.$hr['id'].'">Delete</a></td></tr>';
}
?>
</table></fieldset>
<br><fieldset>
<legend>Ban DB</legend>
<table border="0px" cellpadding="3" cellspacing="3" width="500px">
	<tr style="text-align: left; font-weight: bold;">
		<td>File Name</td>
		<td width="50px">View</td>
		<td width="50px">Delete</td>
	</tr>
<?php
	foreach (glob("banfiles/$name/*") as $filename) {
		$lengthOfBanfile = strlen("banfiles/$name/");
		$filereal = substr($filename,$lengthOfBanfile);
		echo '<tr bgcolor="#DDDDDD"><td>'.$filereal.'</td><td><a href="'.$filename.'">View</a></td><td><a href="?p=files&op=edit&mode=del&id='.$filename.'">Delete</a></td></tr>';
	}
$name = $_SESSION['callsign'];
?>
</table></fieldset>
<?php
}
?>
</fieldset>