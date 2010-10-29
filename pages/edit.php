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
if($_GET['mode']=='conf')
{
	if(!$_GET['server'] || !$_GET['group'])
		echo "Error encountered, contact support";
	else
	{
		$server_clean = $_GET['server'];
		$group_clean = $_GET['group'];
		$groupData = mysql_query("SELECT * FROM groups WHERE `id`='$group_clean'");
		$serverData = mysql_query("SELECT * FROM servers WHERE `master`='$group_clean' AND `id`='$server_clean'");
		$groupData = mysql_fetch_array($groupData);
		$serverData = mysql_fetch_array($serverData);
		if($name == $groupData['owner'] && $_SESSION['perm'][21] || $_SESSION['perm'][22])
		{
			$overallowner = $groupData['owner'];		
			if($_POST['save'])
			{
				$varscheck = Array($_POST['msv'],$_POST['rogue'],$_POST['red'],$_POST['green'],$_POST['blue'],$_POST['purple'],$_POST['observer'],$_POST['fa'],$_POST['fcl'],$_POST['frf'],$_POST['fg'],$_POST['fgm'],$_POST['fib'],$_POST['fl'],$_POST['fmg'],$_POST['fn'],$_POST['foo'],$_POST['fpz'],$_POST['fqt'],$_POST['fsb'],$_POST['fse'],$_POST['fsh'],$_POST['fsr'],$_POST['fst'],$_POST['fsw'],$_POST['ft'],$_POST['fth'],$_POST['fus'],$_POST['fv'],$_POST['fwg'],$_POST['worldsize'],$_POST['p'],$_POST['sa'],$_POST['st'],$_POST['sw']);
				foreach ($varscheck as $element)
				{
					if (!is_numeric($element) && $element)
					{
						echo "Alphabetic characters detected";
						include_once('./include/footer.php');
	 				}
				}
				$port = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE name='$overallowner'"));
				if($_POST['p'] < $port['pstart'] || $_POST['p'] > $port['pend'])
					die("That is not your port.");

				$flags = json_decode(stripslashes($_POST['Flags']), true);
				mysql_query("UPDATE servers SET `name`='".$_POST['name']."',`style`='".$_POST['style']."',`j`='".$_POST['j']."',`r`='".$_POST['r']."',`ms`='".$_POST['ms']."',`noradar`='".$_POST['noradar']."',`autoteam`='".$_POST['autoteam']."',`mp`='".$_POST['mp']."',`rogue`='".$_POST['rogue']."',`red`='".$_POST['red']."',`green`='".$_POST['green']."',`blue`='".$_POST['blue']."',`purple`='".$_POST['purple']."',`observer`='".$_POST['observer']."',`user`='".$_POST['user']."',`group`='".$_POST['group']."',`ban`='".$_POST['ban']."',`report`='".$_POST['report']."',`nomasterban`='".$_POST['nomasterban']."',`agility`='".$flags['Agility']."',`burrow`='".$flags['Burrow']."',`cloaking`='".$flags['Cloaking']."',`genocide`='".$flags['Genocide']."',`guided missile`='".$flags['Guided Missile']."',`high speed`='".$flags['High Speed']."',`identify`='".$flags['Identify']."',`invisible bullet`='".$flags['Invisible Bullet']."',`jumping`='".$flags['Jumping']."',`laser`='".$flags['Laser']."',`machine gun`='".$flags['Machine Gun']."',`masquerade`='".$flags['Masquerade']."',`narrow`='".$flags['Narrow']."',`oscillation overthruster`='".$flags['Oscillation Overthruster']."',`phantom zone`='".$flags['Phantom Zone']."',`quick turn`='".$flags['Quick Turn']."',`rapid fire`='".$flags['Rapid Fire']."',`ricochet`='".$flags['Ricochet']."',`seer`='".$flags['Seer']."',`shield`='".$flags['Shield']."',`shock wave`='".$flags['Shock Wave']."',`stealth`='".$flags['Stealth']."',`steam roller`='".$flags['Steam Roller']."',`super bullet`='".$flags['Super Bullet']."',`thief`='".$flags['Thief']."',`tiny`='".$flags['Tiny']."',`useless`='".$flags['Useless']."',`wings`='".$flags['Wings']."',`blindness`='".$flags['Blindness']."',`bouncy`='".$flags['Bouncy']."',`colorblindness`='".$flags['Colorblindness']."',`forward only`='".$flags['Forward Only']."',`jamming`='".$flags['Jamming']."',`left turn only`='".$flags['Left Turn Only']."',`momentum`='".$flags['Momentum']."',`no jumping`='".$flags['No Jumping']."',`obesity`='".$flags['Obesity']."',`reverse controls`='".$flags['Reverse Controls']."',`reverse only`='".$flags['Reverse Only']."',`right turn only`='".$flags['Right Turn Only']."',`trigger happy`='".$flags['Trigger Happy']."',`wide angle`='".$flags['Wide Angle']."',`red flag`='".$flags['Red Flag']."',`green flag`='".$flags['Green Flag']."',`blue flag`='".$flags['Blue Flag']."',`purple flag`='".$flags['Purple Flag']."',`fb`='".$_POST['fb']."',`sb`='".$_POST['sb']."',`sa`='".$_POST['sa']."',`st`='".$_POST['st']."',`sw`='".$_POST['sw']."',`worldfile`='".$_POST['worldfile']."',`b`='".$_POST['b']."',`h`='".$_POST['h']."',`worldsize`='".$_POST['worldsize']."',`public`='".$_POST['public']."',`p`='".$_POST['p']."',`domain`='".$_POST['domain']."',`disablebots`='".$_POST['disablebots']."',`servermsg`='".$_POST['servermsg']."',`admsg`='".$_POST['admsg']."',`custom`='".$_POST['custom']."',`disablemaster`='".$_POST['disablemaster']."' WHERE `id`='$server_clean'");
}
				$serverData = mysql_query("SELECT * FROM servers WHERE `id`='$server_clean'");
				$serverData = mysql_fetch_array($serverData);
?>
<script type="text/javascript">
  window.addEvent("domready", function()
  {
<?php if($serverData['agility']){ echo'	AddFlag("Agility",'; echo $serverData['agility'];?>); <?php } ?>
<?php if($serverData['burrow']){ echo'	AddFlag("Burrow",'; echo $serverData['burrow'];?>); <?php } ?>
<?php if($serverData['cloaking']){ echo'	AddFlag("Cloaking",'; echo $serverData['cloaking'];?>); <?php } ?>
<?php if($serverData['genocide']){ echo'	AddFlag("Genocide",'; echo $serverData['genocide'];?>); <?php } ?>
<?php if($serverData['guided missile']){ echo'	AddFlag("Guided Missile",'; echo $serverData['guided missile'];?>); <?php } ?>
<?php if($serverData['high speed']){ echo'	AddFlag("High Speed",'; echo $serverData['high speed'];?>); <?php } ?>
<?php if($serverData['identify']){ echo'	AddFlag("Identify",'; echo $serverData['identify'];?>); <?php } ?>
<?php if($serverData['invisible bullet']){ echo'	AddFlag("Invisible Bullet",'; echo $serverData['invisible bullet'];?>); <?php } ?>
<?php if($serverData['jumping']){ echo'	AddFlag("Jumping",'; echo $serverData['jumping'];?>); <?php } ?>
<?php if($serverData['laser']){ echo'	AddFlag("Laser",'; echo $serverData['laser'];?>); <?php } ?>
<?php if($serverData['machine gun']){ echo'	AddFlag("Machine Gun",'; echo $serverData['machine gun'];?>); <?php } ?>
<?php if($serverData['masquerade']){ echo'	AddFlag("Masquerade",'; echo $serverData['masquerade'];?>); <?php } ?>
<?php if($serverData['narrow']){ echo'	AddFlag("Narrow",'; echo $serverData['narrow'];?>); <?php } ?>
<?php if($serverData['oscillation overthruster']){ echo'	AddFlag("Oscillation Overthruster",'; echo $serverData['oscillation overthruster'];?>); <?php } ?>
<?php if($serverData['phantom zone']){ echo'	AddFlag("Phantom Zone",'; echo $serverData['phantom zone'];?>); <?php } ?>
<?php if($serverData['quick turn']){ echo'	AddFlag("Quick Turn",'; echo $serverData['quick turn'];?>); <?php } ?>
<?php if($serverData['rapid fire']){ echo'	AddFlag("Rapid Fire",'; echo $serverData['rapid fire'];?>); <?php } ?>
<?php if($serverData['ricochet']){ echo'	AddFlag("Ricochet",'; echo $serverData['ricochet'];?>); <?php } ?>
<?php if($serverData['seer']){ echo'	AddFlag("Seer",'; echo $serverData['seer'];?>); <?php } ?>
<?php if($serverData['shield']){ echo'	AddFlag("Shield",'; echo $serverData['shield'];?>); <?php } ?>
<?php if($serverData['shock wave']){ echo'	AddFlag("Shock Wave",'; echo $serverData['shock wave'];?>); <?php } ?>
<?php if($serverData['stealth']){ echo'	AddFlag("Stealth",'; echo $serverData['stealth'];?>); <?php } ?>
<?php if($serverData['steam roller']){ echo'	AddFlag("Steam Roller",'; echo $serverData['steam roller'];?>); <?php } ?>
<?php if($serverData['super bullet']){ echo'	AddFlag("Super Bullet",'; echo $serverData['super bullet'];?>); <?php } ?>
<?php if($serverData['thief']){ echo'	AddFlag("Thief",'; echo $serverData['thief'];?>); <?php } ?>
<?php if($serverData['tiny']){ echo'	AddFlag("Tiny",'; echo $serverData['tiny'];?>); <?php } ?>
<?php if($serverData['useless']){ echo'	AddFlag("Useless",'; echo $serverData['useless'];?>); <?php } ?>
<?php if($serverData['wings']){ echo'	AddFlag("Wings",'; echo $serverData['wings'];?>); <?php } ?>
<?php if($serverData['blindness']){ echo'	AddFlag("Blindness",'; echo $serverData['blindness'];?>); <?php } ?>
<?php if($serverData['bouncy']){ echo'	AddFlag("Bouncy",'; echo $serverData['bouncy'];?>); <?php } ?>
<?php if($serverData['colorblindness']){ echo'	AddFlag("Colorblindness",'; echo $serverData['colorblindness'];?>); <?php } ?>
<?php if($serverData['forward only']){ echo'	AddFlag("Forward Only",'; echo $serverData['forward only'];?>); <?php } ?>
<?php if($serverData['jamming']){ echo'	AddFlag("Jamming",'; echo $serverData['jamming'];?>); <?php } ?>
<?php if($serverData['left turn only']){ echo'	AddFlag("Left Turn Only",'; echo $serverData['left turn only'];?>); <?php } ?>
<?php if($serverData['momentum']){ echo'	AddFlag("Momentum",'; echo $serverData['momentum'];?>); <?php } ?>
<?php if($serverData['no jumping']){ echo'	AddFlag("No Jumping",'; echo $serverData['no jumping'];?>); <?php } ?>
<?php if($serverData['obesity']){ echo'	AddFlag("Obesity",'; echo $serverData['obesity'];?>); <?php } ?>
<?php if($serverData['reverse controls']){ echo'	AddFlag("Reverse Controls",'; echo $serverData['reverse controls'];?>); <?php } ?>
<?php if($serverData['reverse only']){ echo'	AddFlag("Reverse Only",'; echo $serverData['reverse only'];?>); <?php } ?>
<?php if($serverData['right turn only']){ echo'	AddFlag("Right Turn Only",'; echo $serverData['right turn only'];?>); <?php } ?>
<?php if($serverData['trigger happy']){ echo'	AddFlag("Trigger Happy",'; echo $serverData['trigger happy'];?>); <?php } ?>
<?php if($serverData['wide angle']){ echo'	AddFlag("Wide Angle",'; echo $serverData['wide angle'];?>); <?php } ?>
<?php if($serverData['red flag']){ echo'	AddFlag("Red Flag",'; echo $serverData['red flag'];?>); <?php } ?>
<?php if($serverData['green flag']){ echo'	AddFlag("Green Flag",'; echo $serverData['green flag'];?>); <?php } ?>
<?php if($serverData['blue flag']){ echo'	AddFlag("Blue Flag",'; echo $serverData['blue flag'];?>); <?php } ?>
<?php if($serverData['purple flag']){ echo'	AddFlag("Purple Flag",'; echo $serverData['purple flag'];?>); <?php } ?>
  });
