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
<h3>Edit</h3>
<?php
if($_GET['mode']=='conf'){
//Check for correc paramaters
if (!$_GET['server'] || !$_GET['group']){
	echo "Error encountered, contact support";
} else {
//Get data
	$server = $_GET['server'];
	$server_clean = sanitize($server);
	$group = $_GET['group'];
	$group_clean = sanitize($group);
	$g = mysql_query("SELECT * FROM groups WHERE `id`='$group_clean'");
	$e = mysql_query("SELECT * FROM servers WHERE `master`='$group_clean' AND `id`='$server_clean'");
	$g_ar = mysql_fetch_array($g);
	$e_ar = mysql_fetch_array($e);
	//Is this your server?
	if($name == $g_ar[2] && $_SESSION['perm'][21] || $_SESSION['perm'][22]){
		$overallowner = $g_ar[2];		
//If user posted conf, check if numerical 
if($_POST['save']){
$varscheck = Array($_POST['msv'],$_POST['rogue'],$_POST['red'],$_POST['green'],$_POST['blue'],$_POST['purple'],$_POST['observer'],$_POST['fa'],$_POST['fcl'],$_POST['frf'],$_POST['fg'],$_POST['fgm'],$_POST['fib'],$_POST['fl'],$_POST['fmg'],$_POST['fn'],$_POST['foo'],$_POST['fpz'],$_POST['fqt'],$_POST['fsb'],$_POST['fse'],$_POST['fsh'],$_POST['fsr'],$_POST['fst'],$_POST['fsw'],$_POST['ft'],$_POST['fth'],$_POST['fus'],$_POST['fv'],$_POST['fwg'],$_POST['worldsize'],$_POST['p'],$_POST['sa'],$_POST['st'],$_POST['sw']);
//Loop each var
foreach ($varscheck as $element) {
    if (is_numeric($element) || !$element) {
     } else {
        echo "Alphabetic characters detected";
        //Die if user attempted to hack
        include_once "include/footer.php";
        die();
    }
// End foreach loop
}
$port = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE name='$overallowner'"));
if($_POST['p'] < $port['pstart'] || $_POST['p'] > $port['pend']){
	die("That is not your port.");
}
?>
<?php
//Execute sucesfull Edit SQL Here
$flags = json_decode($_POST['Flags'], true);
mysql_query("UPDATE servers SET
`name`='".$_POST['name']."',
`style`='".$_POST['style']."',
`j`='".$_POST['j']."',
`r`='".$_POST['r']."',
`ms`='".$_POST['ms']."',
`noradar`='".$_POST['noradar']."',
`autoteam`='".$_POST['autoteam']."',
`mp`='".$_POST['mp']."',
`rogue`='".$_POST['rogue']."',
`red`='".$_POST['red']."',
`green`='".$_POST['green']."',
`blue`='".$_POST['blue']."',
`purple`='".$_POST['purple']."',
`observer`='".$_POST['observer']."',
`user`='".$_POST['user']."',
`group`='".$_POST['group']."',
`ban`='".$_POST['ban']."',
`report`='".$_POST['report']."',
`nomasterban`='".$_POST['nomasterban']."',
`agility`='".$flags['Agility']."',
`burrow`='".$flags['Burrow']."',
`cloaking`='".$flags['Cloaking']."',
`genocide`='".$flags['Genocide']."',
`guided missile`='".$flags['Guided Missile']."',
`high speed`='".$flags['High Speed']."',
`identify`='".$flags['Identify']."',
`invisible bullet`='".$flags['Invisible Bullet']."',
`jumping`='".$flags['Jumping']."',
`laser`='".$flags['Laser']."',
`machine gun`='".$flags['Machine Gun']."',
`masquerade`='".$flags['Masquerade']."',
`narrow`='".$flags['Narrow']."',
`oscillation overthruster`='".$flags['Oscillation Overthruster']."',
`phantom zone`='".$flags['Phantom Zone']."',
`quick turn`='".$flags['Quick Turn']."',
`rapid fire`='".$flags['Rapid Fire']."',
`ricochet`='".$flags['Ricochet']."',
`seer`='".$flags['Seer']."',
`shield`='".$flags['Shield']."',
`shock wave`='".$flags['Shock Wave']."',
`stealth`='".$flags['Stealth']."',
`steam roller`='".$flags['Steam Roller']."',
`super bullet`='".$flags['Super Bullet']."',
`thief`='".$flags['Thief']."',
`tiny`='".$flags['Tiny']."',
`useless`='".$flags['Useless']."',
`wings`='".$flags['Wings']."',
`blindness`='".$flags['Blindness']."',
`bouncy`='".$flags['Bouncy']."',
`colorblindness`='".$flags['Colorblindness']."',
`forward only`='".$flags['Forward Only']."',
`jamming`='".$flags['Jamming']."',
`left turn only`='".$flags['Left Turn Only']."',
`momentum`='".$flags['Momentum']."',
`no jumping`='".$flags['No Jumping']."',
`obesity`='".$flags['Obesity']."',
`reverse controls`='".$flags['Reverse Controls']."',
`reverse only`='".$flags['Reverse Only']."',
`right turn only`='".$flags['Right Turn Only']."',
`trigger happy`='".$flags['Trigger Happy']."',
`wide angle`='".$flags['Wide Angle']."',
`red flag`='".$flags['Red Flag']."',
`green flag`='".$flags['Green Flag']."',
`blue flag`='".$flags['Blue Flag']."',
`purple flag`='".$flags['Purple Flag']."',
`fb`='".$_POST['fb']."',
`sb`='".$_POST['sb']."',
`sa`='".$_POST['sa']."',
`st`='".$_POST['st']."',
`sw`='".$_POST['sw']."',
`worldfile`='".$_POST['worldfile']."',
`b`='".$_POST['b']."',
`h`='".$_POST['h']."',
`worldsize`='".$_POST['worldsize']."',
`public`='".$_POST['public']."',
`p`='".$_POST['p']."',
`domain`='".$_POST['domain']."',
`disablebots`='".$_POST['disablebots']."',
`servermsg`='".$_POST['servermsg']."',
`admsg`='".$_POST['admsg']."',
`custom`='".$_POST['custom']."',
`disablemaster`='".$_POST['disablemaster']."' WHERE `id`='$server_clean'");
echo mysql_error();
}
//Fetch the data
	$z = mysql_query("SELECT * FROM servers WHERE `id`='$server_clean'");
	$zar = mysql_fetch_array($z);
//Edit conf file!
?>
<script type="text/javascript">
  window.addEvent("domready", function()
  {
<?php if($zar['agility']){ echo'    AddFlag("Agility",'; echo $zar['agility'];?>); <?php } ?>
<?php if($zar['burrow']){ echo'    AddFlag("Burrow",'; echo $zar['burrow'];?>); <?php } ?>
<?php if($zar['cloaking']){ echo'    AddFlag("Cloaking",'; echo $zar['cloaking'];?>); <?php } ?>
<?php if($zar['genocide']){ echo'    AddFlag("Genocide",'; echo $zar['genocide'];?>); <?php } ?>
<?php if($zar['guided missile']){ echo'    AddFlag("Guided Missile",'; echo $zar['guided missile'];?>); <?php } ?>
<?php if($zar['high speed']){ echo'    AddFlag("High Speed",'; echo $zar['high speed'];?>); <?php } ?>
<?php if($zar['identify']){ echo'    AddFlag("Identify",'; echo $zar['identify'];?>); <?php } ?>
<?php if($zar['invisible bullet']){ echo'    AddFlag("Invisible Bullet",'; echo $zar['invisible bullet'];?>); <?php } ?>
<?php if($zar['jumping']){ echo'    AddFlag("Jumping",'; echo $zar['jumping'];?>); <?php } ?>
<?php if($zar['laser']){ echo'    AddFlag("Laser",'; echo $zar['laser'];?>); <?php } ?>
<?php if($zar['machine gun']){ echo'    AddFlag("Machine Gun",'; echo $zar['machine gun'];?>); <?php } ?>
<?php if($zar['masquerade']){ echo'    AddFlag("Masquerade",'; echo $zar['masquerade'];?>); <?php } ?>
<?php if($zar['narrow']){ echo'    AddFlag("Narrow",'; echo $zar['narrow'];?>); <?php } ?>
<?php if($zar['oscillation overthruster']){ echo'    AddFlag("Oscillation Overthruster",'; echo $zar['oscillation overthruster'];?>); <?php } ?>
<?php if($zar['phantom zone']){ echo'    AddFlag("Phantom Zone",'; echo $zar['phantom zone'];?>); <?php } ?>
<?php if($zar['quick turn']){ echo'    AddFlag("Quick Turn",'; echo $zar['quick turn'];?>); <?php } ?>
<?php if($zar['rapid fire']){ echo'    AddFlag("Rapid Fire",'; echo $zar['rapid fire'];?>); <?php } ?>
<?php if($zar['ricochet']){ echo'    AddFlag("Ricochet",'; echo $zar['ricochet'];?>); <?php } ?>
<?php if($zar['seer']){ echo'    AddFlag("Seer",'; echo $zar['seer'];?>); <?php } ?>
<?php if($zar['shield']){ echo'    AddFlag("Shield",'; echo $zar['shield'];?>); <?php } ?>
<?php if($zar['shock wave']){ echo'    AddFlag("Shock Wave",'; echo $zar['shock wave'];?>); <?php } ?>
<?php if($zar['stealth']){ echo'    AddFlag("Stealth",'; echo $zar['stealth'];?>); <?php } ?>
<?php if($zar['steam roller']){ echo'    AddFlag("Steam Roller",'; echo $zar['steam roller'];?>); <?php } ?>
<?php if($zar['super bullet']){ echo'    AddFlag("Super Bullet",'; echo $zar['super bullet'];?>); <?php } ?>
<?php if($zar['thief']){ echo'    AddFlag("Thief",'; echo $zar['thief'];?>); <?php } ?>
<?php if($zar['tiny']){ echo'    AddFlag("Tiny",'; echo $zar['tiny'];?>); <?php } ?>
<?php if($zar['useless']){ echo'    AddFlag("Useless",'; echo $zar['useless'];?>); <?php } ?>
<?php if($zar['wings']){ echo'    AddFlag("Wings",'; echo $zar['wings'];?>); <?php } ?>
<?php if($zar['blindness']){ echo'    AddFlag("Blindness",'; echo $zar['blindness'];?>); <?php } ?>
<?php if($zar['bouncy']){ echo'    AddFlag("Bouncy",'; echo $zar['bouncy'];?>); <?php } ?>
<?php if($zar['colorblindness']){ echo'    AddFlag("Colorblindness",'; echo $zar['colorblindness'];?>); <?php } ?>
<?php if($zar['forward only']){ echo'    AddFlag("Forward Only",'; echo $zar['forward only'];?>); <?php } ?>
<?php if($zar['jamming']){ echo'    AddFlag("Jamming",'; echo $zar['jamming'];?>); <?php } ?>
<?php if($zar['left turn only']){ echo'    AddFlag("Left Turn Only",'; echo $zar['left turn only'];?>); <?php } ?>
<?php if($zar['momentum']){ echo'    AddFlag("Momentum",'; echo $zar['momentum'];?>); <?php } ?>
<?php if($zar['no jumping']){ echo'    AddFlag("No Jumping",'; echo $zar['no jumping'];?>); <?php } ?>
<?php if($zar['obesity']){ echo'    AddFlag("Obesity",'; echo $zar['obesity'];?>); <?php } ?>
<?php if($zar['reverse controls']){ echo'    AddFlag("Reverse Controls",'; echo $zar['reverse controls'];?>); <?php } ?>
<?php if($zar['reverse only']){ echo'    AddFlag("Reverse Only",'; echo $zar['reverse only'];?>); <?php } ?>
<?php if($zar['right turn only']){ echo'    AddFlag("Right Turn Only",'; echo $zar['right turn only'];?>); <?php } ?>
<?php if($zar['trigger happy']){ echo'    AddFlag("Trigger Happy",'; echo $zar['trigger happy'];?>); <?php } ?>
<?php if($zar['wide angle']){ echo'    AddFlag("Wide Angle",'; echo $zar['wide angle'];?>); <?php } ?>
<?php if($zar['red flag']){ echo'    AddFlag("Red Flag",'; echo $zar['red flag'];?>); <?php } ?>
<?php if($zar['green flag']){ echo'    AddFlag("Green Flag",'; echo $zar['green flag'];?>); <?php } ?>
<?php if($zar['blue flag']){ echo'    AddFlag("Blue Flag",'; echo $zar['blue flag'];?>); <?php } ?>
<?php if($zar['purple flag']){ echo'    AddFlag("Purple Flag",'; echo $zar['purple flag'];?>); <?php } ?>
  });
