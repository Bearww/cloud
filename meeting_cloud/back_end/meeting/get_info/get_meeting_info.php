<?php
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
	require_once("../../../login_check.php");	
	
	$sql = "select scheduler.* member.name
			form meeting_scheduler as scheduler, member
			where scheduler.meeting_id = '".$_GET['meeting_id']."' and scheduler.moderator_id = member.id"
	
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_date = date("Y-m-d", strtotime($row['time']));
	$meeting_time = date("H:i", strtotime($row['time']));
	$moderator = $row['name'];
	$json = array
	(
		"contents" => array
		(
			"moderator" => $moderator,
			"date" => $meeting_date,
			"time" => $meeting_time
		),
		"link" => array
		(
			"meeting_start" => "../../meeting_start.php?meeting_id=".$_GET['meeting_id'];
		),
	);


?>