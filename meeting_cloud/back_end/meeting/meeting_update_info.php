<?php

	if(!isset($_SESSION))
	(  	session_start();	)			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw

	require_once("../../login_check.php");	
	
	$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
	$result=$conn->query($sql);

	$num_rows = $result->num_rows;					//�ݬO�_�b�|ĳ��
	if ($num_rows==0)								//�_
	{	$meeting_id = $_GET['meeting_id'];	}
	else											//�O
	{
		$row=$result->fetch_array();
		$meeting_id = $row['meeting_id'];
	}
	//==============================================���o�|ĳid===================================================
	
	$json = array
	(
		"contents" => array(),
	);
	
	
	//==============================================ĳ�D��=====================================================
	$sql = "select * from meeting_topics where meeting_id = '".$meeting_id."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	$json ['contents']['meeting_topic'] = $num_rows;
	
	
	//==============================================���D��/�^����=====================================================
	$json ['contents']['meeting_question'] = array();
	$json ['contents']['meeting_question']['question'] = array();
	$json ['contents']['meeting_question']['answer'] = array();
	$sql = "select * from meeting_questions where meeting_id = '".$meeting_id."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	$topic_id = -1;
	$num_of_question = 0;
	$num_of_answer = 0;
	for($i=1;$i<=$num_rows;$i++) 
	{
		$row=$result->fetch_array();
		if ($topic_id != $row['topic_id'])
		{
			if ( $topic_id != -1 )
			{	
				array_push ($json ['contents']['meeting_question']['question'], $num_of_question);	
				array_push ($json ['contents']['meeting_question']['answer'], $num_of_answer);
			}
			$topic_id = $row['topic_id'];
			$num_of_topic = 0;
			$num_of_answer = 0;
		}
		if (isset($row['answer'])
			$num_of_answer = $num_of_answer + 1;
		
		$num_of_topic = $num_of_topic + 1;
	}
	array_push ($json ['contents']['meeting_question'], $num_of_question);
	
	
	//=============================================�P�|�̼�====================================================
	
	$sql = "select * from group_meeting_now where meeting_id = '".$meeting_id."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	$json ['contents']['meeting_member_list'] = $num_rows;
	
	
	
	
	
	
	
	
	
	
?>