</script>

<form method="GET">
<input type="hidden" name="p" value="servers">
<input type="submit" value="Back">
</form>
<br>
<form action="" method="post" id="theform">
Name: <input type="text" name="name" value="<?php echo $zar['name']; ?>">
<br>
<center>
<input value="           Save           " type="submit" >
</center>
<input type="hidden" name="save" value="1">
<fieldset>
 <legend>Gameplay Settings</legend>
<select name="style">
<option value="gtn" <?php if($zar['style']=='gtn') echo 'selected';?>>None (FFA)</option>
<option value="gtc" <?php if($zar['style']=='gtc') echo 'selected';?>>Capture The Flag</option>
<option value="gtcr" <?php if($zar['style']=='gtcr') echo 'selected';?>>Capture The Flag Random Map</option>
<option value="gtrs" <?php if($zar['style']=='gtrs') echo 'selected';?>>Rabbit Chase: Score Rabbit</option>
<option value="gtrk" <?php if($zar['style']=='gtrk') echo 'selected';?>>Rabbit Chase: Killer Rabbit</option>
<option value="gtrr" <?php if($zar['style']=='gtrr') echo 'selected';?>>Rabbit Chase: Random Rabbit</option>
</select> Game Type<br>
<input name="j" type="checkbox" value="1" <?php if($zar['j']=='1') echo 'checked';?>> Jumping<br>
<input name="r" type="checkbox" value="1" <?php if($zar['r']=='1') echo 'checked';?>> Ricochet<br>
<input name="noradar" type="checkbox" value="1" <?php if($zar['noradar']=='1') echo 'checked';?>> No Radar<br>
Max Shots <input type="text" size="2" maxlength="2" name="ms" value="<?php echo $zar['ms'];?>"><br>
</fieldset><br>
<fieldset>
 <legend>Player and Team Settings</legend>
