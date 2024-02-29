import { useEffect, useState } from "react"
import { Container, Stack } from "@mui/material"
import Header from "@/components/_shared/Header"
import ExerciseChapterList from "@/components/_shared/ExerciseChapterList"
import MyBreadCrumbs from "@/components/_shared/MyBreadCrumbs"
import codingIcon from '@/assets/images/codingicon.svg'
import { getChapterList } from "@/utils/api"
import { useQuery } from "@tanstack/react-query"
import { userAtom, sidebarSelectedAtom } from "@/store/store"
import { useAtom, useSetAtom } from "jotai"
import { useQueryClient } from "@tanstack/react-query"

const StuExerciseList = () => {
  const [user] = useAtom(userAtom)
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const [examChapters, setExamChapters] = useState(null);
  const queryClient = useQueryClient();

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