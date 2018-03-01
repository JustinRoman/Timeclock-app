<?php
	try {
		// $api_key
		// $language
		// $details
		// $metric
		
		$curl_request = curl_init();
		curl_setopt($curl_request, CURLOPT_URL, "http://dataservice.accuweather.com/forecasts/v1/daily/1day/261774?apikey=S9gKChsAgDlhpckkB5aOiGNpoGFZSgYG%20&language=en-us&details=false&metric=true");
		curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_request, CURLOPT_HEADER, false);

		$res = curl_exec($curl_request);
		curl_close($curl_request);

		$arr = json_decode($res, true);

		$headline = $arr['Headline']['Text'];
		$category = $arr['Headline']['Category'];
		$minimum_temp = $arr['DailyForecasts'][0]['Temperature']['Minimum']['Value'];
		$maximum_temp = $arr['DailyForecasts'][0]['Temperature']['Maximum']['Value'];
		$icon_day = $arr['DailyForecasts'][0]['Day']['Icon'];
		$icon_day_phrase = $arr['DailyForecasts'][0]['Day']['IconPhrase'];	
	} catch(PDOException $e) {
		$e->getMessage();
	}
?>