<input name="autoteam" type="checkbox" value="1" <?php if($zar['autoteam']=='1') echo 'checked';?>> Autoteam<br>
 <fieldset><legend>Maximum Players</legend>
<input name="rogue" type="text" size="2" maxlength="3" value="<?php echo $zar['rogue'];?>"> Rogues<br>
<input name="red" type="text" size="2" maxlength="3" value="<?php echo $zar['red'];?>"> Reds<br>
<input name="green" type="text" size="2" maxlength="3" value="<?php echo $zar['green'];?>"> Greens<br>
<input name="blue" type="text" size="2" maxlength="3" value="<?php echo $zar['blue'];?>"> Blues<br>
<input name="purple" type="text" size="2" maxlength="3" value="<?php echo $zar['purple'];?>"> Purples<br>
<input name="observer" type="text" size="2" maxlength="3" value="<?php echo $zar['observer'];?>"> Observers<br>
 </fieldset><br>
<select name ="group">
<option value="0">None</option>
<?php
$groupq = mysql_query("SELECT * FROM files WHERE owner='$overallowner' AND type='groupdb'");
while($groupdb = mysql_fetch_array($groupq)) {
  ?><option value="<?php echo $groupdb['id']?>"<?php if ($zar['group'] == $groupdb['id']) { echo ' selected'; } ?>><?php
  echo $groupdb['name'] ?></option><?php
  }
