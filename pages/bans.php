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
if(!$_POST){
	$banned = '../';
} else {
	$banned = $_POST['banfile'];
}
?>
				<h3>Bans</h3>
<br>
<form method="post">
<?php if($_SESSION['perm'][14]){?>
<b>User:</b> <select name="uid" onchange="this.form.submit();">
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
<br>
<?php }
?>
	<b>Ban File:</b>
	<select name="banfile" onchange="this.form.submit();">
	<option value="../">None</option>
	<?php
$array = glob("banfiles/$name/*");
foreach ($array as $filename) {
	$l = strlen("banfiles/$name/");
	$filereal = substr($filename,$l);
 	$postedfile = substr($_POST['banfile'],$l);
   echo "<option value=\"$filename\"";
    if($filereal==$postedfile) echo ' selected';
    echo ">$filereal</option>";
}
?>

	</select>
</form>
<br>
<table width="100%">
				 <tr>
				  <th>Type</th>
				  <th>Ban</th>
				  <th>Length</th>
				  <th>Banner</th>
				  <th>Reason</th>
				 </tr>
<?php
$banfile = file($banned);
foreach($banfile as $line){
			$count++;
			$type = NULL;
			list($q1, $q2, $q3, $q4) = explode(".", $line) ;
			// We don't check q4 because we already know its an ip
			if (is_numeric($q1) && (is_numeric($q2) || $q2 == "*") && (is_numeric($q3) || $q3 == "*")) {
				// This is an IP.
				$type = 'IP';
				$count = '1';
				$data = "$q1.$q2.$q3.$q4";
			} elseif (strstr($line,"host:")) {
				$type = 'Hostban';
				$count = '1';
				$data = explode(":",$line);
				$data = $data[1];
			} elseif (strstr($line,"bzid:")) {
				$type = 'BZID';
				$count = '1';
				$data = explode(":",$line);
				$data = $data[1];
			}
			if($count=='1'){
				$temp_results .= '<tr class="a" bgcolor=#CCCCCC><td style="text-align: center;">'.$type.'</td>';
				$temp_results .= '<td style="text-align: center;">'.$data.'</td>';
			}
			if($count=='2'){
				$data = explode(":",$line);
				$data = $data[1];
				$temp_results .= '<td style="text-align: center;">'.$data.'</td>';
			}
			if($count=='3'){
				$data = explode(":",$line);
				$data = $data[1];
				preg_match("/(banner:)(.*)/",$line,$match);
				$match[2] = $data;
				$temp_results .= '<td style="text-align: center;">'.$data.'</td>';
			}
			if($count=='4'){
				$data = explode(":",$line);
				$data = $data[1];
				preg_match("/(banner:)(.*)/",$line,$match);
				$match[2] = $data;
				$temp_results .= '<td style="text-align: center;">'.$data.'</td></tr>';
			}
}
echo $temp_results;
$name = $_SESSION['name'];
?>
</table>