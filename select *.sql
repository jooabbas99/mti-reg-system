select *
from courses as nc
where (nc.pre_course_id IS NULL OR nc.pre_course_id in (select pc.course_id
  from transcripts pc
  where pc.student_id = 1)) AND nc.id NOT IN ( select pc.course_id
  from transcripts pc
  where pc.student_id = 1);



  select *
from courses as nc
where (nc.pre_course_id IS NULL OR nc.pre_course_id in (select pc.course_id
  from transcripts pc
  where pc.student_id = 1)) AND nc.id NOT IN ( select pc.course_id
  from transcripts pc
  where pc.student_id = 1) and nc.semester = 'spring';

select *
from courses as nc
where (nc.pre_course_id IS NULL OR nc.pre_course_id in (select pc.course_id
  from transcripts pc join students st on st.id = pc.student_id
  where pc.student_id = 1 and st.level = nc.level )) AND nc.id NOT IN (
    select pc.course_id
  from transcripts pc
  where pc.student_id = 1 )
  and nc.semester = 'spring';

select nc.*
from courses as nc RIGHT join available_courses av on av.course_id = nc.id
where (nc.pre_course_id IS NULL OR nc.pre_course_id in (select pc.course_id
  from transcripts pc join students st on st.id = pc.student_id
  where pc.student_id = 1 and st.level = nc.level )) AND nc.id NOT IN (
    select pc.course_id
  from transcripts pc
  where pc.student_id = 1 )
  and nc.semester = 'spring';

select *
from courses as nc
where (nc.id in (select pc.course_id
from transcripts pc
where pc.student_id = 1 and pc.grade = 0 ));