<?php
	if(!isset($_SESSION))
	{  	session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw

	require_once("login_check.php");
	
	$num_of_questions = $_GET['num_of_questions'];
	$meeting_id = $_GET['meeting_id'];
	
	$sql = "select question, answer form meeting_questions as m_q 
			where m_q.meeting_id = '".$meeting_id.
			"' and m_q.question_id <= '".$num_of_questions."'";
			
	$result = $conn->query($sql);
	
	$num_rows = $result->num_rows;	
	
	$json = array
	(
		"content" => array,
	);
	
	if ( $num_rows == 0 )
	{	echo "�ӷ|ĳ�ثe�S�����󴣰�";	}
	else
	{		
		$json['content']['questions'] = array();
		$json['content']['questions']['question'] = array();
		$json['content']['questions']['answer'] = array();
		for($i=1 ; $i<=$num_rows ; $i++) 
		{
			$row=$result->fetch_array();
			array_push( $json['content']['questions']['question'], $row['question']);
			array_push( $json['content']['questions']['answer'], $row['answer']);
		}
		
		echo json_encode( $json );
	}
	
?>