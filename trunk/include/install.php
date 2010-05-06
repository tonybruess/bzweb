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
				<li><a href="index.php">Install</a></li>
			</ul>
	</div>
</div>
<div id="Container">
	
	<div id="PageContent">
	<?php //Define login function
	function do_login(){?>
	<h3>Install BZWeb</h3>
	<p>Lets get started by entering some data below:</p>
	<form method="post">	
	BZFlag Callsign: <input type="text" name="callsign">
	<br>
	<br>
	Company Name: <input type="text" name="company">
	<br>
	<br>
	Admin Email: <input type="text" name="email">
	<br>
	<h3>Mysql</h3>
	New Database Name: <input type="text" name="db">
	<br>
	<br>
	Existing User: <input type="text" name="user">
	<br>
	<br>
	Existing Password: <input type="password" name="password">
	<br>
	<br>
	<input type="submit" value="     Setup BZWEB     ">
	</form>
	<?php
	}
	//There is a post
	if($_POST){
		//You lack a value
		if(!$_POST['callsign'] || !$_POST['company'] || !$_POST['email'] || !$_POST['db'] || !$_POST['user'] || !$_POST['password']) {
			if(!$_POST['callsign']) echo "<br>Error: Please enter a callsign";
			if(!$_POST['company']) echo "<br>Error: Please enter a company";
			if(!$_POST['email']) echo "<br>Error: Please enter an email";
			if(!$_POST['db']) echo "<br>Error: Please enter a database";
			if(!$_POST['user']) echo "<br>Error: Please enter a user";
			if(!$_POST['password']) echo "<br>Error: Please enter a password";
			//Do login because you lack a value
			do_login();
		} else {
			?><h3>Setuping up BZWeb...</h3><?php
			//Connect to database
			   mysql_connect("localhost",$_POST['user'],$_POST['password']) or die("Error: ".mysql_error()); // Connecting to the server
			//All values, Create DB and such
			if(!mysql_query('CREATE DATABASE '.$_POST['db'].' DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci')) {
				echo "Failed to create database";
				die();
			} else {
				echo "Database created...<br><br>";
				   mysql_select_db($_POST['db']) or die("Error: ".mysql_error()); // Connecting to the database
			}
			$sql1='create table files (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` text,`owner` VARCHAR(200),`type` VARCHAR(10),`contents` text)';

			$sql2='create table groups (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,`name` VARCHAR(100),`owner` VARCHAR(100),`status` INT,`enabled` INT)';

			$sql3='create table servers (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`master` INT NOT NULL,`name` TEXT,`owner` TEXT,`status` INT,`style` VARCHAR(5),`j` INT,`r` INT,`ms` INT,`noradar` INT,`autoteam` INT,`mp` INT,`rogue` INT,`red` INT,`green` INT,`blue` INT,`purple` INT,`observer` INT,`user` TEXT,`group` TEXT,`ban` TEXT,`report` TEXT,`nomasterban` INT,`fa` INT,`fcl` INT,`ff` INT,`fg` INT,`fgm` INT,`fib` INT,`fl` INT,`fmg` INT,`fn` INT,`foo` INT,`fpz` INT,`fqt` INT,`fsb` INT,`fse` INT,`fsh` INT,`fsr` INT,`fst` INT,`fsw` INT,`ft` INT,`fth` INT,`fus` INT,`fv` INT,`fwg` INT,`fb` INT,`sb` INT,`worldfile` TEXT,`b` INT,`h` INT,`worldsize` INT,`public` TEXT,`p` INT,`domain` TEXT,`disablebots` INT,`servermsg` TEXT,`admsg` TEXT,`enabled` INT NOT NULL)';

			$sql4='create table players (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`serverowner` TEXT,`name` TEXT,`ip` VARCHAR(100),`host` VARCHAR(200),`description` TEXT,`bzid` VARCHAR(50),`time` VARCHAR(100))';

			$sql5='create table reports (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`server` INT,`serverowner` TEXT,`reporter` TEXT,`report` TEXT,`time` VARCHAR(100))';

			$sql6='create table settings (`site` TEXT,`email` TEXT,`bzfs` TEXT,`domain1` TEXT,`domain2` TEXT,`domain3` TEXT, `domain4` TEXT, `global` int,`local` int)';

			$sql7='create table users (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` TEXT,`bzid` INT, `permissions` INT,`pstart` INT,`pend` INT,`last login` INT)';

			$sql8='create table roles (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` TEXT,`permissions` VARCHAR(100))';
			if(!mysql_query($sql1) || !mysql_query($sql2) || !mysql_query($sql3) || !mysql_query($sql4) || !mysql_query($sql5) || !mysql_query($sql6) || !mysql_query($sql7) || !mysql_query($sql8)){
				echo "Failed to create tables";
				die();
			} else {
				echo "Tables created...<br><br>";
			}
			$site = $_POST['site'];
			$email = $_POST['email'];
			$name = $_POST['callsign'];
			$sql1="INSERT INTO settings (`site`,`email`) VALUES ('$site','$email'); INSERT INTO roles (`name`,`permissions`) VALUES ('Admin','91111111111111111111111111111111'); INSERT INTO users (`name`,`permissions`) VALUES ('$name','1')";
			if(!mysql_query($sql1)){
				echo "Failed to insert data";
				die();
			} else {
				echo "Data inserted...<br><br>";
		}
		?>
		<p>You have sucesfully setup BZWeb on your server!</p>
		<p>Click HERE to login using the callsign you provided at setup.</p>
		<?php
		}
	} else {
		//No post, do login
		do_login();
	}
	?>
	</div>
	<div id="PageBottom">
		<div id="Copyright"><span><?php if(!$_SESSION['callsign'])$name="Guest";
	echo 'Logged in as '.$name.' from '.$_SERVER['REMOTE_ADDR']?> &copy; 2010 BZBureau.com</span></div>
	</div>

</div>

</body>
</html>