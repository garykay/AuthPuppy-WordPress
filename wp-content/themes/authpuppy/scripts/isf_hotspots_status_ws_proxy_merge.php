<?php

/*
 * This will proxy request to the ISF hotspots status WS
 * Author: François Proulx
 * Date: 2008-08-06
 */

//header("Content-Type: text/xml; charset=UTF-8");

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

function AddXMLElement(SimpleXMLElement $dest, SimpleXMLElement $source)
    {
        $new_dest = $dest->addChild($source->getName(), $source[0]);
       
        foreach ($source->attributes() as $name => $value)
        {
            $new_dest->addAttribute($name, $value);
        }
       
        foreach ($source->children() as $child)
        {
            AddXMLElement($new_dest, $child);
        }
    }

$xml = curl_get_file_contents("http://auth.ilesansfil.org/hotspot_status.php?format=XML");
if($xml !== FALSE) {
	$xml2 = curl_get_file_contents("http://auth.ilesansfil.org/authpuppy/nodeextra/list/xml");
	if($xml2 !== FALSE) {

		$xmldoc = new SimpleXMLElement($xml);
		$xmldoc2 = new SimpleXMLElement($xml2);

		foreach ($xmldoc2->hotspots->hotspot as $hotspot) {
			AddXMLElement($xmldoc->hotspots, $hotspot);
//var_dump($hotspot);
			//$xmldoc->hotspots->hotspot[] = $hotspot; //addChild("hotspot", $hotspot);
//var_dump($xmldoc->hotspots);
		}
		
		header("Content-Type: text/xml; charset=UTF-8");
		echo $xmldoc->asXML();
	} else {
		header("Content-Type: text/xml; charset=UTF-8");
		echo $xml;
	}
}



else {
	header("HTTP/1.1 503 Could not call ISF Hotspots status WS");
}

?>
