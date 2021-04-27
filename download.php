<?php
	require_once '../ortak/baglanti.php';
	
	if(ISSET($_REQUEST['file_id'])){
		$file = $_REQUEST['file_id'];
		$query = $baglanti->prepare("SELECT * FROM `file` WHERE `file_id`='$file'");
		$query->execute();
		$fetch = $query->fetch();
	
		header("Content-Disposition: attachment; filename=".$fetch['file']);
		header("Content-Type: application/octet-stream;");
		readfile("uploads/".$fetch['file']);
	}
?>