<?php

chdir("../../");
require "include/mysql.php";
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
		mysql_query("INSERT INTO serverlogs SET ".
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

		$q = mysql_query("SELECT * FROM players WHERE `name`='$player[1]' AND `ip`='$player[4]'");
		$oldrecord = mysql_fetch_array($q);
			fwrite($stderr,"Error while grabbing data ".$oldrecord[1]);
		if($oldrecord[0]) {
			// verify the existing record to make sure the last seen time are up-to-date
			if($oldrecord['time'] < $ts) {
				mysql_query("UPDATE players SET ".
						"time=".$ts." WHERE ".
						"name=\"".$player[1]."\" AND ".
						"ip=\"".$player[4]."\" AND ".
						"description".($player[6] != "" ? "=\"".$player[6]."\"" : " IS NULL"));
			}
		} else {
			// insert a new player record
			$host = gethostbyaddr($player[4]);
			mysql_query("INSERT INTO players SET `name`='$player[1]',`ip`='$player[4]',`host`='$host',`description`='$player[6]',`bzid`='$player[3]',`time`='$ts'");
		}
	}
}

exit;

?>