</script>
<form method="GET">
	<input type="hidden" name="p" value="servers">
	<input type="submit" value="Back">
</form>
<br>
<form action="" method="post">
Name: <input type="text" name="name" value="<?php echo $serverData['name']; ?>"><br>
<center><input value="Save" type="submit" ></center>
<input type="hidden" name="save" value="1">
<fieldset><legend>Gameplay Settings</legend>
	<select name="style">
		<option value="gtn" <?php if($serverData['style']=='gtn') echo 'selected';?>>None (FFA)</option>
		<option value="gtc" <?php if($serverData['style']=='gtc') echo 'selected';?>>Capture The Flag</option>
		<option value="gtcr" <?php if($serverData['style']=='gtcr') echo 'selected';?>>Capture The Flag Random Map</option>
		<option value="gtrs" <?php if($serverData['style']=='gtrs') echo 'selected';?>>Rabbit Chase: Score Rabbit</option>
		<option value="gtrk" <?php if($serverData['style']=='gtrk') echo 'selected';?>>Rabbit Chase: Killer Rabbit</option>
		<option value="gtrr" <?php if($serverData['style']=='gtrr') echo 'selected';?>>Rabbit Chase: Random Rabbit</option>
	</select> Game Type<br>
	<input name="j" type="checkbox" value="1" <?php if($serverData['j']=='1') echo 'checked';?>> Jumping<br>
	<input name="r" type="checkbox" value="1" <?php if($serverData['r']=='1') echo 'checked';?>> Ricochet<br>
	<input name="noradar" type="checkbox" value="1" <?php if($serverData['noradar']=='1') echo 'checked';?>> No Radar<br>
	Max Shots <input type="text" size="2" maxlength="2" name="ms" value="<?php echo $serverData['ms'];?>"><br>
