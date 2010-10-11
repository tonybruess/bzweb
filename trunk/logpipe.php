<?php
/*
    BZWeb v1.0
    Copyright (c) 2010 Tony Bruess

	BZWeb is an online based tool developed by mrapple which allows multiple users to manage bzfs instances.
	For questions, join #bzextreme on irc.freenode.net and ask mrapple.

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

/* Thanks Constitution!! */

chdir("../../");
$name = $argv[3];
require "config.php";
$stdin=fopen('php://stdin','r');
$stderr=fopen('php://stderr','r');
set_time_limit(0);
stream_set_timeout($stdin,0);
stream_set_blocking($stdin,0);

// we need to ping MySQL every 10 minutes to keep it alive
$lastPing = time();

	file_put_contents("logpipe.log", "something here");
// make sure the server id is specified
if($argc < 2 || ! is_numeric($argv[1]))
	die("A server id must be specified.\n");

// continuously read from $stdin and pipe to the log database
while(! feof($stdin)) {
	// attempt to read from $stdin
	$line = trim(fgets($stdin));

	// if no data, make sure we at least ping the database every now and then
	if(strlen($line) == 0) {
		if($lastPing < time() - 600) {
			mysql_query("DO 0");
			$lastPing = time();

		}

		sleep(1);
		continue;
	}

	$entities = array();
	preg_match("/(\d+)-(\d+)-(\d+)\s(\d+):(\d+):(\d+):\s(\w+(-\w+)?)\s(.*)/",$line,$entities);
	// formate the timestamp
	$ts = mktime($entities[4],$entities[5],$entities[6],$entities[2],$entities[3],$entities[1]);

	if(count($entities) > 1)
		mysql_query("INSERT INTO ".$argv[1]."serverlogs SET ".
				"server=".$argv[1].",".
				"time=".$ts.",".
				"type=\"".mysql_real_escape_string($entities[7])."\",".
				"data=\"".mysql_real_escape_string($entities[9])."\"");
	else if(preg_match("/\S/",$line) == 1)
		// if we can't parse it and it's something other than whitespace, log it
		fwrite($stderr,"Unable to parse server log entry: ".$line."\n");

	// do other logic depending on entry type
	if($entities[7] == "PLAYER-JOIN") {
		// also enter players into players table, avoiding duplicates
		$player = array();
		preg_match("/^\d+:(.*)\s#\d+\s(BZid:(\d*)\s)?\w+\sIP:(\d+(\.\d+)+)\s?(\w+(\s\w+)*)?$/",$entities[9],$player);

		if(count($player) == 0)
			fwrite($stderr,"Could not parse player join: ".$entities[9]."\n");

		$q = mysql_query("SELECT * FROM players WHERE `name`='$player[1]' AND `ip`='$player[4]' AND `description`='$player[6]'");
		$oldrecord = mysql_fetch_array($q);
		if($oldrecord[0]) {
			// verify the existing record to make sure the last seen time are up-to-date
			if($oldrecord['time'] < $ts) {
				mysql_query("UPDATE players SET ".
						"time=".$ts." WHERE ".
						"name=\"".$player[1]."\" AND ".
						"ip=\"".$player[4]."\" AND ".
						"serverowner=\"".$name."\" AND ".
						"description".($player[6] != "" ? "=\"".$player[6]."\"" : " IS NULL"));
			}
		} else {
			// insert a new player record
			$host = gethostbyaddr($player[4]);
			mysql_query("INSERT INTO players SET `serverowner`='$name', `name`='$player[1]',`ip`='$player[4]',`host`='$host',`description`='$player[6]',`bzid`='$player[3]',`time`='$ts'");
		}
	}
	if($entities[7] == 'MSG-COMMAND' && preg_match("/^\d+:(.*?) ban (^\d+$.^\d+$.^\d+$.^\d+$|(.*?)) ([^ ]*) (.*)/",$entities[9],$ban)){
		if(is_numeric($ban[2]) && is_numeric($ban[3]) && is_numeric($ban[4]) && is_numeric($ban[5])){
		mysql_query("INSERT INTO bans SET `server` = '$argv[1]', `banner`= '$ban[1]', `ip` = '$ban[2].$ban[3].$ban[4].$ban[5]', `length` = '$ban[6]', `reason` = '$ban[7]', `time` = '$ts'");
		} else {
					mysql_query("INSERT INTO bans SET `server` = '$argv[1]', `banner`= '$ban[1]', `ip` = '$ban[2]', `length` = '$ban[4]', `reason` = '$ban[5]', `time` = '$ts'");
		}
	}
	if($entities[7] == 'MSG-REPORT' && preg_match("/(.*?):(.*?$)/",$entities[9],$report)){
         $justmessage = substr($report[2],$report[1]);
         $entirelength = strlen($report[2]);
         $actuallength = ($entirelength - $report[1]);
         $justuser = substr($report[2],0,-$actuallength);
		mysql_query("INSERT INTO reports SET `server` = '$argv[1]', `serverowner` = '$name', `reporter`= '$justuser', `report` = '$justmessage', `time` = '$ts'");
	}

}
mysql_query("DELETE FROM ".$argv[1]."serverlogs WHERE `type`='SERVER-STATUS' AND `data`='Running' AND `time`='$ts'");
//Insert into logs that the server is done
mysql_query("INSERT INTO ".$argv[1]."serverlogs SET `server` = '$argv[1]', `type` = 'SERVER-STATUS', `data` = 'Stopped', `time` = '$ts'");

exit;
?>