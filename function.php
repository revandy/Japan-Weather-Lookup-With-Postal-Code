<?php 
/**
 * WEATHER LOOKUP
 */
class weatherLookUp
{
	public function getWeather($data = []){
		try {
		$url = 'https://www.metaweather.com/api/location/'.$data['woe_id'].'/'.$data['year'].'/'.$data['month'].'/'.$data['day'];
		$result = file_get_contents($url);
		return $result;
		} catch (\Exception $e) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		}
	}
	public function getCityByZip($zip = ""){
		try {
			 // create curl resource
		    $ch = curl_init();
		    // set url
		    curl_setopt($ch, CURLOPT_URL, "http://api.zippopotam.us/JP/$zip");

		        //return the transfer as a string
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		        // $output contains the output string
		    $output = curl_exec($ch);

		        // close curl resource to free up system resources
		    curl_close($ch);     
			if ($output === "{}") {
				header('area_not_found', true, 500); 
				return 'area_not_found';
			}
			$decode_result = json_decode($output, true);
			$data = [
				'longitude' => $decode_result['places'][0]['longitude'],
				'latitude' => $decode_result['places'][0]['latitude'],
				'place_name' => $decode_result['places'][0]['place name'],
				'state' => $decode_result['places'][0]['state'],
				'abbreviation' => $decode_result['country abbreviation'],
			];
		return $data;
		} catch (\Exception $e) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		}
	}
	public function getWoeId($longitude = "", $latitude = ""){
		try {
	 		$url = "https://www.metaweather.com/api/location/search/?lattlong=$latitude,$longitude";
		    // Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, [
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => $url,
			    CURLOPT_USERAGENT => 'BOT'
			]);
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			// Close request to clear up some resources
			return $resp;
			curl_close($curl);
		} catch (\Exception $e) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		}
	}
}

if (isset($_POST['postal_code'])) {
	$postal_code = $_POST['postal_code'];
	$str_split_postal_code = str_split($postal_code);
	if ($str_split_postal_code[3] !== '-') {
		echo 'Wrong Input, please check your postal code!';
		header('wrong_input', true, 500); 
		return;
	}
	try {
		$callweather = new weatherLookUp();
		$city = $callweather->getCityByZip($_POST['postal_code']);
		if($city === 'area_not_found'){
			echo 'Zip area not found in our database, please check another zip!';
			header('wrong_input', true, 500); 
			return;
		}
		$woe_id = $callweather->getWoeId($city['longitude'], $city['latitude']);
		$decode_woe = json_decode($woe_id);
		$woe_id_number = $decode_woe[0]->woeid;
		$data_weather = [];
		for ($i=0; $i <= 2; $i++) { 
			$data = [
				'woe_id' => $woe_id_number,
				'year' => date('Y'),
				'month' => date('m'),
				'day' => date('d')+$i,
				'dmy' => date('Y-m-d D'),
				'longitude' => $city['longitude'],
				'latitude' => $city['latitude'],
				'place' => $city['place_name'],
				'state' => $city['state'],
				'country_code' => $city['abbreviation']
			];
			$weather = $callweather->getWeather($data);
			$weather_newest = json_decode($weather);
			$data_weather_api = [
				'weather_state_abbr' => $weather_newest[0]->weather_state_abbr,
				'weather_state_name' => $weather_newest[0]->weather_state_name,
				'max_temp' => ceil($weather_newest[0]->max_temp),
				'min_temp' => ceil($weather_newest[0]->min_temp),
				'detail' => $data
		 	];
		 	array_push($data_weather, $data_weather_api);
		}
		echo json_encode($data_weather);
	} catch (\Exception $e) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	}
}



?>