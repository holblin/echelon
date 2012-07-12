<?php
//include "../ctracker.php";
//require_once('../Connections/inc_config.php');


function clean_rcon ($command) {

	return str_replace($command, ';',',');
}

function rcon ($command) {
  global $rcon_ip;
  global $rcon_port;
  global $rcon_pass;
    $fp = fsockopen("udp://$rcon_ip",$rcon_port, $errno, $errstr, 2);
	stream_set_blocking( $fp , 0);
	socket_set_timeout($fp,2);
	stream_set_timeout($fp,2);
    if (!$fp) {
        echo "$errstr ($errno)<br>\n";
    } else {
        $query = "\xFF\xFF\xFF\xFFrcon \"" . $rcon_pass . "\" " . $command;
        fwrite($fp,$query);
    }
    $data = '';
	$tmp1 = microtime(true);
	do {
		$d = fread ($fp, 2048);
		$data .= $d;
		if (strlen($d) == 0)
			usleep( 50 );
	} while ( strlen($d) == 0 && (microtime(true) - $tmp1 < 3 ));
	if (microtime(true) - $tmp1 > 3)
		return false;
	$nb_zero = 0;
	do {
		$d = fread ($fp, 2048);
		$data .= $d;
		if (strlen($d) == 0) {
			$nb_zero++;
			usleep(50);
		}else
			$nb_zero = 0;
	} while ( $nb_zero < 5 );
	fclose ($fp);
    $data = preg_replace ("/....print\n/", "", $data); // $data = stripcolors ($data);
    return $data;
}
