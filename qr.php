<?php 

	require_once './phpqrcode/qrlib.php';
	$text = $_GET['ticket_id'];
	$file = "./img/QR/ticket".$text.".png";
	$text = "T_ID : ".$text;
	$ecc = 'L'; 
	$pixel_Size = 20; 
	$frame_Size = 10;
	QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size); 
	echo "<center><img src='".$file."'></center>";
?>