</fieldset>
<br>
<fieldset><legend>Player and Team Settings</legend>
	<input name="autoteam" type="checkbox" value="1" <?php if($serverData['autoteam']=='1') echo 'checked';?>> Autoteam<br>
	<fieldset><legend>Maximum Players</legend>
		<input name="rogue" type="text" size="2" maxlength="3" value="<?php echo $serverData['rogue'];?>"> Rogues<br>
		<input name="red" type="text" size="2" maxlength="3" value="<?php echo $serverData['red'];?>"> Reds<br>
		<input name="green" type="text" size="2" maxlength="3" value="<?php echo $serverData['green'];?>"> Greens<br>
		<input name="blue" type="text" size="2" maxlength="3" value="<?php echo $serverData['blue'];?>"> Blues<br>
		<input name="purple" type="text" size="2" maxlength="3" value="<?php echo $serverData['purple'];?>"> Purples<br>
		<input name="observer" type="text" size="2" maxlength="3" value="<?php echo $serverData['observer'];?>"> Observers<br>
	</fieldset>
	<br>
	<select name ="group">
		<option value="0">None</option>
		<?php
		$groupData = mysql_query("SELECT * FROM files WHERE owner='$overallowner' AND type='groupdb'");
		while($groupdb = mysql_fetch_array($groupData))
			echo '<option value="' . $groupdb['id'] . '"' . ($serverData['group'] == $groupdb['id'] ? ' selected' : '') . '>'.$groupdb['name'].'</option>';
		?>
	</select> Group Database
	<br>
	<select name ="ban">
		<option>None</option>
		<?php
		foreach (glob("banfiles/$overallowner/*") as $filename) {
			$filereal = substr($filename, strlen("banfiles/$overallowner/"));
			echo '<option' . ($serverData['ban'] == $filereal ? ' selected' : '') . '>'.$filereal.'</option>';
		}
		?>
	</select> Ban Database
	<br>
	<input name="user" type="checkbox" value="1"<?php if($serverData['user']=='1') echo ' checked';?>> User Database
	<br>
	<input name="nomasterban" type="checkbox" value="1" <?php if($serverData['nomasterban']=='1') echo 'checked';?>> No Master Banlist<br>
