<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// timezone from store prp then create datetime 

function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) {
    
	// Build URL
	$url = "https://" . $shop . $api_endpoint;
	if (!is_null($query) && in_array($method, array('GET', 	'DELETE'))) $url = $url . "?" . http_build_query($query);

	// Configure cURL
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, TRUE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
	// curl_setopt($curl, CURLOPT_SSLVERSION, 3);
	curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

	// Setup headers
	$request_headers[] = "";
	if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

	if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
		if (is_array($query)) $query = http_build_query($query);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
	}
    
	// Send request to Shopify and capture any errors
	$response = curl_exec($curl);
	$error_number = curl_errno($curl);
	$error_message = curl_error($curl);

	// Close cURL to be nice
	curl_close($curl);

	// Return an error is cURL has a problem
	if ($error_number) {
		return $error_message;
	} else {

		// No error, return Shopify's response by parsing out the body and the headers
		$response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

		// Convert headers into an array
		$headers = array();
		$header_data = explode("\n",$response[0]);
		$headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
		array_shift($header_data); // Remove status, we've already set it above
		foreach($header_data as $part) {
			$h = explode(":", $part);
			$headers[trim($h[0])] = trim($h[1]);
		}

		// Return headers and Shopify's response
		return array('headers' => $headers, 'response' => $response[1]);

	}
    
}

/**
 * time_elapsed_string
 *
 * @param  mixed $datetime
 * @param  mixed $full
 * @return void
 */
function timeago($time, $tense='ago') {
    // declaring periods as static function var for future use
    static $periods = array('year', 'month', 'day', 'hour', 'minute', 'second');

    // checking time format
    if(!(strtotime($time)>0)) {
        return trigger_error("Wrong time format: '$time'", E_USER_ERROR);
    }

    // getting diff between now and time

    $time = new DateTime($time, new DateTimeZone($_SESSION['tmz']));
    $now = new DateTime("now", new DateTimeZone($_SESSION['tmz']));
    $diff = $now->diff($time)->format('%y %m %d %h %i %s');
    // combining diff with periods
    $diff = explode(' ', $diff);
    $diff = array_combine($periods, $diff);
    // filtering zero periods from diff
    $diff = array_filter($diff);
    // getting first period and value
    $period = key($diff);
    $value  = current($diff);

    // if input time was equal now, value will be 0, so checking it
    if(!$value) {
        $period = 'seconds';
        $value  = 0;
    } else {
        // converting days to weeks
        if($period=='day' && $value>=7) {
            $period = 'week';
            $value  = floor($value/7);
        }
        // adding 's' to period for human readability
        if($value>1) {
            $period .= 's';
        }
    }

    // returning timeago
    return "$value $period $tense";
}

