import { Box, Container, Stack } from "@mui/material"
import ExerciseChapterList from "@/components/_shared/ExerciseChapterList"
import folderIcon from '@/assets/images/foldericon.svg'
import { getChapterList, getBreadCrumbs } from "@/utils/api"
import { useQuery } from "@tanstack/react-query"
import { useParams } from "react-router-dom"
import { useEffect } from "react"
import { ABS_INS_URL } from "@/utils/constants/routeConst"
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from '@/components/_shared/Header'
import StudentBriefInfo from "@/components/_shared/StudentBriefInfo"


const StudentScore = () => {
  const { studentId, groupId } = useParams();
  const setSelected = useSetAtom(sidebarSelectedAtom);

  useEffect(() => {
    setSelected('my_groups');
  }, []);

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
          <MyBreadCrumbs items={[
            { label: 'My Groups', href: '#' },
            { label: isBreadcrumbLoading ? 'Group ...' : `Group ${breadCrumbsData.group_no}`, href: ABS_INS_URL.DYNAMIC.GROUP(groupId) },
            { label: 'Student List', href: ABS_INS_URL.DYNAMIC.STUDENT_LIST(groupId) },
            { label: studentId, href: "#" }
          ]} />

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