</fieldset>
<br>
<fieldset><legend>Flag Settings</legend>
	<div style="text-align: center; overflow: hidden;">
		<div style="float: left; clear: left; width: 43%">
			<span>Press "Add" or double click to add <input type="text" id="NumFlagsToAdd" maxlength="2" value="1" style="width: 1.5em"> flag(s).</span>
			<input type="button" value="Add" style="width: 100%" id="AddButton">
			<select id="AvailableFlagList" multiple size="15" style="width: 100%;"></select>
			<table>
				<tr>
					<td><input name="fb" type="checkbox" value="1" <?php if($serverData['fb']=='1') echo 'checked';?>> Flags Spawn on Buildings<br></td><td><input name="sb" type="checkbox" value="1" <?php if($serverData['sb']=='1') echo 'checked';?>> Tanks Spawn on Buildings<br></td><td><input name="sa" type="checkbox" value="1" <?php if($serverData['sa']=='1') echo 'checked';?>> Spawn Antidote Flags<br></td>
				</tr>
			</table>
		</div>
		<div style="float: right; width: 43%">
			<span>Press "Remove" or double click to remove <input type="text" id="NumFlagsToRemove" maxlength="2" value="1" style="width: 1.5em"> flag(s).</span>
			<input type="button" value="Remove" style="width: 100%" id="RemoveButton">
			<select id="FlagList" multiple size="15" style="width: 100%;"></select>
			Drop bad flag after <input name="st" type="text" maxlength="2" style="width: 1.5em;" value="<?php echo $serverData['st'];?>"> secs<br>
			Drop bad flag after <input name="sw" type="text" maxlength="2" style="width: 1.5em;" value="<?php echo $serverData['sw'];?>"> wins<br>
		</div>
	<div style="text-align: center; float: left; margin-right:15px; margin-left:15px; width: 10%">
		<br><br><br>
		Use the flag selector to manipulate flags. The left box contains all the flags while the right box contains the flags on your server.
	</div>
	<input type="hidden" name="Flags" id="Flags" value="{}">
