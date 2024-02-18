import { Stack } from "@mui/material"
import Split from 'react-split'
import { useQuery } from "@tanstack/react-query"
import { getStudentAssignedExercise, getStudentSubmissionList } from '@/utils/api'
import { useParams } from "react-router-dom"
import { useAtom } from "jotai"
import { userAtom } from "@/store/store"
import { useEffect, useState } from "react"
import { useForm, FormProvider } from "react-hook-form";
import useSubmittable from '@/hooks/useSubmittable';
import { useNavigate } from "react-router-dom";
import { ABS_STU_URL } from '@/utils/constants/routeConst';

import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import ProblemPanel from '@/components/StuExercise/ProblemPanel'
import WorkSpacePanel from '@/components/StuExercise/WorkSpacePanel'
import SubmitPermissionInfoBox from "@/components/_shared/SubmitPermissionInfoBox"

const StuExercise = () => {
  const [user] = useAtom(userAtom)
  const { chapterId, itemId, groupId } = useParams();
  const [selectedTab, setSelectedTab] = useState(0);
  const [selectedSubmission, setSelectedSubmission] = useState(null);
  const [shouldShowLatestSubmission, setShouldShowLatestSubmission] = useState(false);
  const navigate = useNavigate();

  const exerciseQuery = useQuery({
    queryKey: ['student-exercise', user.id, chapterId, itemId],
    queryFn: () => getStudentAssignedExercise(user.id, chapterId, itemId),
    staleTime: Infinity,
  })

  const submissionListQuery = useQuery({
    queryKey: ['submission-list', user.id, chapterId, itemId],
    queryFn: () => getStudentSubmissionList(user.id, chapterId, itemId),
  })

  const { chapterPermissionQuery, ...permission } = useSubmittable(groupId, chapterId);

  const { data: submissionList, isLoading: isSubmissionListLoading, refetch: refetchSubmissionList } = submissionListQuery;

  useEffect(() => {
    const eventSource = new EventSource(`${import.meta.env.VITE_REALTIME_BASE_URL}/subscribe/chapter-permission/${groupId}?chapter_id=${chapterId}`);

    eventSource.onmessage = (event) => {
      chapterPermissionQuery.refetch();
    }

    return () => {
      eventSource.close();
    }
  }, [])

  useEffect(() => {
    if (!isSubmissionListLoading && submissionList.length > 0 && shouldShowLatestSubmission) {
      setSelectedSubmission(submissionList.length - 1);
      setShouldShowLatestSubmission(false);
    }
  }, [isSubmissionListLoading, submissionList]);

  useEffect(() => {
    if (permission.accessPermissionStatus !== 'loading' && ['inaccessible', 'ended'].includes(permission.accessPermissionStatus)) {
      navigate(ABS_STU_URL.STATIC.EXERCISE_LIST);
    }
  }, [permission.accessPermissionStatus])

  const methods = useForm({
    defaultValues: {
      "sourcecode": "",
    }
  });

  const latestSubmission = submissionList && submissionList.length > 0 ? submissionList.slice(-1)[0] : null;

  return <>
    <SubmitPermissionInfoBox
      chapterPermissionQuery={chapterPermissionQuery}
      submitPermissionStatus={permission.submitPermissionStatus}
      secondsLeftBeforeSubmittable={permission.secondsLeftBeforeSubmittable}
      secondsLeftBeforeUnsubmittable={permission.secondsLeftBeforeUnsubmittable}
    />
    <Stack spacing={"20px"} height={"calc(100% - 96px)"} position={"absolute"} sx={{ width: "calc(100% - 64px)" }} >
      <MyBreadCrumbs items={[
        { label: 'Exercise List', href: '#' },
        !exerciseQuery.isError && { label: `Item ${itemId}: ${!exerciseQuery.isLoading && exerciseQuery.data.lab_name}`, href: '#' },
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
            exerciseQuery={exerciseQuery}
            submissionList={{ isLoading: isSubmissionListLoading, value: submissionList, latest: latestSubmission }}
            selectedTab={{ value: selectedTab, setValue: setSelectedTab }}
            selectedSubmission={{ value: selectedSubmission, setValue: setSelectedSubmission }}
          />
          <WorkSpacePanel
            exerciseQuery={exerciseQuery}
            submitPermission={permission.submitPermissionStatus}
            chapterPermissionQuery={chapterPermissionQuery}
            submissionList={{ isLoading: isSubmissionListLoading, value: submissionList, refetch: refetchSubmissionList, latest: latestSubmission }}
            selectedTab={{ value: selectedTab, setValue: setSelectedTab }}
            shouldShowLatestSubmission={{ value: shouldShowLatestSubmission, setValue: setShouldShowLatestSubmission }}
          />
        </Split>
      </FormProvider>
    </Stack>
  </>
}

export default StuExercise