?>
</select> Group Database
<br>
<select name ="ban">
<option>None</option>
<?php
$previousbanfile = mysql_fetch_array(mysql_query("SELECT ban FROM servers WHERE id='$server_clean'"));
foreach (glob("banfiles/$overallowner/*") as $filename) {
	$l = strlen("banfiles/$overallowner/");
	$filereal = substr($filename,$l);
    echo "<option";
    if($filereal==$previousbanfile[0]) echo ' selected'; echo ">$filereal</option>";
}
?>
</select> Ban Database
<br>
<input name="user" type="checkbox" value="1"<?php if($zar['user']=='1') echo ' checked';?>> User Database
<br>
<input name="nomasterban" type="checkbox" value="1" <?php if($zar['nomasterban']=='1') echo 'checked';?>> No Master Banlist<br>
</fieldset><br>
<fieldset>
 <legend>Flag Settings</legend>
<div style="text-align: center; overflow: hidden;">
<div style="float: left; clear: left; width: 43%">
<span>Press "Add" or double click to add <input type="text" id="NumFlagsToAdd" maxlength="2" value="1" style="width: 1.5em"> flag(s).</span>
<input type="button" value="Add" style="width: 100%" id="AddButton">
<select id="AvailableFlagList" multiple size="15" style="width: 100%;"></select>
<table>
<tr>
<td><input name="fb" type="checkbox" value="1" <?php if($zar['fb']=='1') echo 'checked';?>> Flags Spawn on Buildings<br></td>
<td><input name="sb" type="checkbox" value="1" <?php if($zar['sb']=='1') echo 'checked';?>> Tanks Spawn on Buildings<br></td>
<td><input name="sa" type="checkbox" value="1" <?php if($zar['sa']=='1') echo 'checked';?>> Spawn Antidote Flags<br></td>
</tr>
</table>
</div>
<div style="float: right; width: 43%">
<span>Press "Remove" or double click to remove <input type="text" id="NumFlagsToRemove" maxlength="2" value="1" style="width: 1.5em"> flag(s).</span>
<input type="button" value="Remove" style="width: 100%" id="RemoveButton">
<select id="FlagList" multiple size="15" style="width: 100%;"></select>
Drop bad flag after <input name="st" type="text" maxlength="2" style="width: 1.5em;" value="<?php echo $zar['st'];?>"> secs<br>
Drop bad flag after <input name="sw" type="text" maxlength="2" style="width: 1.5em;" value="<?php echo $zar['sw'];?>"> wins<br>
</div>
<div style="text-align: center; float: left; margin-right:15px; margin-left:15px; width: 10%">
<br><br><br>
Use the flag selector to manipulate flags. The left box contains all the flags while the right box contains the flags on your server.
</div>
<input type="hidden" name="Flags" id="Flags" value="{}">
</div>
</fieldset><br>
<fieldset>
 <legend>World Settings</legend>
 <fieldset>
