import { Stack } from "@mui/material"
import Split from 'react-split'
import { useQuery } from "@tanstack/react-query"
import { getStudentAssignedExercise } from '@/utils/api'
import { useParams } from "react-router-dom"
import { useAtom } from "jotai"
import { userAtom } from "@/store/store"

import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import ProblemPanel from '@/components/StuExercise/ProblemPanel'
import WorkSpacePanel from '@/components/StuExercise/WorkSpacePanel'

const StuExcercise = () => {
  const [user] = useAtom(userAtom)
  const { chapterId, itemId } = useParams()

  const { data: exercise, isLoading: isExerciseLoading } = useQuery({
    queryKey: ['student-exercise', user.id, chapterId, itemId],
    queryFn: () => getStudentAssignedExercise(user.id, chapterId, itemId),
    staleTime: Infinity,
  })

  return <Stack spacing={"20px"} height={"calc(100% - 96px)"} position={"absolute"} sx={{ width: "calc(100% - 64px)" }} >
    <MyBreadCrumbs items={[
      { label: 'Exercise List', href: '#' },
      { label: `Item ${itemId}: ${!isExerciseLoading && exercise.lab_name}`, href: '#' },
    ]} />

    <Split
      className="split stu-exercise"
      sizes={[45, 55]}
      minSize={460}
      expandToMin={false}
      gutterSize={10}
      gutterAlign="center"
      snapOffset={30}
      dragInterval={1}
      direction="horizontal"
      cursor="col-resize"
    >
      <ProblemPanel exercise={exercise} isLoading={isExerciseLoading} />
      <WorkSpacePanel testcase={exercise} isLoading={isExerciseLoading} />
    </Split>

  </Stack>
}

export default StuExcercise