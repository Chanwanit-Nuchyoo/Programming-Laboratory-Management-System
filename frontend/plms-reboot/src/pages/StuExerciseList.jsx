import { useEffect, useState } from "react"
import { Container, Stack, Typography, Box } from "@mui/material"
import Header from "@/components/_shared/Header"
import ExerciseChapterList from "@/components/_shared/ExerciseChapterList"
import MyBreadCrumbs from "@/components/_shared/MyBreadCrumbs"
import codingIcon from '@/assets/images/codingicon.svg'
import { getChapterList } from "@/utils/api"
import { useQuery } from "@tanstack/react-query"
import { userAtom, sidebarSelectedAtom } from "@/store/store"
import { useAtom, useSetAtom } from "jotai"
import { studentCardAtom } from "@/store/store"

const StuExerciseList = () => {
  const [user] = useAtom(userAtom)
  const [studentCardInfo, setStudentCardInfo] = useAtom(studentCardAtom);
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const [examChapters, setExamChapters] = useState(null);

  useEffect(() => {
    setSelected('stu_exercise_list');
  }, [])

  const { data: chapterList, isLoading: isChapterListLoading, refetch: refetchChapterList } = useQuery({
    queryKey: ["chapterList", user?.id],
    queryFn: () => getChapterList(user?.id),
  })

  useEffect(() => {
    if (!isChapterListLoading && chapterList) {
      setExamChapters(chapterList.filter(chapter => chapter.chapter_name.split(" ")[0] === "Quiz"));
    }
  }, [isChapterListLoading, chapterList])

  return (
    <Container>
      <Stack spacing="20px" >
        <Box sx={{ position: "absolute", display: "flex", justifyContent: "center", alignItems: "center", flexDirection: "column", top: "20px", left: "50%", transform: "translateX(-50%)" }} >
          <Typography variant="h4" >Group:{studentCardInfo?.group_no}</Typography>
          <Typography sx={{ color: "var(--cerulean)", fontWeight: "600" }} >Semester:{studentCardInfo?.year}/{studentCardInfo?.semester}</Typography>
        </Box>
        <MyBreadCrumbs items={[
          { label: 'Exercise List', href: "#" },
        ]} />
        <Stack spacing="5px" >
          <Header
            logoSrc={codingIcon}
            title="Exercise List"
          />
          {!isChapterListLoading && <ExerciseChapterList cacheKey={["chapterList", user?.id]} refetch={refetchChapterList} isLoading={isChapterListLoading} examChapters={examChapters} data={chapterList} />}
        </Stack>
      </Stack>
    </Container>
  )
}

export default StuExerciseList