<legend><input type="radio" name="myRadioButton" onclick="b.disabled=true; h.disabled=true; b.checked=false; h.checked=false; worldsize.disabled=true; worldsize.value='0'; worldfile.disabled=false; worldfile.value='<?php echo $zar['worldfile'];?>';" checked> Map File</legend>

<select name="worldfile">
<option value="0" disabled>None</option>
<?php
$mapq = mysql_query("SELECT * FROM files WHERE owner='$overallowner' AND type='bzw'");
while($mapfile = mysql_fetch_array($mapq)) {
  ?><option value="<?php echo $mapfile['id']?>"<?php if ($zar['worldfile'] == $mapfile['id']) { echo ' selected'; } ?>><?php
  echo $mapfile['name'] ?></option><?php
  }
?>
</select> Map File
<br>
</fieldset>
<fieldset>
 <legend><input type="radio" name="myRadioButton" onclick="b.disabled=false; h.disabled=false; worldsize.disabled=false; worldfile.disabled=true; worldfile.value='0';"> Random Map</legend>
<input name="b" type="checkbox" value="1" <?php if($zar['b']=='1') echo 'checked';?> disabled> Random Rotation<br>
<input name="h" type="checkbox" value="1" <?php if($zar['h']=='1') echo 'checked';?> disabled> Random Height<br>
<input type="text" name="worldsize" size="3" maxlength="4" value="<?php echo $zar['worldsize']?>" disabled> World Size, if not set 400 is used<br>
</fieldset>
</fieldset><br>
<fieldset>
 <legend>Public Settings</legend>
