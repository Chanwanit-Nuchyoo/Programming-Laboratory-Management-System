import { Box, Stack, Container } from "@mui/material";
import chapterIcon from '@/assets/images/chaptericon.svg';

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import Header from '@/components/_shared/Header';
import StudentBriefInfo from "@/components/_shared/StudentBriefInfo";
import ExerciseInfoBox from "@/components/SubmissionHistoryPage/ExerciseInfoBox";
import SubmissionHistoryBox from "@/components/SubmissionHistoryPage/SubmissionHistoryBox";

const SubmissionHistory = () => {

  return (
    <Box>
      <Container>
        <Stack spacing={"20px"}>
          <MyBreadCrumbs items={[
            { label: 'My Groups', href: '#' },
            { label: 'Group 401', href: '#' },
            { label: 'Score(Individual)', href: '#' },
            { label: 'Introduction', href: '#' },
          ]} />

          <StudentBriefInfo
            studentId="63010202"
            studentName="ชรินดา สนธิดี"
            studentNickName="แบม"
            groupId="22020402"
            groupNo={401}
          />

          <Header logoSrc={chapterIcon} title="Group 401 (Student)" />
          
          <ExerciseInfoBox />

          <SubmissionHistoryBox />

        </Stack>
      </Container>
    </Box>
  );
};

export default SubmissionHistory;
