import { Box, Container, Stack } from "@mui/material"
import ExerciseChapterList from "@/components/_shared/ExerciseChapterList"
import blueFolderIcon from '@/assets/images/bluefoldericon.svg'
import avatarPlaceholder from '@/assets/images/avatarplaceholder.png'
import { getChapterList } from "@/utils/api"
import { useQuery } from "@tanstack/react-query"
import { useParams } from "react-router-dom"

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from '@/components/_shared/Header'
import StudentBriefInfo from "@/components/_shared/StudentBriefInfo"

const StudentScore = () => {
  const { studentId } = useParams();

  const { data: chapterList, isLoading: isChapterListLoading } = useQuery({
    queryKey: ["chapterList", studentId],
    queryFn: () => getChapterList(studentId),
  })

  return (
    <Box>
      <Container>
        <Stack spacing={"20px"} >
          <MyBreadCrumbs items={[
            { label: 'Available Groups', href: '#' },
          ]} />

          <Header logoSrc={blueFolderIcon} title="Group 401 (Student)" />

          <StudentBriefInfo
            imgSrc={avatarPlaceholder}
            studentId="63010202"
            studentName="ชรินดา สนธิดี"
            studentNickName="แบม"
            groupId="22020402"
            groupNo={401}
          />

          <ExerciseChapterList isLoading={isChapterListLoading} data={chapterList} />

        </Stack>
      </Container>
    </Box>
  )
}

export default StudentScore