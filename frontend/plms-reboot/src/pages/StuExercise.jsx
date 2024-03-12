import { Stack } from "@mui/material"
import Split from 'react-split'
import { useQuery, useQueryClient } from "@tanstack/react-query"
import { getStudentAssignedExercise, getStudentSubmissionList } from '@/utils/api'
import { useParams } from "react-router-dom"
import { useAtom, useSetAtom } from "jotai"
import { userAtom, sidebarSelectedAtom } from "@/store/store"
import { useEffect, useState, useMemo, useCallback, useRef } from "react"
import { useForm, FormProvider } from "react-hook-form";
import useSubmittable from '@/hooks/useSubmittable';
import { useNavigate } from "react-router-dom";
import { ABS_STU_URL } from '@/utils/constants/routeConst';
import { getChapterPermission } from '@/utils/api';

import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import ProblemPanel from '@/components/StuExercise/ProblemPanel'
import WorkSpacePanel from '@/components/StuExercise/WorkSpacePanel'
import SubmitPermissionInfoBox from "@/components/_shared/SubmitPermissionInfoBox"
import useEventSource from "@/hooks/useEventSource"
import useLogAction from "@/hooks/useLogAction"

const StuExercise = () => {
  const [user] = useAtom(userAtom)
  const { chapterId, itemId, groupId } = useParams();
  const [selectedTab, setSelectedTab] = useState(0);
  const [selectedSubmission, setSelectedSubmission] = useState(null);
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const [shouldShowLatestSubmission, setShouldShowLatestSubmission] = useState(false);
  const queryClient = useQueryClient();
  const navigate = useNavigate();
  const hasLogged = useRef(false);

  const logActionMutation = useLogAction();

  useEffect(() => {
    setSelected('stu_exercise_list');

    if (!hasLogged.current) {
      hasLogged.current = true;
      logActionMutation.mutate({
        action: `Student::lab_exercise chapter:${chapterId} item:${itemId}`,
        page_name: "lab_exercise"
      })
    }

    return () => {
      queryClient.removeQueries(['chapter-permission', groupId]);
    };
  }, []);

  const chapterPermissionQuery = useQuery({
    queryKey: ['chapter-permission', groupId],
    queryFn: () => getChapterPermission(groupId),
  });

  const { ...permission } = useSubmittable(groupId, chapterId, chapterPermissionQuery);

  useEventSource(
    `${import.meta.env.VITE_REALTIME_BASE_URL}/subscribe/chapter-permission/${groupId}`,
    chapterPermissionQuery.refetch
  );

  const exerciseQuery = useQuery({
    queryKey: ['student-exercise', user.id, chapterId, itemId],
    queryFn: () => getStudentAssignedExercise(user.id, chapterId, itemId),
  })

  const submissionListQuery = useQuery({
    queryKey: ['submission-list', user.id, chapterId, itemId],
    queryFn: () => getStudentSubmissionList(user.id, chapterId, itemId),
  })


  const { data: submissionList, isLoading: isSubmissionListLoading, refetch: refetchSubmissionList } = submissionListQuery;


  const latestSubmission = useMemo(() => submissionList && submissionList.length > 0 ? submissionList.slice(-1)[0] : null, [submissionList]);

  const handleExamFlag = useCallback(() => {
    /* console.log('handleExamFlag', permission.examFlag, chapterPermissionQuery.isPending, chapterPermissionQuery.data); */
    if (permission.examFlag && !chapterPermissionQuery.isPending && chapterPermissionQuery.data) {
      if (chapterPermissionQuery.data[parseInt(chapterId) - 1].chapter_name.split(' ')[0] !== 'Quiz') {
        navigate(ABS_STU_URL.STATIC.EXERCISE_LIST);
      }
    }
  }, [permission.examFlag, chapterPermissionQuery, navigate, chapterId]);

  useEffect(handleExamFlag, [handleExamFlag]);

  const handleSubmissionListLoading = useCallback(() => {
    if (!isSubmissionListLoading && submissionList.length > 0 && shouldShowLatestSubmission) {
      setSelectedSubmission(submissionList.length - 1);
      setShouldShowLatestSubmission(false);
    }
  }, [isSubmissionListLoading, submissionList, shouldShowLatestSubmission]);

  useEffect(handleSubmissionListLoading, [handleSubmissionListLoading]);

  const handlePermissionStatus = useCallback(() => {
    /* console.log('handlePermissionStatus', permission.accessPermissionStatus); */
    if (permission.accessPermissionStatus !== 'loading' && ['notStarted', 'inaccessible', 'ended'].includes(permission.accessPermissionStatus)) {
      navigate(ABS_STU_URL.STATIC.EXERCISE_LIST);
    }
  }, [permission.accessPermissionStatus, navigate]);

  useEffect(handlePermissionStatus, [handlePermissionStatus]);

  const methods = useForm({
    defaultValues: {
      "sourcecode": "",
    }
  });

  return <>
    < SubmitPermissionInfoBox
      chapterId={chapterId}
      chapterPermissionQuery={chapterPermissionQuery}
      submitPermissionStatus={permission.submitPermissionStatus}
      secondsLeftBeforeSubmittable={permission.secondsLeftBeforeSubmittable}
      secondsLeftBeforeUnsubmittable={permission.secondsLeftBeforeUnsubmittable}
    />
    <Stack spacing={"20px"} height={"calc(100% - 96px)"} position={"absolute"} sx={{ width: "calc(100% - 64px)" }} >
      <MyBreadCrumbs items={[
        { label: 'Exercise List', href: ABS_STU_URL.STATIC.EXERCISE_LIST },
        !exerciseQuery.isError && { label: `Chapter ${chapterId} Item ${itemId}: ${!exerciseQuery.isLoading && exerciseQuery.data.lab_name}`, href: '#' },
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