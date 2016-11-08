<?php
	//���եκ��}
	//http://127.0.0.1:8080/meeting_cloud/back_end/meeting/get_info/get_meeting_info.php?meeting_id=4
	
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
//	require_once("../../../login_check.php");	
	
	$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.meeting_id = '".$_GET['meeting_id']."' and scheduler.moderator_id = member.id";
	
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$meeting_date = date("Y-m-d", strtotime($row['time']));
	$meeting_time = date("H:i", strtotime($row['time']));
	$moderator = $row['name'];
	$json = array
	(
		"contents" => array
		(
			"moderator" => $moderator,
			"date" => $meeting_date,
			"time" => $meeting_time,
		),
		"link" => array
		(
			"meeting_start" => "../../meeting_start.php?meeting_id=".$_GET['meeting_id'],
			"get_meeting_topic_form.php" => "../../../device/employee/meeting/set_meeting_topic_form.php?meeting_id=".$_GET['meeting_id']
		),
		
	);
	
	$sql = "select * from group_meeting_topics where meeting_id = '".$_GET['meeting_id']."'";
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;	
	
	if ($num_rows==0)
	{	$state = "�|ĳ�٨S���]�Uĳ�D";	}
	else
	{
		$json['contents']['obj_meeting_topic'] = array();
		$json['contents']['obj_meeting_topic']['topic'] = array();
		$json['contents']['obj_meeting_topic']['topic_id'] = array();
	
		for($i=1;$i<=$num_rows;$i++) 
		{
			$row=$result->fetch_array();
			array_push ($json['contents']['obj_meeting_topic']['topic'], $row['topic']);
			array_push ($json['contents']['obj_meeting_topic']['topic_id'], $row['topic_id']);
		}
	}
			
	echo json_encode( $json );

?>