</div>
</fieldset>
<br>
<fieldset><legend>World Settings</legend>
	<?php
	if(!$serverData['b'] && !$serverData['h'] && !$serverData['worldsize'])
		$world = 1;
	else
		$world = 2;
	?>
	<fieldset><legend><input type="radio" name="myRadioButton" onclick="b.disabled=true; h.disabled=true; b.checked=false; h.checked=false; worldsize.disabled=true; worldsize.value='0'; worldfile.disabled=false; worldfile.value='<?php echo $serverData['worldfile'];?>';" <?php if($world=='1') echo ' checked'; ?>> Map File</legend>
		<select name="worldfile" <?php if($world=='2') echo ' disabled'; ?>>
			<option value="0" disabled>None</option>
			<?php
			$mapq = mysql_query("SELECT * FROM files WHERE owner='$overallowner' AND type='bzw'");
			while($mapfile = mysql_fetch_array($mapq))
			{
				echo '<option value="'.$mapfile['id'].'"'.($serverData['worldfile'] == $mapfile['id'] ? ' selected' : '') .'>'.$mapfile['name'].'</option>'."\n";
			}
			?>
		</select> Map File
		<br>
	</fieldset>
	<fieldset><legend><input type="radio" name="myRadioButton" onclick="b.disabled=false; h.disabled=false; worldsize.disabled=false; worldfile.disabled=true; worldfile.value='0';" <?php if($world == '2') echo ' checked'; ?>> Random Map</legend>
		<input name="b" type="checkbox" value="1" <?php if($serverData['b']=='1') echo 'checked'; if($world == '1') echo ' disabled';?>> Random Rotation<br>
		<input name="h" type="checkbox" value="1" <?php if($serverData['h']=='1') echo 'checked'; if($world == '1') echo ' disabled';?>> Random Height<br>
		<input type="text" name="worldsize" size="3" maxlength="4" value="<?php echo $serverData['worldsize'].'"'; if($world == '1') echo ' disabled';?>> World Size, if not set 400 is used<br>
	</fieldset>
