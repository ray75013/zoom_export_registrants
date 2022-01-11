<?php
include("zoom_fonctions.php");
error_reporting(0);
$compte=$_GET['compte'];

if (isset($_GET['id_meeting'])) 
{	
	$id_meeting=$_GET['id_meeting'];
}
else
{
	$id_meeting=$_POST['meeting'];
}

$registrants= zoom_request("meetings/".$id_meeting."/registrants?page_size=300",$compte);

$registrants = json_decode($registrants, true);
$registrants=$registrants['registrants'];


$data="email;firstname;lastname\n";

foreach ($registrants as $r)
{
$data.=$r["email"].";".$r["first_name"].";".$r["last_name"]."\n";
}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="inscrits.csv"');
echo $data; exit();

?>
