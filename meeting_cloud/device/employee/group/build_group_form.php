<?php
	
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
	require_once("../../../login_check.php");

	$json = array
	(
		"form" => array
		(
			"build_group" => array
			(
				"func" => "build_group",
				"addr" => "../../../back_end/group/build_group.php",
				"form" => array
				(
					"group_name" => "none",
					"member_id" => "none",
				)
			),
		),
	);


	echo json_encode( $json );
?>