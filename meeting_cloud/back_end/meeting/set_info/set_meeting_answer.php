<?php
		//device/back_end
		
		if(!isset($_SESSION))
		{  	session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

		require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
		require_once("../../../login_check.php");
		
		$datetime = date("Y-m-d H:i:s");
		
		if (isset($_SESSION["id"]))
			$id = $_SESSION['id'];
		else
			$id = "a@";
		
		if (isset($_GET['meeting_id'])					//���Xmeeting id
		{
			$meeting_id = $_GET['meeting_id'];
		}
		else
		{
			$sql = "select * from group_meeting_now where member_id = '".$id."'";
			$result=$conn->query($sql);
			$row=$result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}
		
		if (isset($_POST['topic_id'])					//���Xtopic id
			$topic_id = $_POST['topic_id'];
		else
			$topic_id = 0;
		
		$question_id = $_GET['question_id'];
		
		$answer = $_POST['answer'];
		
		if( isset($question_id) )
		{
			$sql = "UPDATE meeting_questions SET answer = '".$answer."'  
					where topic_id = '".$topic_id."' and meeting_id = '".$meeting_id."' and question_id = '".$question_id."'";	
			if	($conn->query($sql))
				echo "�o�e���\";
			else
				echo "�o�e����";
		}
		
?>