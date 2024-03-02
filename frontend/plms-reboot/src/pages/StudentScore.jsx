import { Box, Container, Stack } from "@mui/material"
import ExerciseChapterList from "@/components/_shared/ExerciseChapterList"
import folderIcon from '@/assets/images/foldericon.svg'
import avatarPlaceHolder from "@/assets/images/avatarplaceholder.svg"
import { getChapterList, getBreadCrumbs } from "@/utils/api"
import { useQuery } from "@tanstack/react-query"
import { useParams } from "react-router-dom"

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from '@/components/_shared/Header'
import StudentBriefInfo from "@/components/_shared/StudentBriefInfo"


const StudentScore = () => {
  const { studentId, groupId } = useParams();

  const { data: chapterList, isLoading: isChapterListLoading, refetch: refetchChapterList } = useQuery({
    queryKey: ["chapterList", studentId],
    queryFn: () => getChapterList(studentId),
  })

  const { data: breadCrumbsData, isLoading: isBreadcrumbLoading } = useQuery({
    queryKey: ['breadCrumbs', groupId],
    queryFn: () => getBreadCrumbs({ "group_id": groupId }),
  })


  return (
    <Box>
      <Container>
        <Stack spacing={"20px"} >
          <MyBreadCrumbs
            items={[
              { label: "My Groups", href: "/ins" },
            ]}
          />

          <Header logoSrc={folderIcon} title={isBreadcrumbLoading ? "Group ... (Student)" : `Group ${breadCrumbsData.group_no} (Student)`} />

          <StudentBriefInfo
            studentId={studentId}
          />

          {!isChapterListLoading && <ExerciseChapterList cacheKey={["chapterList", studentId]} refetch={refetchChapterList} isLoading={isChapterListLoading} data={chapterList} insPage={true} />}

        </Stack>
      </Container>
    </Box>
  )
}

export default StudentScore