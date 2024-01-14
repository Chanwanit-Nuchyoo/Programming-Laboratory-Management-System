import { Stack } from "@mui/material"
import Split from 'react-split'
import { useQuery } from "@tanstack/react-query"
import { getStudentAssignedExercise, getStudentSubmissionList } from '@/utils/api'
import { useParams } from "react-router-dom"
import { useAtom } from "jotai"
import { userAtom } from "@/store/store"
import { useState } from "react"

import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import ProblemPanel from '@/components/StuExercise/ProblemPanel'
import WorkSpacePanel from '@/components/StuExercise/WorkSpacePanel'

const StuExcercise = () => {
  const [user] = useAtom(userAtom)
  const { chapterId, itemId } = useParams();
  const [selectedTab, setSelectedTab] = useState(0);

  const { data: exercise, isLoading: isExerciseLoading } = useQuery({
    queryKey: ['student-exercise', user.id, chapterId, itemId],
    queryFn: () => getStudentAssignedExercise(user.id, chapterId, itemId),
    staleTime: Infinity,
  })

  const { data: submissionList, isLoading: isSubmissionListLoading } = useQuery({
    queryKey: ['submission-list', user.id, chapterId, itemId],
    queryFn: () => getStudentSubmissionList(user.id, chapterId, itemId),
    refetchInterval: ({ state: { data } }) => {
      if (data && Array.isArray(data) && data.length !== 0) {
        if (data.every(submission => submission.is_ready === "yes")) {
          return false;
        } else {
          return 1000;
        }
      } else if (data && Array.isArray(data)) {
        return false;
      } else {
        return 1000;
      }
    }
  })


  const latestSubmission = submissionList && submissionList.length > 0 ? submissionList.slice(-1)[0] : null;

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
      <ProblemPanel
        exercise={{ isLoading: isExerciseLoading, value: exercise }}
        submissionList={{ isLoading: isSubmissionListLoading, value: submissionList, latest: latestSubmission }}
        selectedTab={{ value: selectedTab, setValue: setSelectedTab }}
      />
      <WorkSpacePanel
        exercise={{ isLoading: isExerciseLoading, value: exercise }}
        submissionList={{ isLoading: isSubmissionListLoading, value: submissionList, latest: latestSubmission }}
      />
    </Split>

  </Stack>
}

export default StuExcercise