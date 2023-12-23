import { useEffect } from "react"
import { Container, Stack } from "@mui/material"
import Header from "@/components/_shared/Header"
import ExerciseChapterList from "@/components/_shared/ExerciseChapterList"
import MyBreadCrumbs from "@/components/_shared/MyBreadCrumbs"
import codingIcon from '@/assets/images/codingicon.svg'
import { getChapterList } from "@/utils/api"
import { useQuery } from "@tanstack/react-query"
import { userAtom, sidebarSelectedAtom } from "@/store/store"
import { useAtom, useSetAtom } from "jotai"

const StuExerciseList = () => {
  const [user] = useAtom(userAtom)
  const setSelected = useSetAtom(sidebarSelectedAtom);

  useEffect(() => {
    setSelected('stu_exercise_list');
  }, [])

  const { data: chapterList, isLoading: isChapterListLoading } = useQuery({
    queryKey: ["chapterList", user?.id],
    queryFn: () => getChapterList(user?.id),
    refetchInterval: 300000,
  })

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
          <ExerciseChapterList isLoading={isChapterListLoading} data={chapterList} />
        </Stack>
      </Stack>
    </Container>
  )
}

export default StuExerciseList