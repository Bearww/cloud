<?php
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
	require_once("../back_end/login_check.php");
	
	//�d�߷|�����h�ַ|ĳ
	$id = $_SESSION['id'];
	
	$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.group_id in 
			(select gl.group_id
				FROM group_leader as gl, group_member as gm
				where gm.member_id = '".$id."' or gl.member_id = '".$id."'
                group by gl.group_id
			)
			and member.id = scheduler.create_meeting_member_id
            order by scheduler.time desc";
			
	$result = $conn->query($sql);
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="../main_css/main.css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
        <script language="JavaScript" src="../main_js/leftBarSlide.js"></script>
        
        <title>���|GO</title>
    </head>
	<body>
		<table id="HEADER_SHADOW" width=100% border="0" cellpadding="0" cellspacing="0">
		  <tr>
		  
		    <td width=100% height=50px bgcolor="#00AA55">
		  	<p id="HEADER">���|GO</p>
		  	</td>
		  
		  </tr>
		</table>
		
		<div id="divOrigin">
			<div id="divTop">
	        	<dl style="margin:0;width:20%;float:left;">
	        		<dt id="member_Bar" class="left">
	        			�|���M��
	        			<dt id = "member_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">�|���s��</a></dt>
		        			<dt><a href="">�|�����</a></dt>
		        			<dt><a href="em_update_pw.php">�ק�K�X</a></dt>
							<dt><a href="">�ڪ����ݪŶ�</a></dt>
		        			<dt><a href="../back_end/logout.php">�n�X</a></dt>
	        			</dt>
	        		</dt>
	        		<dt id="meeting_Bar" class="left">
	        			�|ĳ�M��
	        			<dt id = "meeting_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="em_meeting_list.php">�|ĳ�޲z</a></dt>
							<dt><a href="em_group_list.php">�s�պ޲z</a></dt>
	        			</dt>
	        		</dt>
	        	</dl>
	        	
	        	
	        	<div id="main_in_main">
	        		
	        		<div id="main_sub">
			        	<p id="conventionTittle">�N�ܷ|ĳ</p><!--�޲z��/����-->
					
						<table id="table">
							<tr>
								<td id="title">�|ĳ���D</td>
								<td id="date">���</td>
								<td id="time">�ɶ�</td>
								<td id="leader">�l���H</td>
						    </tr>
						    
							<?php	
								$num_rows = $result->num_rows;	
								$today = date("Y-m-d");
								$end_meeting = 0;
							if ( $num_rows == 0 )
							{	echo "�ثe�|���إ�����A���s��";	}
							else
							{			
													
								for($i=1 ; $i<=$num_rows ; $i++) 
								{
									$row=$result->fetch_array();
									$meeting_date = date("Y-m-d", strtotime($row['time']));
									$meeting_time = date("H:i", strtotime($row['time']));
									
									if ((strtotime($today) - strtotime($meeting_date)) > 0)		//�Q�Ѫ���
									{	$end_meeting = $i;	break;	}
									$title = $row['title'];
									$create_meeting_member_id = $row['create_meeting_member_id'];
									echo "<tr><!--�̦h����-->";
									
									echo "<td id=\"\"><a href='' style=\"color:#333333;width:auto;line-height:200%;\">";
									echo $title;
									echo "</a></td>";
									
									echo "<td id=\"date\">$meeting_date</td>";
									echo "<td id=\"time\">$meeting_time</td>";
									echo "<td id=\"leader\">$create_meeting_member_id</td>";
									echo "</tr>";
									

								}
							}
						    ?>
					    </table>
				    </div>
				    
				    <div id="main_sub">
					    <p id="conventionTittle">�����|ĳ</p><!--�޲z��/����-->
					
						<table id="table">
							<tr>
								<td id="title">�|ĳ���D</td>
								<td id="date">���</td>
								<td id="time">�ɶ�</td>
								<td id="leader">�l���H</td>
						    </tr>
						    
						    <?php
							if ($end_meeting == 0)
							{	echo "�A�٥��}�L�|�O~";	}
							else
							{				
								for($i=$end_meeting ; $i<=$num_rows ; $i++) 
								{
									if ($i != $end_meeting)	$row=$result->fetch_array();
									
									$meeting_date = date("Y-m-d", strtotime($row['time']));
									$meeting_time = date("H:i", strtotime($row['time']));
									
									$title = $row['title'];
									$create_meeting_member_id = $row['create_meeting_member_id'];
									echo "<tr><!--�̦h����-->";
									
									echo "<td id=\"\"><a href='' style=\"color:#333333;width:auto;line-height:200%;\">";
									echo $title;
									echo "</a></td>";
									
									echo "<td id=\"date\">$meeting_date</td>";
									echo "<td id=\"time\">$meeting_time</td>";
									echo "<td id=\"leader\">$create_meeting_member_id</td>";
									echo "</tr>";
									

								}
							}
						    ?>
						    
					    </table>
				    </div>

			    </div>
			    
	        </div>
		</div>
	 
	</body>
</html>

