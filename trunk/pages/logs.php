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
?>				<h3>Logs</h3>
<?php
date_default_timezone_set("America/Chicago"); 
$id_clean = sanitize($_GET['server']);
if($_SESSION['perm'][17]=='1'){
	$q = mysql_query("SELECT * FROM servers WHERE enabled='1'");
} else {
	$q = mysql_query("SELECT * FROM servers WHERE enabled='1' AND owner='$name'");
}	
if(!$id_clean){
?>
<form>
Please select a server:
<input type=hidden name="p" value="logs">
<select name="server">
<?php
while($qr = mysql_fetch_array($q)){
?>
<option value="<?php echo $qr[0]?>"><?php echo $qr[2]?></option>
<?php
}
?>
</select>
<br>
Order by:<select name="order" onchange="this.form.submit();">
<option value="1"<?php if($_GET['order']=='1') echo " selected";?>>Newest</option>
<option value="2"<?php if($_GET['order']=='2') echo " selected";?>>Oldest</option>
</select>
<br>
 				Include:
				<input type="checkbox" checked value="1" name="admin">Admin Chat
				<input type="checkbox" checked value="1" name="slash">Commands
				<input type="checkbox" checked value="1" name="filtered">Filtered Chat
				<input type="checkbox" checked value="1" name="chat">Player Chat
				<input type="checkbox" checked value="1" name="join">Player Joins/Parts
				<input type="checkbox" checked value="1" name="report">Reports
				<input type="checkbox" checked value="1" name="status">Server Status
				<input type="checkbox" checked value="1" name="player">Playercount
				<br>
				Search: <input name="search" type="text" value="<?php echo $_GET['search'];?>">
				<br>
				From: <input name="fmonth" type="text" style="width: 15px;" maxlength="2" value="<?php echo date("m"); ?>"> / <input name="fday" type="text" style="width: 15px;" maxlength="2" value="<?php echo date("d"); ?>"> / <input name="fyear" type="text" style="width: 30px;" maxlength="4" value="<?php echo date("Y"); ?>">
				<br>
				To: <input name="tmonth" type="text" style="width: 15px;" maxlength="2" value="<?php echo date("m"); ?>"> / <input name="tday" type="text" style="width: 15px;" maxlength="2" value="<?php echo date("d"); ?>"> / <input name="tyear" type="text" style="width: 30px;" maxlength="4" value="<?php echo date("Y"); ?>">
				<br>
<input type=submit value=Go>
</form>
<?php
} else {
?>
                <form name="form" method="get">
				Server:
				<input type=hidden name="p" value="logs">
				<select name="server" onchange="this.form.submit();">
				<?php
				while($qr = mysql_fetch_array($q)){
				?>
				<option value="<?php echo $qr[0]?>"<?php if($qr[0]==$id_clean) echo ' selected';?>><?php echo $qr[2]?></option>
				<?php
				}
				print_r($_GET);
				if(!$_GET['fyear']) $_GET['fyear'] = date("Y");
				if(!$_GET['fmonth']) $_GET['fmonth'] = date("m");
				if(!$_GET['fday']) $_GET['fday'] = date("d");
				if(!$_GET['tyear']) $_GET['tyear'] = date("Y");
				if(!$_GET['tmonth']) $_GET['tmonth'] = date("m");
				if(!$_GET['tday']) $_GET['tday'] = date("d");
				?>
				</select>
				<br>
                Order by:<select name="order">
                <option value="1"<?php if($_GET['order']=='1') echo " selected";?>>Newest</option>
                <option value="2"<?php if($_GET['order']=='2') echo " selected";?>>Oldest</option>
                </select>
                <br>
				Include:
				<input type="checkbox" <?php if($_GET['admin']) echo 'checked ';?>value="1" name="admin">Admin Chat
				<input type="checkbox" <?php if($_GET['slash']) echo 'checked ';?>value="1" name="slash">Commands
				<input type="checkbox" <?php if($_GET['filtered']) echo 'checked ';?>value="1" name="filtered">Filtered Chat
				<input type="checkbox" <?php if($_GET['chat']) echo 'checked ';?>value="1" name="chat">Player Chat
				<input type="checkbox" <?php if($_GET['join']) echo 'checked ';?>value="1" name="join">Player Joins/Parts
				<input type="checkbox" <?php if($_GET['report']) echo 'checked ';?>value="1" name="report">Reports
				<input type="checkbox" <?php if($_GET['status']) echo 'checked ';?>value="1" name="status">Server Status
				<input type="checkbox" <?php if($_GET['player']) echo 'checked ';?>value="1" name="player">Playercount
				<br>
				Search: <input name="search" type="text" value="<?php echo $_GET['search'];?>">
				<br>
				From: <input name="fmonth" type="text" style="width: 15px;" maxlength="2" value="<?php echo $_GET['fmonth'] ?>"> / <input name="fday" type="text" style="width: 15px;" maxlength="2" value="<?php echo $_GET['fday']; ?>"> / <input name="fyear" type="text" style="width: 30px;" maxlength="4" value="<?php echo $_GET['fyear']; ?>">
				<br>
				To: <input name="tmonth" type="text" style="width: 15px;" maxlength="2" value="<?php echo $_GET['tmonth']; ?>"> / <input name="tday" type="text" style="width: 15px;" maxlength="2" value="<?php echo $_GET['tday']; ?>"> / <input name="tyear" type="text" style="width: 30px;" maxlength="4" value="<?php echo $_GET['tyear']; ?>">
				<br>
				<input type=submit value=Update>
                </form><br>
     <table cellpadding="3" width="100%">
     <tr>
     <td width="5%" BGCOLOR="#66CC66"><center><b>join</b></center></td>
     <td width="5%" BGCOLOR="#66CC66"><center><b>part</b></center></td>
     <td width="9%" BGCOLOR="#99FF99"><center><b>msg-brodcast</b></center></td>
     <td width="8%" BGCOLOR="#FF9933"><center><b>msg-admin</b></center></td>
     <td width="7%" BGCOLOR="#33FFFF"><center><b>msg-team</b></center></td>
     <td width="11%" BGCOLOR="#FF3300"><center><b>slashcommand</b></center></td>
     <td width="9%" BGCOLOR="#CCCCC"><center><b>playercount</b></center></td>
     <td width="9%" BGCOLOR="#FFFFCC"><center><b>msg-private</b></center></td>
     <td width="6%" BGCOLOR="#FFFF00"><center><b>filtered</b></center></td>
     <td width="6%" BGCOLOR="#CC66FF"><center><b>report</b></center></td>
     <td width="9%" BGCOLOR="#CC33CC"><center><b>server-status</b></center></td>
     </tr>
     </table>
     <table cellpadding="3" width="100%">
 	<tr>
  		<td><b>Date</b></td>
  		<td><b>Time</b></td>
  		<td><b>Event</b></td>
  		<td><b>From</b></td>
  		<td><b>To</b></td>
  		<td><b>Detail</b></td>
	</tr>
<?php
$from = strtotime($_GET['fyear'].'-'.$_GET['fmonth'].'-'.$_GET['fday']);
// Were adding 86400 seconds to the to date because its going from the start of the day to the end of the day
$to = strtotime($_GET['tyear'].'-'.$_GET['tmonth'].'-'.$_GET['tday']) + 86400;
$check = mysql_fetch_array(mysql_query("SELECT owner FROM servers WHERE id='$id_clean'"));
if($name !== $check[0]&&$_SESSION['perm'][17]!=='1'){
	die();
}
$q = "SELECT * FROM ".$id_clean."serverlogs WHERE `server`='$id_clean'";
$q .= " AND `type`=''";
if($_GET['admin']){
$q .= " OR `type`='MSG-ADMIN'";
}
if($_GET['slash']){
$q .= " OR `type`='MSG-COMMAND'";
}
if($_GET['filtered']){
$q .= " OR `type`='MSG-FILTERED'";
}
if($_GET['chat']){
$q .= " OR `type`='MSG-BROADCAST' OR `type`='MSG-TEAM' OR `type`='MSG-DIRECT'";
}
if($_GET['join']){
$q .= " OR `type`='PLAYER-JOIN' OR `type`='PLAYER-PART'";
}
if($_GET['report']){
$q .= " OR `type`='MSG-REPORT'";
}
if($_GET['status']){
$q .= " OR `type`='SERVER-STATUS'";
}
if($_GET['player']){
$q .= " OR `type`='PLAYERS'";
}
if($_GET['order']=='2'){
	$q .= " ORDER BY time ASC";
} else {
	$q .= " ORDER BY time DESC";
}
$qr = mysql_query($q);
$search = $_GET['search'];
while($log = mysql_fetch_array($qr)){
	if($log['time'] > $from && $log['time'] < $to && preg_match("/$search/",$log['data'])){
?><tr
<?php
	if($log['type'] == "PLAYER-JOIN") {
		echo 'BGCOLOR="#66CC66">';
		$type = "join";
	}
	if($log['type'] == "PLAYER-PART") {
		echo 'BGCOLOR="#66CC66">';
		$type = "part";
	}
	if($log['type'] == "MSG-BROADCAST") {
		echo 'BGCOLOR="#99FF99">';
		$type = "msg-brodcast";
	} else {
	if($log['type'] == "MSG-ADMIN") {
		echo 'BGCOLOR="#FF9933">';
		$type = "msg-admin";
	} else {
	if($log['type'] == "MSG-TEAM") {
		echo 'BGCOLOR="#33FFFF">';
		$type = "msg-team";
	} else {
	if($log['type'] == "MSG-COMMAND") {
		echo 'BGCOLOR="#FF3300">';
		$type = "slashcommand";
	} else {
	if($log['type'] == "PLAYERS") {
		echo 'BGCOLOR="#CCCCC">';
		$type = "playercount";
	} else {
	if($log['type'] == "MSG-DIRECT") {
		echo 'BGCOLOR="#FFFFCC">';
		$type = "msg-private";
	} else {
	if($log['type'] == "MSG-REPORT") {
		echo 'BGCOLOR="#CC66FF">';
		$type = "report";
	} else {
	if($log['type'] == "MSG-FILTERED") {
		echo 'BGCOLOR="#FFFF00">';
		$type = "filtered";
	} else {
	if($log['type'] == "SERVER-STATUS") {
		echo 'BGCOLOR="#CC33CC">';
		$type = "server-status";
	} else {
	}
	}
	}
	}
	}
	}
	}
	}
	}
	?>
<td><?php echo date("Y-m-d",$log['time']);?></td>
<td><?php echo date("h:i:s A",$log['time']);?></td>
<td>
<?php
		if($log['type'] == "PLAYER-JOIN") {
         $player = array();
         preg_match("/^\d+:(.*)\s#\d+\s(BZid:(\d*)\s)?\w+\sIP:(\d+(\.\d+)+)\s?(\w+(\s\w+)*)?$/",$log['data'],$player);
          echo "join</td>";
          echo "<td>--</td>";
          echo "<td>--</td>";
          echo "<td><b>Name:</b> $player[1] <b>IP:</b> $player[4] ";
          if($player[3]) echo "<b>BZid:</b> $player[3]"; if(strstr("$player[6]","ADMIN")){ echo "<b> Admin</b></td>";
          } else {
          	echo " <b>Not Admin</b>";
          }
          echo "</tr>";
        $player[$i_player] = "$player[1]";
        $i_player++;
  		}
  		if($log['type'] == "MSG-BROADCAST") {
         $msgall = array();
         preg_match("/(.*?):(.*?$)/",$log['data'],$msgall);
         $justmessage = substr($msgall[2],$msgall[1]);//seperating the message from the callsign
         $entirelength = strlen($msgall[2]);
         $actuallength = ($entirelength - $msgall[1]);
         $justuser = substr($msgall[2],0,-$actuallength);
          echo "msg-brodcast</td>";
          echo "<td>$justuser</td>";
          echo "<td>All</td>";
          echo "<td>$justmessage</td>";
          echo "</tr>";
  		}
  		if($log['type'] == "MSG-DIRECT") {
         $msgdirect = array();
         preg_match("/(^\d+):(.*) (\d+):(.*)/",$log['data'],$msgdirect);
         $justmessage = substr($msgdirect[4],$msgdirect[3]);
         $entirelength = strlen($msgdirect[4]);
         $actuallength = ($entirelength - $msgdirect[3]);
         $justuser = substr($msgdirect[4],0,-$actuallength);
          echo "msg-private</td>";
          echo "<td>$msgdirect[2]</td>";
          echo "<td>$justuser</td>";
       	  echo "<td>$justmessage</td>";
          echo "</tr>";
  		}
  		if($log['type'] == "MSG-TEAM") {
         $msgteam = array();
         preg_match("/(.*):(.*) (RABBIT|HUNTER|ROGUE|BLUE|RED|GREEN|PURPLE|OBSERVER|NOTEAM) (.*)/",$log['data'],$msgteam);
          echo "msg-team</td>";
          echo "<td>$msgteam[2]</td>";
          echo "<td>$msgteam[3]</td>";//FINE
          echo "<td>$msgteam[4]</td>";
          echo "</tr>";
  		} 	 	 	
  		if($log['type'] == "MSG-ADMIN") {
         $msgadmin = array();
         preg_match("/(.*?):(.*?$)/",$log['data'],$msgadmin);
         $justmessage = substr($msgadmin[2],$msgadmin[1]);
         $entirelength = strlen($msgadmin[2]);
         $actuallength = ($entirelength - $msgadmin[1]);
         $justuser = substr($msgadmin[2],0,-$actuallength);
          echo "msg-admin</td>";
          echo "<td>$justuser</td>";
          echo "<td>Admin</td>";
          echo "<td>$justmessage</td>";
          echo "</tr>";
  		} 	 	 	
  		if($log['type'] == "MSG-COMMAND") {
         $slash = array();
         preg_match("/(.*?):(.*?$)/",$log['data'],$slash);
         $justmessage = substr($slash[2],$slash[1]);
         $entirelength = strlen($slash[2]);
         $actuallength = ($entirelength - $slash[1]);
         $justuser = substr($slash[2],0,-$actuallength);
          echo "slashcommand</td>";
          echo "<td>$justuser</td>";
          echo "<td>Cmd</td>";
          echo "<td>$justmessage</td>";
          echo "</tr>";
  		}
  		if($log['type'] == "MSG-REPORT") {
         $players = array();
         preg_match("/(.*?):(.*?$)/",$log['data'],$report);
         $justmessage = substr($report[2],$report[1]);
         $entirelength = strlen($report[2]);
         $actuallength = ($entirelength - $report[1]);
         $justuser = substr($report[2],0,-$actuallength);
          echo "report</td>";
          echo "<td><b>$justuser</b></td>";
          echo "<td>--</td>";
          echo "<td>$justmessage</td>";
          echo "</tr>";
  		}
  		if($log['type'] == "MSG-FILTERED") {
         $players = array();
         preg_match("/(.*?):(.*?$)/",$log['data'],$report);
         $justmessage = substr($report[2],$report[1]);
         $entirelength = strlen($report[2]);
         $actuallength = ($entirelength - $report[1]);
         $justuser = substr($report[2],0,-$actuallength);
          echo "filtered</td>";
          echo "<td>$justuser</td>";
          echo "<td>Filtered</td>";
          echo "<td>$justmessage</td>";
          echo "</tr>";
  		}
  		if($log['type'] == "PLAYER-PART") {
         $playerpart = array();
         preg_match("/(.*?):(.*?$)/",$log['data'],$playerpart);
          echo "part</td>";
          echo "<td>Player part</td>";
          echo "<td>--</td>";
          echo "<td>$playerpart[2]</td>";
          echo "</tr>";
  		} 	
  		if($log['type'] == "PLAYERS") {
         $players = array();
         preg_match("/\((\d+)\) \[(.*)/",$log['data'],$players);
          echo "playercount</td>";
          echo "<td>--</td>";
          echo "<td>--</td>";
          echo "<td><b>Player Count:</b> ";
          if($players[1] == ""){
          	echo "0</td>";
          } else {
          	echo "$players[1]</td>";
  		}
          echo "</tr>";
  		}
  		if($log['type'] == "SERVER-STATUS") {
         $msgall = array();
         preg_match("/(.*)/",$log['data'],$srvrstatus);
         $serverstatus=strtolower($srvrstatus[1]);
          echo "server-status</td>";
          echo "<td>--</td>";
          echo "<td>--</td>";
          echo "<td><b>Server is $serverstatus</b></td>";
          echo "</tr>";
  		}
     ?>
     </tr>
<?php
	} else {
	}
}
?>
	</table>
	<?php
}
?>