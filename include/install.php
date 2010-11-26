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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="global/style.css">
	<link rel="stylesheet" href="global/servers.css">
	<script type="text/javascript" src="global/global.js"></script>
	<script type="text/javascript" src="global/servers.js"></script>
	<title>BZWeb - Install</title>
</head>


<body onload="collapseAllRows();">
<div id="Header">
	<div id="PageNavigation">
		<div id="Logo">
			<h1>BZWeb</h1> 
			<h2>BZFS Administration</h2> 
		</div>
			<ul>
				<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Install</a></li>
			</ul>
	</div>
</div>
<div id="Container">
	<div id="PageContent">
	
	<?php 
	// Login function
	function DoLogin()
	{
		if(isset($_POST['Part2']))
		{
		?>
			
		<h3>Install BZWeb - Part 2</h3>
		<p>Lets get started by entering some data below:</p>
		<form method="post">
		<table>
			<tr>
				<td>BZFlag Callsign</td>
				<td><input type="text" name="callsign"></td>
			</tr>
			<tr>
				<td>Company Name</td>
				<td><input type="text" name="company"></td>
			</tr>
			<tr>
				<td>Admin Email</td>
				<td><input type="text" name="email"></td>
			</tr>
		</table>
		
		<h3>MySQL</h3>
		
		<table>
			<tr>
				<td>New Database Name</td>
				<td><input type="text" name="db"></td>
			</tr>
			<tr>
				<td>Root User</td>
				<td><input type="text" name="RootUser"></td>
			</tr>
			<tr>
				<td>Root Password</td>
				<td><input type="password" name="RootPassword"></td>
			</tr>
			<tr>
				<td>New MySQL User</td>
				<td><input type="text" name="NewUser"></td>
			</tr>
			<tr>
				<td>New MySQL User Password</td>
				<td><input type="password" name="NewPassword"></td>
			</tr>
		</table>
		<br>
		<input name="Part2" type="hidden" value="2">
		<input name="Part3" type="submit" value="   Setup BZWEB   ">
		</form>
		<?php
		}
		else
		{
		?>
			
		<h3>Install BZWeb - Part 1</h3>
		<p>A few things first...</p>
		<p>Make sure you can execute <b>php5</b> from the command line</p>
		<p><b>PHP version 5</b> or later</p>
		<p><b>MySQL Database Server</b> to which you know the root password</p>
		<p>The directory that which BZWeb is installed in is <b>chmoded 777</b></p>
		<p>Once you have all that done, you may <b>continue!</b><p>
		<form method="post">
		<input name="Part2" type="submit" value="Continue">
		</form>
		
		<?php
		}
	}
	
	// Part 3
	if(isset($_POST['Part3']))
	{
		$fields = array('callsign', 'company', 'email', 'db', 'RootUser', 'RootPassword', 'NewUser', 'NewPassword');
		$error = false;
		
		foreach($fields as $field)
		{
			if(!isset($_POST[$field]) || $_POST[$field] === false)
			{
				$error = true;
				echo "<br> ERROR: Please enter a(n) $field";
			}
			$var = $field;
			$$var = $_POST[$field];
		}
		print_r($_POST);
		if($error)
		{
			DoLogin();
		}
		else
		{
			echo "<h3>Setting up BZWeb...</h3>";
			
			// Try connecting to MySQL as root
			if(!mysql_connect("localhost", $RootUser, $RootPassword))
			{
				die("Failed to connect to MySQL using username '$RootUser' and password '$RootPassword'. Error: ".mysql_error());
			}
			
			echo "Successfully connected to MySQL. <br>";
			
			// Create the database
			$databaseSQL = "CREATE DATABASE $db";
			
			if(!mysql_query($databaseSQL))
			{
				die("Failed to create database '$db'. Error: ".mysql_error());
			}
			
			echo "Database created... <br>";
			mysql_select_db($db) or die ("Error selecting database: ".mysql_error());
			
			// Create the user
			$createUserSQL = "GRANT ALL ON $db.* TO '$NewUser' IDENTIFIED BY '$NewPassword'";
			
			if(!mysql_query($createUserSQL))
			{
				die("Unable to create user '$NewUser' with password '$NewPassword'.");
			}
			
			echo "User '$NewUser' created... <br>";
			
			// Create the tables
			$CreateTableSQL = array(
				'Files' => 'CREATE TABLE files (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` text,`owner` VARCHAR(200),`type` VARCHAR(10),`contents` LONGTEXT)',
				'Groups' => 'CREATE TABLE groups (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,`name` VARCHAR(100),`owner` VARCHAR(100),`status` INT,`enabled` INT)',
				'Servers' => 'CREATE TABLE servers (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`master` INT NOT NULL,`name` TEXT,`owner` TEXT,`status` INT,`style` VARCHAR(5),`j` INT,`r` INT,`ms` INT,`noradar` INT,`autoteam` INT,`mp` INT,`rogue` INT,`red` INT,`green` INT,`blue` INT,`purple` INT,`observer` INT,`user` TEXT,`group` TEXT,`ban` TEXT,`report` TEXT,`nomasterban` INT,`agility` INT,`burrow` INT,`cloaking` INT,`genocide` INT,`guided missile` INT,`high speed` INT,`identify` INT,`invisible bullet` INT,`jumping` INT,`laser` INT,`machine gun` INT,`masquerade` INT,`narrow` INT,`oscillation overthruster` INT,`phantom zone` INT,`quick turn` INT,`rapid fire` INT,`ricochet` INT,`seer` INT,`shield` INT,`shock wave` INT,`stealth` INT,`steam roller` INT,`super bullet` INT,`thief` INT,`tiny` INT,`useless` INT,`wings` INT,`blindness` INT,`bouncy` INT,`colorblindness` INT,`forward only` INT,`jamming` INT,`left turn only` INT,`momentum` INT,`no jumping` INT,`obesity` INT,`reverse controls` INT,`reverse only` INT,`right turn only` INT,`trigger happy` INT,`wide angle` INT,`red flag` INT,`green flag` INT,`blue flag` INT,`purple flag` INT,`fb` INT,`sb` INT,`sa` INT,`st` INT,`sw` INT,`worldfile` TEXT,`b` INT,`h` INT,`worldsize` INT,`public` TEXT,`p` INT,`domain` TEXT,`disablebots` INT,`servermsg` TEXT,`admsg` TEXT,`custom` TEXT,`disablemaster` TEXT,`p1` TEXT,`p2` TEXT,`p3` TEXT,`p4` TEXT,`p5` TEXT,`p6` TEXT,`p7` TEXT,`p8` TEXT,`p9` TEXT,`p10` TEXT,`enabled` INT NOT NULL)',
				'Players' => 'CREATE TABLE players (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`serverowner` TEXT,`name` TEXT,`ip` VARCHAR(100),`host` VARCHAR(200),`description` TEXT,`bzid` VARCHAR(50),`time` VARCHAR(100))',
				'Reports' => 'CREATE TABLE reports (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`server` INT,`serverowner` TEXT,`reporter` TEXT,`report` TEXT,`time` VARCHAR(100))',
				'Settings' => 'CREATE TABLE settings (`site` TEXT,`email` TEXT,`bzfs` TEXT,`domain1` TEXT,`domain2` TEXT,`domain3` TEXT, `domain4` TEXT, `global` int,`local` int, `confmaster` TEXT, `groupmaster` TEXT, `plugins` TEXT)',
				'Users' => 'CREATE TABLE users (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` TEXT,`bzid` INT, `permissions` INT,`pstart` INT,`pend` INT,`last login` INT)',
				'Roles' => 'create table roles (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` TEXT,`permissions` VARCHAR(100))',
				'Bans' => 'create table bans (`id` INT,`server` INT,`banner` TEXT,`ip` VARCHAR(100),`length` VARCHAR(100),`reason` TEXT,`time` INT)',
				'Plugins' => 'CREATE TABLE plugins (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` TEXT, `location` TEXT, `arguments` TEXT, `enabled` BOOL DEFAULT TRUE)'
			);
			
			foreach($CreateTableSQL as $name=>$sql)
			{
				if(!mysql_query($sql))
				{
					die("ERROR: Unable to create $name table. MySQL Error: ".mysql_error());
				}
				else
				{
					echo "$name table created... <br>";
				}
			}
			
			$DefaultSQL = array(
				'settings' => "INSERT INTO settings (`site`, `email`) VALUES ('$company', '$email')",
				'roles' => "INSERT INTO roles (`name`, `permissions`) VALUES ('Admin', '9111111111111111111111111111111111')",
				'users' => "INSERT INTO users (`name`,`permissions`) VALUES ('$callsign','1')"
			);
			
			foreach($DefaultSQL as $table=>$sql)
			{
				if(!mysql_query($sql))
				{
					die("Failed to insert data into $table. MySQL Error: ".mysql_error());
				}
				else
				{
					echo "Data inserted into $table... <br>";
				}
			}
			
			$data = file_get_contents('include/config.default.php');
			$data = str_replace("define('SQL_USER','mrapple');", "define('SQL_USER','$NewUser');", $data);
			$data = str_replace("define('SQL_PASS','');", "define('SQL_PASS','$NewPassword');", $data);
			$data = str_replace("define('SQL_DB','bzweb');", "define('SQL_DB','$db');", $data);
			mkdir('banfiles/'.$name);
			chmod('banfiles/'.$name, 0777);
			$config = fopen('./config.php', 'w');
			if(fwrite($config, $data))
			{
				echo 'MySQL file created... <br>';
			}
			else
			{
				echo 'Failed to create MySQL file. <br>';
				echo 'Paste the following into config.php: <br>';
				echo "<textarea cols=\"60\" rows=\"10\">$data</textarea> <br>";
			}
			fclose($config);
		?>
		
		<p>You have sucesfully setup BZWeb on your server!</p>
		<p>Click <a href="index.php">HERE</a> to login using the callsign you provided at setup.</p>

		<?php
		}
	}
	else
	{
		// No post, do login
		DoLogin();
	}
	?>
	
	</div>