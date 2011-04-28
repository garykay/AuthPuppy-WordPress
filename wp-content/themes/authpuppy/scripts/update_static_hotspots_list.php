<?php

/*
 * This will download a static copy of the ISF hotspots status
 * Author: François Proulx
 * Date: 2008-10-03
 */

header("Content-Type: text/json; charset=UTF-8");

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

define("STATIC_HOTSPOTS_JSON_LIST_FILE", "hotspots_status.json");

// Store a local copy for 10 minutes
if(file_exists(STATIC_HOTSPOTS_JSON_LIST_FILE) && (time() - filemtime(STATIC_HOTSPOTS_JSON_LIST_FILE) < 3600 * 24 * 1)) {
	// Cache hit
	$json_string = file_get_contents(STATIC_HOTSPOTS_JSON_LIST_FILE);
	echo $json_string;
} 
else {
	// Cache miss
	$raw_xml = curl_get_file_contents("http://auth.ilesansfil.org/hotspot_status.php?format=XML");	
	
	if($raw_xml !== FALSE) {
		$xml = simplexml_load_string($raw_xml);
		$jsonOutput = array();
	
		if(count($xml->hotspots->hotspot) > 0) {
			foreach($xml->hotspots->hotspot as $hotspot) {	
				$id = strval($hotspot->hotspotId);
				$jsonOutput[$id] = array();
				$jsonOutput[$id]["id"] = $id;
				$jsonOutput[$id]["name"] = strval($hotspot->name);
				$jsonOutput[$id]["description"] = strval($hotspot->description);
				$jsonOutput[$id]["openingDate"] = strval($hotspot->openingDate);
				$jsonOutput[$id]["webSiteUrl"] = strval($hotspot->webSiteUrl);
				$jsonOutput[$id]["globalStatus"] = intval($hotspot->globalStatus) == 100 ? "up" : "down";
				$jsonOutput[$id]["massTransitInfo"] = strval($hotspot->massTransitInfo);
				$jsonOutput[$id]["contactPhoneNumber"] = strval($hotspot->contactPhoneNumber);
				$jsonOutput[$id]["civicNumber"] = strval($hotspot->civicNumber);
				$jsonOutput[$id]["streetAddress"] = strval($hotspot->streetAddress);
				$jsonOutput[$id]["city"] = strval($hotspot->city);
				$jsonOutput[$id]["province"] = strval($hotspot->province);
				$jsonOutput[$id]["country"] = strval($hotspot->country);
				$jsonOutput[$id]["postalCode"] = strval($hotspot->postalCode);
				$jsonOutput[$id]["country"] = strval($hotspot->country);
				$jsonOutput[$id]["lat"] = floatval($hotspot->gisCenterLatLong["lat"]);
				$jsonOutput[$id]["lng"] = floatval($hotspot->gisCenterLatLong["long"]);
			}
		}

		$hotspots_json_string = json_encode($jsonOutput);
		file_put_contents(STATIC_HOTSPOTS_JSON_LIST_FILE, $hotspots_json_string);
	
		echo $hotspots_json_string;
	}
	else {
		header("HTTP/1.1 503 Could not call ISF Hotspots status WS");
	}
}

?>