


�Q��id ��ۤv�Ҧ����|ĳid�B�|ĳ�W�١B�|ĳ���
$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.group_id in 
			(select gl.group_id
				FROM group_leader as gl, group_member as gm
				where gm.member_id = 'emaa' or gl.member_id = 'emaa'
                group by gl.group_id
			)
			and member.id = scheduler.moderator_id
            order by scheduler.time desc";
			
�Q��id ��ۤv�Ҧ����ݪ��s��
$sql = "SELECT gl.group_name, gl.group_id
			FROM group_leader as gl, group_member as gm
			where gm.member_id = '".$id."' or gl.member_id = '".$id."'
			group by gl.group_id ";
			
�Q��meeting id ��s��id
