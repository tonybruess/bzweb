		<?php
		if($_POST)
		{
			$token = file_get_contents('http://my.bzflag.org/db/?action=GETTOKEN&callsign='.$_POST['name'].'&password='.$_POST['pass']);
			$token = explode(' ', $token);
			if($token[1] != 'invalid')
			{
				$user = mysql_query("SELECT * FROM users WHERE `name`='".$_POST['name']."'");
				$user = mysql_fetch_array($user);
				if($user['name'])
				{
					$ts = time();
					$_SESSION['callsign'] = $user['name'];
					$_SESSION['id'] = $user['id'];
					$_SESSION['pass'] = $token[1];
					header("Location: index.php");
					mysql_query("UPDATE users SET `last login`='$ts' WHERE `name`='".$_SESSION['callsign']."'");
				}
				else
					echo '<div id="info"><h3>No Permission</h3>Your login information was correct, but you do not have any permissions on this server.<br></div>';					
			}
			else
				echo '<div id="info"><h3>No Permission</h3>The username and/or password you entered were incorrect.<br></div>';
		}
		?>
		<h3>Login</h3>
		<form method="post">
		Name: <input type="text" name="name">
		<br><br>
		Password: <input type="password" name="pass">
		<br><br>
		<input type="submit" value="Login">
		<br><br>
		<small>BZWeb and <?php echo $sitedata['site']; ?> do not store your personal information. 
		</form>