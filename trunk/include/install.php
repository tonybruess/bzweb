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
	function do_login(){
		if($_POST['2']){
			?>
	<h3>Install BZWeb - Part 2</h3>
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
	<input name=2 type="hidden" value="2">
	<input name=3 type="submit" value="     Setup BZWEB     ">
	</form>
	<?php
		} else {
	?>
	<h3>Install BZWeb - Part 1</h3>
	<p>A few things first...</p>
	<p>Make sure you have <b>php5-cgi</b> installed</p>
	<p><b>PHP version 5</b> or later</p>
	<p><b>MySQL Database Server</b> with an existing user and password</p>
	<p>The directory that which BZWeb is installed in is <b>chmoded 777</b></p>
	<p>Once you have all that done, you may <b>continue!</b><p>
	<form method=post>
	<input name=2 type=submit value=Continue>
	</form>
	<?php
	}
	}
	//There is a post
	if($_POST['3']){
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
			   if(!mysql_connect("localhost",$_POST['user'],$_POST['password'])){
			   		echo "Failed to connect to mysql. Error: ".mysql_error();
			   		die();
			   } else {
			   		echo "Connected to mysql!...<br><br>";
			   }
			//All values, Create DB and such
			if(!mysql_query('CREATE DATABASE '.$_POST['db'].' DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci')) {
				echo "Failed to create database. Error: ".mysql_error();
				die();
			} else {
				echo "Database created...<br><br>";
				   mysql_select_db($_POST['db']) or die("Error: ".mysql_error()); // Connecting to the database
			}
			$sql1='create table files (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` text,`owner` VARCHAR(200),`type` VARCHAR(10),`contents` LONGTEXT)';

			$sql2='create table groups (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,`name` VARCHAR(100),`owner` VARCHAR(100),`status` INT,`enabled` INT)';

			$sql3='create table servers (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`master` INT NOT NULL,`name` TEXT,`owner` TEXT,`status` INT,`style` VARCHAR(5),`j` INT,`r` INT,`ms` INT,`noradar` INT,`autoteam` INT,`mp` INT,`rogue` INT,`red` INT,`green` INT,`blue` INT,`purple` INT,`observer` INT,`user` TEXT,`group` TEXT,`ban` TEXT,`report` TEXT,`nomasterban` INT,`agility` INT,`burrow` INT,`cloaking` INT,`genocide` INT,`guided missile` INT,`high speed` INT,`identify` INT,`invisible bullet` INT,`jumping` INT,`laser` INT,`machine gun` INT,`masquerade` INT,`narrow` INT,`oscillation overthruster` INT,`phantom zone` INT,`quick turn` INT,`rapid fire` INT,`ricochet` INT,`seer` INT,`shield` INT,`shock wave` INT,`stealth` INT,`steam roller` INT,`super bullet` INT,`thief` INT,`tiny` INT,`useless` INT,`wings` INT,`blindness` INT,`bouncy` INT,`colorblindness` INT,`forward only` INT,`jamming` INT,`left turn only` INT,`momentum` INT,`no jumping` INT,`obesity` INT,`reverse controls` INT,`reverse only` INT,`right turn only` INT,`trigger happy` INT,`wide angle` INT,`red flag` INT,`green flag` INT,`blue flag` INT,`purple flag` INT,`fb` INT,`sb` INT,`sa` INT,`st` INT,`sw` INT,`worldfile` TEXT,`b` INT,`h` INT,`worldsize` INT,`public` TEXT,`p` INT,`domain` TEXT,`disablebots` INT,`servermsg` TEXT,`admsg` TEXT,`p1` TEXT,`p2` TEXT,`p3` TEXT,`p4`4 TEXT,`p5` TEXT,`p6` TEXT,`p7` TEXT,`p8` TEXT,`p9` TEXT,`p10` TEXT,`enabled` INT NOT NULL)';
 
			$sql4='create table players (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`serverowner` TEXT,`name` TEXT,`ip` VARCHAR(100),`host` VARCHAR(200),`description` TEXT,`bzid` VARCHAR(50),`time` VARCHAR(100))';

			$sql5='create table reports (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`server` INT,`serverowner` TEXT,`reporter` TEXT,`report` TEXT,`time` VARCHAR(100))';

			$sql6='create table settings (`site` TEXT,`email` TEXT,`bzfs` TEXT,`domain1` TEXT,`domain2` TEXT,`domain3` TEXT, `domain4` TEXT, `global` int,`local` int, `confmaster` TEXT, `groupmaster` TEXT, `plugins` TEXT)';

			$sql7='create table users (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` TEXT,`bzid` INT, `permissions` INT,`pstart` INT,`pend` INT,`last login` INT)';

			$sql8='create table roles (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` TEXT,`permissions` VARCHAR(100))';
			
			$sql9= 'create table bans (`id` INT,`server` INT,`banner` TEXT,`ip` VARCHAR(100),`length` VARCHAR(100),`reason` TEXT,`time` INT)';
 			if(!mysql_query($sql1)){
				echo "Failed to create table Files. Error: ".mysql_error();
				die();
			} else {
				echo "Table Files created...<br><br>";
			}
 			if(!mysql_query($sql2)){
				echo "Failed to create table Groups. Error: ".mysql_error();
				die();
			} else {
				echo "Table Groups created...<br><br>";
			}
 			if(!mysql_query($sql3)){
				echo "Failed to create table Servers. Error: ".mysql_error();
				die();
			} else {
				echo "Table Servers created...<br><br>";
			}
 			if(!mysql_query($sql4)){
				echo "Failed to create table Players. Error: ".mysql_error();
				die();
			} else {
				echo "Table Players created...<br><br>";
			}
 			if(!mysql_query($sql5)){
				echo "Failed to create table Reports. Error: ".mysql_error();
				die();
			} else {
				echo "Table Reports created...<br><br>";
			}
 			if(!mysql_query($sql6)){
				echo "Failed to create table Settings. Error: ".mysql_error();
				die();
			} else {
				echo "Table Settings created...<br><br>";
			}
 			if(!mysql_query($sql7)){
				echo "Failed to create table Users. Error: ".mysql_error();
				die();
			} else {
				echo "Table Users created...<br><br>";
			}
 			if(!mysql_query($sql8)){
				echo "Failed to create table Roles. Error: ".mysql_error();
				die();
			} else {
				echo "Table Roles created...<br><br>";
			}
 			if(!mysql_query($sql9)){
				echo "Failed to create table Bans. Error: ".mysql_error();
				die();
			} else {
				echo "Table Bans created...<br><br>";
			}
			$site = $_POST['company'];
			$email = $_POST['email'];
			$name = $_POST['callsign'];
			$sql1= "INSERT INTO settings (`site`,`email`) VALUES ('$site','$email')";
			$sql2 = "INSERT INTO roles (`name`,`permissions`) VALUES ('Admin','91111111111111111111111111111111')";
			$sql3 = "INSERT INTO users (`name`,`permissions`) VALUES ('$name','1')";
			if(!mysql_query($sql1)){
				echo "Failed to insert settings data. Error: ".mysql_error();
				die();
			} else {
				echo "Settings data inserted...<br><br>";
			}
			if(!mysql_query($sql2)){
				echo "Failed to insert roles data. Error: ".mysql_error();
				die();
			} else {
				echo "Roles data inserted...<br><br>".mysql_error();
			}
			if(!mysql_query($sql3)){
				echo "Failed to insert users data. Error: ".mysql_error();
				die();
			} else {
				echo "User data inserted...<br><br>";
			}
				$data = file_get_contents("include/mysql-example.php");
				$db = $_POST['db'];
				$user = $_POST['user'];
				$pass = $_POST['password'];
				preg_replace("/define('SQL_USER','mrapple');/","define('SQL_USER','$user');",$data);
				preg_replace("/define('SQL_PASS','');/","define('SQL_USER','$pass');",$data);
				preg_replace("/define('SQL_DB','bzweb');/","define('SQL_USER','$db');",$data);
				$mysqlfile = "include/mysql.php";
				$fh = fopen($mysqlfile, 'w');
				if(fwrite($fh, $data)){
					echo "Mysql file created...<br><br>";
				} else {
					echo "Failed to create mysql file<br><br>";
					?>
					Paste the following into include/mysql.php:<br><br>
					<textarea><?php echo $data; ?></textarea><br><br>
					<?php
				}
				fclose($fh);
		?>
		<p>You have sucesfully setup BZWeb on your server!</p>
		<p>Click <a href="index.php">HERE</a> to login using the callsign you provided at setup.</p>
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