<?php
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
	
	require_once("../../../login_check.php?platform=device");	
	
	$topic = $_POST['topic'];
	if (isset($_GET['meeting_id'])
	{
		$meeting_id = $_GET['meeting_id'];
	}
	else
	{
		$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
		$result=$conn->query($sql);
		$row=$result->fetch_array();
		$meeting_id = $row['meeting_id'];
	}
	
	$sql = "INSERT INTO group_meeting_topics value('".$meeting_id."', 0, '".$topic."')";
	
	
	
	
	
	
	
?>