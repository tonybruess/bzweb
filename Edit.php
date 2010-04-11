<?php
session_start(); 
header("Cache-control: private");
include("global/vars.php");
if(!$_SESSION['callsign']){
	?>
	<meta HTTP-EQUIV="Refresh" CONTENT="0;URL=Error.php?error=1">
	<?php
	} else { 
?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>BZWeb ::: <?php echo $organization; ?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="stylesheet" type="text/css" title="Red" href="css/style_red.css">
<link rel="alternate stylesheet" type="text/css" title="Blue" href="css/style_blue.css">
<link rel="alternate stylesheet" type="text/css" title="Green" href="css/style_green.css">
<link rel="alternate stylesheet" type="text/css" title="Brown" href="css/style_brown.css">
<link rel="alternate stylesheet" type="text/css" title="Magenta" href="css/style_magenta.css">
<link rel="alternate stylesheet" type="text/css" title="Black" href="css/style_black.css">
<link rel="stylesheet" type="text/css" title="global" href="css/global.css">
<link rel="stylesheet" type="text/css" href="global/tabcontent.css">
<script src="global/tabcontent.js" type="text/javascript"></script>
<script src="global/styleswitch.js" type="text/javascript"></script>
</head>
<body>
<div id="header">
	<div id="header_inner" class="fixed">
			 <div id="colors">
        		<a href="#" onclick="setActiveStyleSheet('Red'); return false;"><img src="images/red/n0.png" alt="colour scheme 1" id="color"/></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Green'); return false;"><img src="images/green/n0.png" alt="colour scheme 1" id="color"/></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Blue'); return false;"><img src="images/blue/n0.png" alt="colour scheme 1" id="color"/></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Magenta'); return false;"><img src="images/magenta/n0.png" alt="colour scheme 1" id="color"/></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Brown'); return false;"><img src="images/brown/n0.png" alt="colour scheme 1" id="color"/></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Black'); return false;"><img src="images/black/n0.png" alt="colour scheme 1" id="color"/></a>&nbsp;
     		 </div>
     		 <div id="logo">
				<h1><span><?php echo $organization; ?></span></h1>
				<h2>BZFS Administration</h2>
			 </div>
		
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a class="active">Servers</a></li>
				<li><a href="Files.php">Files</a></li>
				<li><a href="Bans.php">Bans</a></li>
				<li><a href="Player_Info.php">Player Info</a></li>
				<li><a href="Reports.php">Reports</a></li>
				<li><a href="Logs.php">Logs</a></li>
				<li><a href="Logout.php">Logout</a></li>
			</ul>
		</div>
		
	</div>
</div>
<div id="main">
	<div id="main_inner" class="fixed">
		<div id="content">
			<div id="body">
				<h3>Edit</h3>
<?php
$name = $_SESSION['callsign'];
$grouppost = $_GET['group'];
$serverpost = $_GET['server'];
if (!$_GET['server']){
	echo "Please do not h4x0r";
} else {
	if(!file_exists("servers/$grouppost/$serverpost/conf.conf")){
		echo "That server is so non-existant dood";
	} else {
	$owner = file_get_contents("servers/$grouppost/.owner");
	if ($name !== $owner){
	echo "DAT AINT UR SERVER FOO!";
	} else {
		if($_POST['editconf']){
			$confcontents = $_POST['confcontents'];
			$conf = fopen("servers/$grouppost/$serverpost/conf.conf","w");
			fputs($conf,$confcontents);
			fclose($conf);
		}
		if($_POST['editgroup']){
			$groupcontents = $_POST['groupcontents'];
			$group = fopen("servers/$grouppost/$serverpost/groups.db","w");
			fputs($group,$groupcontents);
			fclose($group);
		}
	?>
<form method="link" action="Servers.php">
<input type="submit" value="Back">
</form>
<br>
<ul id="tabs" class="shadetabs">
<li><a href="#tab1" rel="tab1" class="selected">Simple</a></li>
<li><a href="#tab2" rel="tab2">Advanced</a></li>
<li><a href="#tab3" rel="tab3">Group File</a></li>
<li><a href="#tab4" rel="tab4">Misc Settings</a></li>
</ul>

<div style="border:1px solid gray; width:450px; margin-bottom: 1em; padding: 10px">

<div id="tab1" class="tabcontent">
Easy editor under <b>intense</b> development. <i>*nom nom nom*</i>
<br><br>
Why not use the advanced one?<br />
</div>

<div id="tab2" class="tabcontent">
				<form method="post">
				<TEXTAREA NAME="confcontents" COLS=60 ROWS=20><?php
				$grouppost = $_GET['group'];
				$serverpost = $_GET['server'];
				$conf = file_get_contents("servers/$grouppost/$serverpost/conf.conf");
				echo $conf;
				?></TEXTAREA><br>
  					<input type="submit" value="Save">
                    <input type="hidden" name="editconf" value="1" >
               </form>
</div>
<div id="tab3" class="tabcontent">
				<form method="post">
				<TEXTAREA NAME="groupcontents" COLS=60 ROWS=20><?php
				$group = file_get_contents("servers/$grouppost/$serverpost/groups.db");
				echo $group;
				?></TEXTAREA><br>
  					<input type="submit" value="Save">
                    <input type="hidden" name="editgroup" value="1" >
               </form>
</div>

<div id="tab4" class="tabcontent">
<form method="post">
 Map file: <select name="worldfile">
<option>None</option>
</select>
</div>

</div>

<script type="text/javascript">

var countries=new ddtabcontent("tabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>
<?php
}
}
}
?>		  </div>
		<br class="clear">
	</div>
</div>
<div id="footer" class="fixed">
	&copy; Copyright 2010 BZBureau. All rights reserved.
</div>
    <?php
	}
	?>
</body>
</html>