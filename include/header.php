<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>BZWeb ::: <?php echo $organization; ?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="stylesheet" type="text/css" href="css/global.css">
<link rel="stylesheet" type="text/css" title="Red" href="css/style_red.css">
<link rel="alternate stylesheet" type="text/css" title="Blue" href="css/style_blue.css">
<link rel="alternate stylesheet" type="text/css" title="Green" href="css/style_green.css">
<link rel="alternate stylesheet" type="text/css" title="Brown" href="css/style_brown.css">
<link rel="alternate stylesheet" type="text/css" title="Magenta" href="css/style_magenta.css">
<link rel="alternate stylesheet" type="text/css" title="Black" href="css/style_black.css">
<link rel="stylesheet" type="text/css" href="global/servers.css">
<script src="global/global.js" type="text/javascript"></script>
<script src="global/servers.js" type="text/javascript"></script>
<script src="global/styleswitch.js" type="text/javascript"></script>
</head>
<body onload="collapseAllRows();">
<div id="header">
	<div id="header_inner" class="fixed">
<?php
if($_SESSION['callsign']){ ?>
			 <div id="colors">
        		<a href="#" onclick="setActiveStyleSheet('Red'); return false;"><img src="images/red/n0.png" alt="colour scheme 1" id="color1"></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Green'); return false;"><img src="images/green/n0.png" alt="colour scheme 1" id="color2"></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Blue'); return false;"><img src="images/blue/n0.png" alt="colour scheme 1" id="color3"></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Magenta'); return false;"><img src="images/magenta/n0.png" alt="colour scheme 1" id="color4"></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Brown'); return false;"><img src="images/brown/n0.png" alt="colour scheme 1" id="color5"></a>&nbsp;
       			<a href="#" onclick="setActiveStyleSheet('Black'); return false;"><img src="images/black/n0.png" alt="colour scheme 1" id="color6"></a>&nbsp;
     		 </div>
     		<?php
			}
			?>
     		 <div id="logo">
				<h1><span><?php echo $organization; ?></span></h1>
				<h2>BZFS Administration</h2>
			 </div>
