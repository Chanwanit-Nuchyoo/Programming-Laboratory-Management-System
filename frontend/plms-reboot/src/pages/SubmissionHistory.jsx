import { Box, Stack, Container } from "@mui/material";
import chapterIcon from '@/assets/images/chaptericon.svg';
import { useParams } from 'react-router-dom';
import { getBreadCrumbs } from '@/utils/api'
import { useQuery } from '@tanstack/react-query';
import { getAssignedStudentExercise, getStudentSubmissionList } from '@/utils/api';
import { ABS_INS_URL } from "@/utils/constants/routeConst"

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import Header from '@/components/_shared/Header';
import StudentBriefInfo from "@/components/_shared/StudentBriefInfo";
import ExerciseInfoBox from "@/components/SubmissionHistoryPage/ExerciseInfoBox";
import SubmissionHistoryBox from "@/components/SubmissionHistoryPage/SubmissionHistoryBox";

const SubmissionHistory = () => {
  const { groupId, studentId, chapterId, itemId } = useParams();

  const { data: breadCrumbsData, isLoading: isBreadcrumbLoading } = useQuery({
    queryKey: ['breadCrumbs', groupId, chapterId],
    queryFn: () => getBreadCrumbs({ "group_id": groupId, "chapter_id": chapterId }),
  })

  const { data: exercise, isLoading: isExerciseLoading } = useQuery({
    queryKey: ['assignedStudentExercise', studentId, chapterId, itemId],
    queryFn: () => getAssignedStudentExercise(studentId, chapterId, itemId).then(res => {
      if (res.exercise) {
        return res.exercise
      } else {
        return null
      }
    }),
  })

  const { data: subHistory, isLoading: isSubHistoryLoading } = useQuery({
    queryKey: ['submission-list', studentId, chapterId, itemId],
    queryFn: () => getStudentSubmissionList(studentId, chapterId, itemId),
  })

  return (
    <Box>
      <Container>
        <Stack spacing={"20px"}>
          <MyBreadCrumbs items={[
            { label: 'My Groups', href: '#' },
            { label: isBreadcrumbLoading ? 'Group ...' : `Group ${breadCrumbsData.group_no}`, href: ABS_INS_URL.DYNAMIC.GROUP(groupId) },
            { label: 'Student List', href: ABS_INS_URL.DYNAMIC.STUDENT_LIST(groupId) },
            { label: studentId, href: ABS_INS_URL.DYNAMIC.STUDENT_SCORE(groupId, studentId) },
            { label: isBreadcrumbLoading ? "Chapter ..." : `Chapter ${chapterId} Item ${itemId}`, href: "#" },
          ]} />

          <StudentBriefInfo studentId={studentId} />

          <Header logoSrc={chapterIcon} title={isBreadcrumbLoading ? `Chapter ${chapterId}: ...` : `Chapter ${chapterId}: ${breadCrumbsData.chapter_name}`} />

          <ExerciseInfoBox exercise={exercise} isExerciseLoading={isExerciseLoading} />

          <SubmissionHistoryBox subHistory={subHistory} isSubHistoryLoading={isSubHistoryLoading} />

        </Stack>
      </Container>
    </Box>
  );
};

export default SubmissionHistory;
