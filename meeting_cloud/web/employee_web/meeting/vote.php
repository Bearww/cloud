<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/em_meeting_info.php?meeting_id=4
	
	if(!isset($_SESSION))
	{  	session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
//	require_once("../../../login_check.php");
	
	$meeting_id = $_GET['meeting_id'];
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];
	
	$topic_id = 
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../../main_css/main.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script language="JavaScript" src="../../main_js/leftBarSlide.js"></script>
	
	<script>
		var now_num_of_member = 0;
		var get_num_of_member = 0;
		
		var obj;

		function invite_member() 
		{
			set_topic_request = createRequest();
			if (set_topic_request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/set_info/set_meeting_topic.php?meeting_id=".$meeting_id."\";";
		?>
				set_topic_request.open("POST", url, true);
				set_topic_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_topic_request.send("member=" + document.invite_member_form.member.value);						// �e�X�ШD�]�ѩ� GET �ҥH�ѼƬ� null�^
				document.set_new_topic_form.topic.value = "";
				console.log(document.set_new_topic_form.topic.value);
			}
		}
		
		
		function get_meeting_member_list_request() 					//���o�|ĳid
		{
			request = createRequest();
			if (request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/get_info/get_meeting_member_list.php?meeting_id=".$meeting_id."\";";
		?>

				request.open("GET", url, true);
				request.onreadystatechange = displayResult;		//�d�U����[�A��
				request.send(null);								// �e�X�ШD�]�ѩ� GET �ҥH�ѼƬ� null�^
			}
		}
		function displayResult() 
		{	

			if (request.readyState == 4) 				//�ߦ��T�w�ШD�w�B�z�����]readyState �� 4�^�ɡA�ӥB HTTP �^���� 200 OK
			{
				if (request.status == 200) 
				{
					if (	request.responseText.indexOf("{") != -1	)
					{
						obj = eval('(' + request.responseText + ')');
						
						if ( obj['contents'] && obj.contents['obj_meeting_member_list'] && obj.contents.obj_meeting_member_list != "none")
						{
							get_num_of_member = obj.contents.obj_meeting_member_list.name.length;
							if (get_num_of_member > now_num_of_member)
								add_new_member();
						}

					}
					else	console.log(request.responseText);
						
				}
			}
		}
		function createRequest() 
		{
			try 
			{
				request = new XMLHttpRequest();
			} catch (tryMS) 
			{
				try 
				{
					request = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (otherMS) 
				{
					try 
					{
						request = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (failed) 
					{
						request = null;
					}
				}
			}

			return request;
		}
		
		setInterval("get_meeting_member_list_request();", 1000) //�C�j�@��o�X�@���d��
			
		function add_new_member() 
		{  
			var count = now_num_of_member;
			var mail;
			var access;
			for (var i = now_num_of_member; i < get_num_of_member; i++ )
			{
				count = count + 1;
				mail = obj.contents.obj_meeting_member_list.mail[i];
				access = obj.contents.obj_meeting_member_list.access[i];
				
				if (!mail)
					mail = "none";
				if (!access)
					access = "none";
				
				document.getElementById("meeting_member" + count).innerHTML = document.getElementById("meeting_member" + count).innerHTML + 
					'<td id = "tableValueCol1" style="width:150px">' + obj.contents.obj_meeting_member_list.name[i] + '</td>'	+
					'<td id = "tableValueCol2" style="width:150px">' + access + '</td>'	+
					'<td id = "tableValueCol2" style="width:300px">' + mail + '</td>';
				
				now_num_of_member = now_num_of_member + 1;
			}
		}
		
	</script>