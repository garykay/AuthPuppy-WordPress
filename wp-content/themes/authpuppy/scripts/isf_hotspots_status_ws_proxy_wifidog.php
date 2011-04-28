<?php

/*
 * This will proxy request to the ISF hotspots status WS
 * Author: François Proulx
 * Date: 2008-08-06
 */

header("Content-Type: text/xml; charset=UTF-8");

function curl_get_file_contents($URL) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, $URL);
	$contents = curl_exec($c);
	curl_close($c);
	
	if ($contents) 
		return $contents;
	else return FALSE;
}

$xml = curl_get_file_contents("http://auth.ilesansfil.org/hotspot_status.php?format=XML");
if($xml !== FALSE) {
	header("Content-Type: text/xml; charset=UTF-8");
	echo $xml;
}
else {
	header("HTTP/1.1 503 Could not call ISF Hotspots status WS");
}

?>