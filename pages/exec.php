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
function options($start,$stop,$restart){
?>
<center>
<table>
<tr><?php
if($start){
?>
<td>
<form method="GET">
<input type="hidden" name="p" value="exec">
<input type="hidden" name="mode" value="start">
<input type="hidden" name="g" value="<?php echo $_GET['g']; ?>">
<input type="hidden" name="s" value="<?php echo $_GET['s']; ?>">
<input type="submit" value="Start">
</form>
</td>
<?php
}
if($stop){
?>
<td>
<form method="GET">
<input type="hidden" name="p" value="exec">
<input type="hidden" name="mode" value="stop">
<input type="hidden" name="g" value="<?php echo $_GET['g']; ?>">
<input type="hidden" name="s" value="<?php echo $_GET['s']; ?>">
<input type="submit" value="Stop">
</form>
</td>
<?php
}
if($restart){
?>
<td>
<form method="GET">
<input type="hidden" name="p" value="exec">
<input type="hidden" name="mode" value="restart">
<input type="hidden" name="g" value="<?php echo $_GET['g']; ?>">
<input type="hidden" name="s" value="<?php echo $_GET['s']; ?>">
<input type="submit" value="Restart">
</form>
</td>
<?php
}
?>
</tr>
</table>
</center>
<?php
}
?>
<h3><?php 
if($_GET['mode']=='start') echo 'Start'; if($_GET['mode']=='stop') echo 'Stop';?> Server</h3>
<form method="GET">
<input type="hidden" name="p" value="servers">
<input type="submit" value="Back">
</form>
<?php
	$name = $_SESSION['callsign'];
	$serverclean = $_GET['s'];
	$groupclean = $_GET['g'];
	$g = mysql_query("SELECT * FROM groups WHERE id='$groupclean'");
	$e = mysql_query("SELECT * FROM servers WHERE id='$serverclean' AND master='$groupclean'");
	$g = mysql_fetch_array($g);
	$e = mysql_fetch_array($e);
	if(!$e){
		die();
	}
	if($name == $g[2] && $_SESSION['perm'][19] || $_SESSION['perm'][20]){
		// This is your server and you can start/stop servers
		// OR you have start all permission
	?>
<center>
<table  border="1" cellpadding="3" cellspacing="0" width="400">
<tr><th colspan="2"><?php if($_GET['mode']=='start') echo 'Starting '.$e['name']; if($_GET['mode']=='stop') echo 'Stopping '.$e['name']; ?></th></tr>
	<tr><td>Organization:</td><td><?php echo $g['name'] ?></td></tr>
	<tr><td>Server:</td><td><?php echo $e['name'] ?></td></tr>
<?php
$pidd = shell_exec("kill -0 `cat servers/".$e['id']."/bzfs.pid` 2>&1");
if($_GET['mode']=='start'){
	?>
		<tr><td>Request:</td><td>Start</td></tr>
		<tr>
			<td>Output:</td>
			<td>
<?php
if(!$pidd){
	mysql_query("UPDATE servers SET `status`=1 WHERE id='$serverclean'");
	echo "Server is already running.<br>";
	echo '</td></tr></table></center>';
	options(0,1,1);
	include_once "include/footer.php";
	die();
} else {
	mysql_query("UPDATE servers SET `status`=0 WHERE id='$serverclean'");
	echo "Server is not already running...<br>";
	mkdir("servers/$serverclean/",0777);
}

//Parse config
switch ($e['style']) {
   case "gtn": $conf .= " "; break;
   case "gtc": $conf .= " -c "; break;
   case "gtcr": $conf .= " -cr "; break;
   case "gtrs": $conf .= " -rabbit score "; break;
   case "gtrk": $conf .= " -rabbit killer "; break;
   case "gtrr": $conf .= " -rabbit random "; break;
}
if($e['j']=='1')$conf .= ' -j';
if($e['r']=='1')$conf .= ' +r';
if($e['sb']=='1')$conf .= ' -sb';
if($e['fb']=='1')$conf .= ' -fb';
if($e['noradar']=='1')$conf .= ' -noradar';
if($e['ms'] < 20)$conf .= ' -ms '.$e['ms'];
if($e['autoteam']=='1')$conf .= ' -autoTeam';
if($e['rogue'] || $e['red'] || $e['green'] || $e['blue'] || $e['purple'] || $e['observer'])$conf .= ' -mp '.$e['rogue'].','.$e['red'].','.$e['green'].','.$e['blue'].','.$e['purple'].','.$e['observer'];
if($e['nomasterban']=='1')$conf .= ' -noMasterBanlist';
if($e['agility'] != "0" ) $conf .= " +f A{".$e['agility']."}";
if($e['burrow'] != "0" ) $conf .= " +f BU{".$e['burrow']."}";
if($e['cloaking'] != "0" ) $conf .= " +f CL{".$e['cloaking']."}";
if($e['genocide'] != "0" ) $conf .= " +f G{".$e['genocide']."}";
if($e['guided missile'] != "0" ) $conf .= " +f GM{".$e['guided missile']."}";
if($e['high speed'] != "0" ) $conf .= " +f V{".$e['high speed']."}";
if($e['identify'] != "0" ) $conf .= " +f ID{".$e['identify']."}";
if($e['invisible bullet'] != "0" ) $conf .= " +f IB{".$e['invisible bullet']."}";
if($e['jumping'] != "0" ) $conf .= " +f JP{".$e['jumping']."}";
if($e['laser'] != "0" ) $conf .= " +f L{".$e['laser']."}";
if($e['machine gun'] != "0" ) $conf .= " +f MG{".$e['machine gun']."}";
if($e['masquerade'] != "0" ) $conf .= " +f MQ{".$e['masquerade']."}";
if($e['narrow'] != "0" ) $conf .= " +f N{".$e['narrow']."}";
if($e['oscillation overthruster'] != "0" ) $conf .= " +f OO{".$e['oscillation overthruster']."}";
if($e['phantom zone'] != "0" ) $conf .= " +f PZ{".$e['phantom zone']."}";
if($e['quick turn'] != "0" ) $conf .= " +f QT{".$e['quick turn']."}";
if($e['rapid fire'] != "0" ) $conf .= " +f F{".$e['rapid fire']."}";
if($e['ricochet'] != "0" ) $conf .= " +f R{".$e['ricochet']."}";
if($e['seer'] != "0" ) $conf .= " +f SE{".$e['seer']."}";
if($e['shield'] != "0" ) $conf .= " +f SH{".$e['shield']."}";
if($e['shock wave'] != "0" ) $conf .= " +f SW{".$e['shock wave']."}";
if($e['stealth'] != "0" ) $conf .= " +f ST{".$e['stealth']."}";
if($e['steam roller'] != "0" ) $conf .= " +f SR{".$e['steam roller']."}";
if($e['super bullet'] != "0" ) $conf .= " +f SB{".$e['super bullet']."}";
if($e['thief'] != "0" ) $conf .= " +f TH{".$e['thief']."}";
if($e['tiny'] != "0" ) $conf .= " +f T{".$e['tiny']."}";
if($e['useless'] != "0" ) $conf .= " +f US{".$e['useless']."}";
if($e['wings'] != "0" ) $conf .= " +f WG{".$e['wings']."}";

if($e['blindness'] != "0" ) $conf .= " +f B{".$e['blindness']."}";
if($e['bouncy'] != "0" ) $conf .= " +f BY{".$e['bouncy']."}";
if($e['colorblindness'] != "0" ) $conf .= " +f CB{".$e['colorblindness']."}";
if($e['forward only'] != "0" ) $conf .= " +f FO{".$e['forward only']."}";
if($e['jamming'] != "0" ) $conf .= " +f JM{".$e['jamming']."}";
if($e['left turn only'] != "0" ) $conf .= " +f LT{".$e['left turn only']."}";
if($e['momentum'] != "0" ) $conf .= " +f M{".$e['momentum']."}";
if($e['obesity'] != "0" ) $conf .= " +f O{".$e['obesity']."}";
if($e['reverse controls'] != "0" ) $conf .= " +f RC{".$e['reverse controls']."}";
if($e['reverse only'] != "0" ) $conf .= " +f RO{".$e['reverse only']."}";
if($e['right turn only'] != "0" ) $conf .= " +f RT{".$e['right turn only']."}";
if($e['trigger happy'] != "0" ) $conf .= " +f TR{".$e['trigger happy']."}";
if($e['wide angle'] != "0" ) $conf .= " +f WA{".$e['wide angle']."}";

if($e['red flag'] != "0" ) $conf .= " +f R*{".$e['red flag']."}";
if($e['green flag'] != "0" ) $conf .= " +f G*{".$e['green flag']."}";
if($e['blue flag'] != "0" ) $conf .= " +f B*{".$e['blue flag']."}";
if($e['purple flag'] != "0" ) $conf .= " +f P*{".$e['purple flag']."}";

if($e['ban'] == "None" || !$e['ban']){
	echo "Not saving bans to a banfile...<br>";
} else {
	$conf .=" -banfile \"../../banfiles/".$e['owner']."/".$e['ban']."\"";
}

if($e['worldfile'] == "None" || !$e['worldfile']){
	$conf .= ' -worldsize '.$e['worldsize'].' ';
	if($e['b']=='1')$conf .= ' -b';
	if($e['h']=='1')$conf .= ' -h';
	echo "Random world created...<br>";
} else {
	$mapdata = mysql_fetch_array(mysql_query("SELECT * FROM files WHERE id=".$e['worldfile']));
	$mapfile = "servers/".$e['id']."/map.bzw";
	$fh = fopen($mapfile, 'w');
	fwrite($fh, $mapdata['contents']);
	fclose($fh);
	echo "World file added...<br>";
	$conf .= ' -world map.bzw';
}
if($e['public'])$conf .= ' -public "'.$e['public'].'"';
if($e['domain'])$conf .= ' -publicaddr '.$e['domain'].':'.$e['p'].' -p '.$e['p'];
if($e['disablebots']=='1') $conf .= ' -disableBots';
$srvex = explode("\n",$e['servermsg']);
if($e['servermsg']){
	foreach ($srvex as $srv){
	$conf .= ' -srvmsg "'.trim($srv).'"';
}
}
if($e['admsg']){
$adex = explode("\n",$e['admsg']);
foreach ($adex as $ad){
	$conf .= ' -admsg "'.trim($ad).'"';
}
}
$masterdata = mysql_fetch_array(mysql_query("SELECT groupmaster,confmaster FROM settings"));
$groupinfo = mysql_fetch_array(mysql_query("SELECT * FROM files WHERE id=".$e['group']));
$bothgroup = $groupinfo['contents'] . "\n\n" . $masterdata['groupmaster'];
$groupfile = "servers/".$e['id']."/groups.txt";
$fh = fopen($groupfile, 'w');
fwrite($fh, $bothgroup);
fclose($fh);
if($e && $conf){
	echo "Configuration parsed...<br>";
} else { 
	echo "Configuration failed<br>";	
	echo '</td></tr></table></center>';
	options(1,0,0);
	include_once "include/footer.php";
	die();
}
$serverid = $e[0];
$conf .= " -pidfile bzfs.pid -ts -requireudp -groupdb groups.txt -loadplugin /usr/local/lib/bzflag/logDetail.so -reportfile reports.txt ";
if($e['disablemaster']&&$_SESSION['perm'][33]){} else { $conf .= $masterdata['confmaster']; }
//Add a new line to the end of the conf, thanks brad
$conf .= "\n";
if($e['custom']&&$_SESSION['perm'][32])$conf .= $e['custom'];
$conf .= "\n";
$fh = fopen("servers/$serverid/conf.conf", 'w');
fwrite($fh, $conf);
fclose($fh);
$cmd = "cd servers/".$serverid."; bzfs -conf conf.conf 2> error.txt | /usr/bin/php5 ../../logpipe.php ".$serverid." ".$serverid." \"".$e['owner']."\" 2>error_logpipe.txt >/dev/null&";
shell_exec($cmd);
sleep(2);
$error = file_get_contents("servers/$e[0]/error.txt");
	if($error){
		$error = nl2br($error);
		echo "---------<br>";
		echo $error;
		echo "---------<br>";
	}
if(preg_match("/Usage: /",$error) || preg_match("/ERROR: /",$error)){
	echo "Server failed to start<br>";
	echo '</td></tr></table></center>';
	options(1,0,0);
	include_once "include/footer.php";
	die();
} else {
	echo "Server started successfully!";
	echo '</td></tr></table></center>';
	options(0,1,1);
	include_once "include/footer.php";
	die();
}
}
?>
<?php
if($_GET['mode']=='stop'){
	?>
	<tr><td>Request:</td><td>Stop</td></tr>
		<tr>
			<td>Output:</td>
			<td>
	<?php
$pidd = shell_exec("kill -0 `cat servers/".$e['id']."/bzfs.pid` 2>&1");
if($pidd){
	mysql_query("UPDATE servers SET `status`=0 WHERE id='$serverclean'");
	echo "Server is already stopped.<br>";
	echo '</td></tr></table></center>';
	options(1,0,0);
	include_once "include/footer.php";
	die();
} else {
	mysql_query("UPDATE servers SET `status`=1 WHERE id='$serverclean'");
	echo "Server is running...<br>";
}
echo "Requesting information...<br>";
if(file_exists("servers/$e[0]/bzfs.pid")){
	$tokill = file_get_contents("servers/$e[0]/bzfs.pid");
	echo "Stopping server...<br>";
} else {
	echo "Failed to get information<br>";
	echo '</td></tr></table></center>';
	options(1,0,1);
	include_once "include/footer.php";
	die();
}
if(posix_kill($tokill,9)){
	echo "Server stopped successfully<br>";
	mysql_query("UPDATE servers SET `status`=0 WHERE id='$serverclean'");
	echo '</td></tr></table></center>';
	options(1,0,0);
	include_once "include/footer.php";
	die();
} else {
	echo "Server failed to stop<br>";
	echo '</td></tr></table></center>';
	options(0,1,0);
	include_once "include/footer.php";
	die();
}
}
?>
		</td>
	</tr>
</table>
</center><br>
<?php
	} else {
		echo "No permission!";
	}
	?>