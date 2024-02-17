import { Stack } from "@mui/material"
import Split from 'react-split'
import { useQuery } from "@tanstack/react-query"
import { getStudentAssignedExercise, getStudentSubmissionList } from '@/utils/api'
import { useParams } from "react-router-dom"
import { useAtom } from "jotai"
import { userAtom } from "@/store/store"
import { useEffect, useState } from "react"
import { useForm, FormProvider } from "react-hook-form";

import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import ProblemPanel from '@/components/StuExercise/ProblemPanel'
import WorkSpacePanel from '@/components/StuExercise/WorkSpacePanel'

const StuExercise = () => {
  const [user] = useAtom(userAtom)
  const { chapterId, itemId } = useParams();
  const [selectedTab, setSelectedTab] = useState(0);
  const [selectedSubmission, setSelectedSubmission] = useState(null);
  const [shouldShowLatestSubmission, setShouldShowLatestSubmission] = useState(false);

  const exercise = useQuery({
    queryKey: ['student-exercise', user.id, chapterId, itemId],
    queryFn: () => getStudentAssignedExercise(user.id, chapterId, itemId),
    staleTime: Infinity,
  })

  const { data: submissionList, isLoading: isSubmissionListLoading, refetch: refetchSubmissionList } = useQuery({
    queryKey: ['submission-list', user.id, chapterId, itemId],
    queryFn: () => getStudentSubmissionList(user.id, chapterId, itemId),
  })

  useEffect(() => {
    if (!isSubmissionListLoading && submissionList.length > 0 && shouldShowLatestSubmission) {
      setSelectedSubmission(submissionList.length - 1);
      setShouldShowLatestSubmission(false);
    }
  }, [isSubmissionListLoading, submissionList]);

  const methods = useForm({
    defaultValues: {
      "sourcecode": "",
    }
  });

  const latestSubmission = submissionList && submissionList.length > 0 ? submissionList.slice(-1)[0] : null;

  return <Stack spacing={"20px"} height={"calc(100% - 96px)"} position={"absolute"} sx={{ width: "calc(100% - 64px)" }} >
    <MyBreadCrumbs items={[
      { label: 'Exercise List', href: '#' },
      !exercise.isError && { label: `Item ${itemId}: ${!exercise.isLoading && exercise.data.lab_name}`, href: '#' },
    ]} />

    <FormProvider {...methods} >
      <Split
        className="split stu-exercise"
        sizes={[50, 50]}
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
          exercise={exercise}
          submissionList={{ isLoading: isSubmissionListLoading, value: submissionList, latest: latestSubmission }}
          selectedTab={{ value: selectedTab, setValue: setSelectedTab }}
          selectedSubmission={{ value: selectedSubmission, setValue: setSelectedSubmission }}
        />
        <WorkSpacePanel
          exercise={exercise}
          submissionList={{ isLoading: isSubmissionListLoading, value: submissionList, refetch: refetchSubmissionList, latest: latestSubmission }}
          selectedTab={{ value: selectedTab, setValue: setSelectedTab }}
          shouldShowLatestSubmission={{ value: shouldShowLatestSubmission, setValue: setShouldShowLatestSubmission }}
        />
      </Split>
    </FormProvider>
  </Stack>
}

export default StuExercise