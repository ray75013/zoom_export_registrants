<?php
$compte=$_GET['compte'];

include("zoom_fonctions.php");



	

$meeting=zoom_request("users/me/meetings?type=scheduled&page_size=300",$compte);
$meeting = json_decode($meeting, true);
$meeting=$meeting['meetings'];


$columns = array_column($meeting, 'start_time');
array_multisort($columns, SORT_DESC, $meeting);
$meeting_registrants=array();
foreach ($meeting as $m)
{	
	$registrants= zoom_request("meetings/".$m["id"]."/registrants?page_size=300",$compte);
	//echo "registrants=".$registrants;
	//echo "<br>";
	$registrants = json_decode($registrants, true);
	if (isset($registrants['registrants']) )
	{
		$registrants=$registrants['registrants'];
	}
	else
	{
		$registrants=array();
	}
	
	

	$meeting_registrants[$m['id']]=$registrants;
}


?>
<html>
<head>
<link href="bootstrap-5.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<script type="text/javascript" src="jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="zoom.js"></script>
<body>
<div class="container">
<br>

<form width="50px" action="get_all_registrants.php?compte=<?php echo $compte?>" method="POST">
<h1> Réunions ZOOM compte <?php echo $_GET["compte"];?></h1>
<table class="table">
<tr><td>Date de la réunion</td><td>Intitulé</td><td>participants</td></tr>
<?php
foreach ($meeting as $m)
	{
		echo "<tr><td>".$m['start_time']."</td><td>".$m['topic']."</td><td><a href='get_registrants.php?compte=".$compte."&id_meeting=".$m['id']."'>".count($meeting_registrants[$m['id']])."</a></td><tr>";
	}
		
?>
</table>

<br>
<button class="btn btn-primary"  type="submit">Récupérer les inscrits de toutes les réunions</button>
</form>
</div>
</body>
</html>
