<?php

function zoom_request($url,$compte)
{
	if ($compte=='info') $jwt = file_get_contents('jwt_info.txt');
	if ($compte=='spc') $jwt = file_get_contents('jwt.txt');



$curl = curl_init();

curl_setopt_array($curl, array(
  
CURLOPT_URL => "https://api.zoom.us/v2/".$url,
CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer ".$jwt,
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
if ($err) {
  return "cURL Error #:" . $err;
} else {

 //$json = json_decode($response, true);
return $response;

}
}

?>