</fieldset>
<br>
<fieldset><legend>Public Settings</legend>
	<input type="text" name="public" size="35" maxlength="60" value="<?php echo $serverData['public']?>"> The name of the server<br>
	<select name="domain">
		<?php if($sitedata['domain1']){?><option <?php if($serverData['domain']==$sitedata['domain1']) echo 'selected';?>><?php echo $sitedata['domain1'] ?></option><?php } ?>
		<?php if($sitedata['domain2']){?><option <?php if($serverData['domain']==$sitedata['domain2']) echo 'selected';?>><?php echo $sitedata['domain2'] ?></option><?php } ?>
		<?php if($sitedata['domain3']){?><option <?php if($serverData['domain']==$sitedata['domain3']) echo 'selected';?>><?php echo $sitedata['domain3'] ?></option><?php } ?>
		<?php if($sitedata['domain4']){?><option <?php if($serverData['domain']==$sitedata['domain4']) echo 'selected';?>><?php echo $sitedata['domain4'] ?></option><?php } ?>
	</select> : 
	<select name="p">
		<?php
		$portQuery = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE name='$overallowner'"));
		$portArray = range( $portQuery['pstart'], $portQuery['pend'] );
		foreach ($portArray as $port)
		{
			echo '<option'.($serverData['p'] == $port ? ' selected' : '').'>'.$port.'</option>';
		}
		?>
	</select> Port (which port to listen on)
	<br>
</fieldset>
<br>
<fieldset><legend>Plugins</legend>
	<select>
		<option value="">None</option>
		<?php
		$plugins = mysql_query("SELECT plugins FROM settings");
		$plugin = mysql_fetch_array($plugins);
		$pluginarray = explode("\n",$plugin[0]);
		$i = 0;
		foreach($pluginarray as $plugin)
		{
			if($i % 2)
				echo '<option value='.trim($pluginarray[$i]).'">'.trim($pluginarray[$i-1]).'</option>';
  			$i++;
  		}
		?>
	</select>
</fieldset>
<br>
<fieldset><legend>Miscellaneous Settings</legend>
	<input name="disablebots" type="checkbox" value="1" <?php if($serverData['disablebots']=='1') echo 'checked';?>> Disable Bots<br>
	<?php if($_SESSION['perm'][33]) echo '<input name="disablemaster" type="checkbox" value="1"' . ($serverData['disablemaster'] == '1' ? ' checked' : '') . '>Disable Master Conf<br>'; ?>
	<br>
	Server message goes here, one per line <br><textarea type="text" cols="50" rows="10" name="servermsg"><?php echo $serverData['servermsg']?></textarea><br><br>
	Ad message goes here, one per line <br><textarea type="text" cols="50" rows="10" name="admsg"><?php echo $serverData['admsg']?></textarea><br>
	<?php if($_SESSION['perm'][32]) echo '<br>Custom Conf Options:<br><textarea type="text" cols=50 rows=10 name="custom">'.$serverData['custom'].'</textarea><br>'; x?>
</fieldset>
<br>
<center><input value="Save" type="submit" ></center>
</form>
</div>
<?php
		}
		else
			echo 'This isn\'t your conf';
	}
}
else
{
	if($_GET['mode']=='file')
	{
		$id = $_GET['file'];
		if($_POST)
		{
			$contents = $_POST['contents'];
			$fileName = $_POST['name'];
			if(mysql_query("UPDATE files SET `name`='$fileName', `contents`='$contents' WHERE id='$id'"))
				echo 'Updated successfully!<br><br>';
		}
		$q = mysql_query("SELECT * FROM files WHERE id='$id'");
		$qr = mysql_fetch_array($q);
		if($name == $qr['owner'] && $_SESSION['perm'][26] || $_SESSION['perm'][12])
		{
		?>
<form action="?p=edit&mode=file&file=<?php echo $id ?>" method="POST">
Name: <input name="name" value="<?php echo $qr['name'] ?>" type="text">
<br>
Contents:
<br><textarea name="contents" cols="40" rows="15" <?php if ($qr['type']=='bandb') echo 'readonly';?>><?php echo $qr['contents']; ?></textarea>
<br>
<input value="Save" type="submit" >

</form>
<?php
		}
		else
			echo 'This isn\'t your file';
	}
}
?>