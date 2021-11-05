<?php
	session_start();
	include("db.php");

	$sql  = "SELECT distinct City, COUN_ID FROM county order by CityID";
	$stmt = $db->prepare($sql);
	$stmt->execute();

	$json = array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$json[] = $row;
	}
	echo json_encode($json,JSON_UNESCAPED_UNICODE);

?>	