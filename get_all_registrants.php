<?php
include("zoom_fonctions.php");
error_reporting(0);
$compte=$_GET['compte'];



$meeting=zoom_request("users/me/meetings?type=scheduled&page_size=300",$compte);
$meeting = json_decode($meeting, true);
$meeting=$meeting['meetings'];


$columns = array_column($meeting, 'start_time');
array_multisort($columns, SORT_DESC, $meeting);
$meeting_registrants=array();
foreach ($meeting as $m)
{	
	$registrants= zoom_request("meetings/".$m["id"]."/registrants?page_size=300",$compte);
	
	$registrants = json_decode($registrants, true);
	if (isset($registrants['registrants']) )
	{
		$registrants=$registrants['registrants'];
		foreach($registrants as $r)
		{
			array_push($meeting_registrants,$r);
		}
	}
	
	
	

	
}

//dédoublonnage

function super_unique($array,$key)
    {
       $temp_array = [];
       foreach ($array as &$v) {
           if (!isset($temp_array[$v[$key]]))
           $temp_array[$v[$key]] =& $v;
       }
       $array = array_values($temp_array);
       return $array;

    }

$meeting_registrants=super_unique($meeting_registrants,'email');

$data="email;firstname;lastname\n";


	foreach ($meeting_registrants as $r)
	{
	$data.=$r["email"].";".$r["first_name"].";".$r["last_name"]."\n";
	}


header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="inscrits.csv"');
echo $data; exit();

?>
