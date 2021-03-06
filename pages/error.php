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
			<?php if($_SESSION['callsign']){ ?>
			<meta HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php">
			<?php
			} else {
			if($_GET['error'] == "1") {  ?>
				<h3>Access Denied</h3>
				<p>Please <a href="index.php">login</a> before attempting to access this page</p>
			<?php } else { if($_GET['error'] == "2") {  ?>
				<h3>Logout Successful</h3>
				<p>You have successfully logged out. Would you like to <a href="index.php">login</a> again?</p>
			<?php } else { if($_GET['error'] == "3") {  ?>
				<h3>No Permission</h3>
				<p>Your account has been temporarily disabled by an administrator. Please contact <?php echo $sitedata['email'] ?> for more information</p>
			<?php } else { if($_GET['error'] == "4") {  ?>
				<h3>No Permission</h3>
				<p>Your username and password was correct, but you do not have any permissions on this server.</p>
				<p>If you believe this message is in error, please contact <?php echo $sitedata['email'] ?> for more information</p>
			<?php } else { if(!$_GET['error']) {  ?>
				<h3>Please login</h3>
				<p>Please <a href="index.php">login</a></p>
			<?php } else { if($_GET['mode'] == "") {  ?>
				<h3>Unknown Error</h3>
				<p>Please contact <?php echo $sitedata['email'] ?> with error code: <?php echo $_GET['error'].rand(100000,999999); ?> </p>
			<?php 
			}
			}
			}
			}
			}
			}
			}
			?>