<input type="text" name="public" size="35" maxlength="60" value="<?php echo $zar['public']?>"> The name of the server<br>
<select name="domain">
<?php if($sitedata['domain1']){?><option <?php if($zar['domain']==$sitedata['domain1']) echo 'selected';?>><?php echo $sitedata['domain1'] ?></option><?php } ?>
<?php if($sitedata['domain2']){?><option <?php if($zar['domain']==$sitedata['domain2']) echo 'selected';?>><?php echo $sitedata['domain2'] ?></option><?php } ?>
<?php if($sitedata['domain3']){?><option <?php if($zar['domain']==$sitedata['domain3']) echo 'selected';?>><?php echo $sitedata['domain3'] ?></option><?php } ?>
<?php if($sitedata['domain4']){?><option <?php if($zar['domain']==$sitedata['domain4']) echo 'selected';?>><?php echo $sitedata['domain4'] ?></option><?php } ?>
</select> : 
<select name="p">
<?php
$port = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE name='$overallowner'"));
$porta = range( $port['pstart'], $port['pend'] );
foreach ( $porta as $portb ) {
  ?><option <?php if ($zar['p'] == $portb) { echo "selected"; } ?>><?php
  echo "$portb"?></option><?php
  }
?></select> Port (which port to listen on) <br>
</fieldset><br>
<fieldset>
 <legend>Plugins</legend>
 <select>
 <option value="">None</option>
 <?php
 $plugins = mysql_query("SELECT plugins FROM settings");
 $plugin = mysql_fetch_array($plugins);
 $pluginarray = explode("\n",$plugin[0]);
 $i = 0;
foreach($pluginarray as $plugin) {
  if($i % 2)
  {
  ?>
  <option value="<?php echo trim($pluginarray[$i]); ?>"><?php echo trim($pluginarray[$i-1]); ?></option>
  <?php
  }
  $i++;
  }
?>
 </select>
</fieldset><br>
<fieldset>
 <legend>Miscellaneous Settings</legend>
 <input name="disablebots" type="checkbox" value="1" <?php if($zar['disablebots']=='1') echo 'checked';?>> Disable Bots<br>
 <?php if($_SESSION['perm'][33]){?><input name="disablemaster" type="checkbox" value="1" <?php if($zar['disablemaster']=='1') echo 'checked';?>> Disable Master Conf<br><?php } ?>
<?php
//<input name="owncmd" type="text" size="50" > Own Command Line Options<br>
?><br>
 Server message goes here, one per line <br><textarea type="text" cols="50" rows="10" name="servermsg">
<?php echo $zar['servermsg']?>
</textarea><br><br>
 Ad message goes here, one per line <br><textarea type="text" cols="50" rows="10" name="admsg">
<?php echo $zar['admsg']?>
</textarea><br>
<?php if($_SESSION['perm'][32]){ ?><br>Custom Conf Options:<br><textarea type="text" cols=50 rows=10 name="custom"><?php echo $zar['custom'] ?></textarea><br> <?php } ?>
</fieldset>
<br>
<center>
<input value="           Save           " type="submit" >
</center>
</form>
</div>
<?php
	} else {
		echo "This isnt your conf";
	}
}
} else {
//If not a conf edit, check for a file edit.
if($_GET['mode']=='file'){
	//Edit file here
	$idc = sanitize($_GET['file']);
	if($_POST){
		$q = mysql_query("SELECT * FROM files WHERE id='$idc'");
		$qr = mysql_fetch_array($q);
		if ($qr['type']!=='bandb') $cc = sanitize($_POST['contents']);
		$nc = sanitize($_POST['name']);
		if(mysql_query("UPDATE files SET `name`='$nc', `contents`='$cc' WHERE id='$idc'"))
		echo "Updated successfully!<br><br>";
		echo mysql_error();
	}
	$q = mysql_query("SELECT * FROM files WHERE id='$idc'");
	$qr = mysql_fetch_array($q);
	if($name == $qr['owner'] && $_SESSION['perm'][26] || $_SESSION['perm'][12]){
		?>
<form action="?p=edit&mode=file&file=<?php echo $idc ?>" method="POST">
Name: <input name="name" value="<?php echo $qr['name'] ?>" type="text">
<br>
Contents:
<br><textarea name="contents" cols="40" rows="15" <?php if ($qr['type']=='bandb') echo 'readonly';?>><?php echo $qr['contents']; ?></textarea>
<br>
<input value="Save" type="submit" >

</form>
<?php
} else {
	echo "This isnt your file";
}
}
}
?>