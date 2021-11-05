<?php
	$vcode = $_GET['vcode'];
	require("db.php");
	
	// query帳號狀態
	$sql  = "SELECT * from `account` WHERE `v_code` = :v1";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':v1', $vcode);
	$stmt->execute();
	$rs = $stmt->fetch(PDO::FETCH_ASSOC);
	$reg_status = $rs['reg_status'];
	// var_dump($vcode);
	// var_dump($reg_status);

	if ($reg_status == NULL) {

		$url = "http://cdiary3.tw";
		echo  "<script>alert('驗證碼無效，請來信至***@stat.sinica.edu.tw，以便我們協助您解決'); window.location.href = '$url';</script>";

	}else if ($reg_status == 0) {

		// 依照veryfy對應的帳號，將資料庫中的registered改為1，表示帳號已啟用
		$sql  = "UPDATE `account` SET `reg_status` = 1 WHERE `v_code` = :v1 ";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $vcode);
		$stmt->execute();
		$url = "http://cdiary3.tw";
		echo  "<script>alert('您的帳號已成功啟用，趕快登入填寫日記吧!!'); window.location.href = '$url';</script>";

	}else if ($reg_status > 0) {

		$url = "http://cdiary3.tw";
		echo  "<script>alert('您的帳號已啟用，毋須重複驗證~'); window.location.href = '$url';</script>";
		
	}
	
?>
