SELECT stu_id, exercise_id, MAX(marking)
FROM exercise_submission T2
GROUP BY stu_id, exercise_id
ORDER BY stu_id, exercise_id


SELECT stu_id, chapter_id, item_id, exercise_id,(SELECT MAX(marking)
												FROM exercise_submission T2
												GROUP BY stu_id, exercise_id
												WHERE T2.stu_id=stu_id AND T2.exercise_id=exercise_id) AS max_marking)
FROM student_assigned_chapter_item T1
GROUP BY stu_id, chapter_id, item_id
ORDER BY stu_id, chapter_id, item_id


SELECT stu_id, chapter_id, item_id, exercise_id,T2.marking
FROM student_assigned_chapter_item T1 inner join exercise_submission T2 on T1.stu_id=T2.stu_id AND T1.exercise_id=T2.exercise_id
GROUP BY stu_id, chapter_id, item_id
ORDER BY stu_id, chapter_id, item_id

SELECT T1.stu_id, T1.chapter_id, T1.item_id, T1.exercise_id,T2.marking
FROM student_assigned_chapter_item T1 LEFT JOIN exercise_submission T2 on T1.stu_id=T2.stu_id AND T1.exercise_id=T2.exercise_id
GROUP BY stu_id, chapter_id, item_id
ORDER BY stu_id, chapter_id, item_id

SELECT T1.stu_id, T1.chapter_id, T1.item_id, T1.exercise_id,T2.max_marking
FROM student_assigned_chapter_item T1 
	LEFT JOIN
    	(SELECT stu_id, exercise_id, MAX(marking) AS max_marking 
         FROM exercise_submission
         GROUP BY stu_id, exercise_id) T2
         
     	on T1.stu_id=T2.stu_id AND T1.exercise_id=T2.exercise_id
GROUP BY stu_id, chapter_id, item_id
ORDER BY stu_id, chapter_id, item_id