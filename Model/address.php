<?php
class Address{
	private static $cSession;
	private static $keyApi= "AIzaSyAautyFNdXJBhzCV6-GPAqcyn4avkSH4zw";
	static public function getAddressByLatLng($latlng){
		// sleep(60);
		self::$cSession = curl_init();
		curl_setopt(self::$cSession,CURLOPT_URL,"https://maps.googleapis.com/maps/api/geocode/json?latlng=$latlng&location_type=ROOFTOP&result_type=street_address&key=".self::$keyApi);
		curl_setopt(self::$cSession,CURLOPT_RETURNTRANSFER,true);
		curl_setopt(self::$cSession,CURLOPT_HEADER, false);
		$result=curl_exec(self::$cSession);
		curl_close(self::$cSession);
		$data =json_decode($result);
		if($data->status=="OK")
			return $data->results[0]->formatted_address;
		else
			return null;
	}
}

?>