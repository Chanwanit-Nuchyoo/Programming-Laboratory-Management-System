import { Stack, Typography, Box, Button, CircularProgress } from "@mui/material"
import PanelHeader from "@/components/StuExercise/PanelHeader"
import MyCodeEditor from "@/components/_shared/MyCodeEditor";
import { useEffect, useState, useRef } from "react";
import { Controller, set, useFormContext } from "react-hook-form";
import { useAtom } from "jotai";
import { userAtom } from "@/store/store";
import { useParams } from "react-router-dom";
import { useMutation, useQueryClient } from "@tanstack/react-query"
import codingIcon from '@/assets/images/codingicon.svg'
import { studentExerciseSubmit, checkKeyword } from '@/utils/api'
import { getConstraintsFailedMessage } from '@/utils'
import { v4 as uuidv4 } from 'uuid';

const WorkSpacePanel = ({ exerciseQuery, submitPermission, submissionList, selectedTab, shouldShowLatestSubmission }) => {
  const [saveStatus, setSaveStatus] = useState('');
  const [alreadyPassed, setAlreadyPassed] = useState(false);
  const eventSourceRef = useRef(null);
  const [user, setUser] = useAtom(userAtom);

  const queryClient = useQueryClient();

  const { chapterId, itemId } = useParams();

  const { control, handleSubmit, setValue, watch } = useFormContext();

  const watchedSourcecode = watch("sourcecode");

  const subscribeSubmissionResult = (job_id) => {
    eventSourceRef.current = new EventSource(`${import.meta.env.VITE_REALTIME_BASE_URL}/subscribe/submission-result/${job_id}`);

    eventSourceRef.current.onmessage = (event) => {
      shouldShowLatestSubmission.setValue(true);
      submissionList.refetch();
      eventSourceRef.current.close();
      eventSourceRef.current = null;
    }
  }

  const sendExerciseSubmission = useMutation({
    mutationFn: studentExerciseSubmit,
    onSuccess: () => {
      queryClient.invalidateQueries(['submission-list', user.id, chapterId, itemId]);
    },
    onError: (err) => {
      alert(err.response.data.message)
      eventSourceRef.current.close();
      selectedTab.setValue(0);
      eventSourceRef.current = null;
    }
  });

  const checkKeywordMutation = useMutation({
    mutationFn: checkKeyword,
    onSuccess: async (response_body) => {
      const is_kw_passed = response_body.status === "passed";

      if (!is_kw_passed) {
        const message = getConstraintsFailedMessage(response_body);
        alert(message);
        return;
      } else {
        if (watchedSourcecode !== "" || watchedSourcecode !== null) {
          const jobId = uuidv4();
          const req_body = {
            stu_id: user.id,
            chapter_id: chapterId,
            item_id: itemId,
            sourcecode: watchedSourcecode,
            job_id: jobId,
          }
          subscribeSubmissionResult(jobId);
          selectedTab.setValue(1);
          sendExerciseSubmission.mutate(req_body);
        }
      }
    },
    onError: (error) => {
      console.log(error);
      selectedTab.setValue(0);
      alert(error.message);
    }
  });

  useEffect(() => {
    if (!submissionList.isLoading && submissionList.value && submissionList.value.length > 0) {
      const acceptedSubmission = submissionList.value.filter(submission => submission.status === "accepted");
      if (acceptedSubmission.length > 0) {
        setAlreadyPassed(true);
      }
    }
  }, [submissionList.isLoading, submissionList.value]);

  useEffect(() => {
    if (!submissionList.isLoading) {
      const localSourcecode = localStorage.getItem(`sourcecode-${user.id}-${chapterId}-${itemId}`);
      if (localSourcecode) {
        setValue("sourcecode", localSourcecode);
      } else if (submissionList.value.length > 0) {
        setValue("sourcecode", submissionList.latest.sourcecode_content);
      }
    }
  }, [submissionList.isLoading, submissionList.value, user.id, chapterId, itemId, setValue]);

  useEffect(() => {
    if (watchedSourcecode) {
      if (watchedSourcecode !== localStorage.getItem(`sourcecode-${user.id}-${chapterId}-${itemId}`)) {
        setSaveStatus('Saving...');
        const timer = setTimeout(() => {
          localStorage.setItem(`sourcecode-${user.id}-${chapterId}-${itemId}`, watchedSourcecode);
          setSaveStatus('Saved!');
        }, 1000);

        return () => clearTimeout(timer);
      } else {
        setSaveStatus('Saved!');
      }
    } else {
      setSaveStatus('');
    }
  }, [watchedSourcecode, user.id, chapterId, itemId]);

  const onSubmit = async () => {
    const req_body = {
      "sourcecode": watchedSourcecode,
      "exercise_kw_list": exerciseQuery.data.user_defined_constraints || {
        "classes": [],
        "imports": [],
        "methods": [],
        "functions": [],
        "variables": [],
        "reserved_words": []
      },
    };
    checkKeywordMutation.mutate(req_body);
  }

  const passPermission = submitPermission === "submittable" || submitPermission === "timer-paused";

  return (
    <>
      <Stack height={"calc(100vh - 140px)"} sx={{ borderRadius: "8px", position: "relative" }}>
        <PanelHeader display={"flex"} justifyContent={"space-between"} alignItems={"center"} >
          <Stack direction={"row"} spacing={"10px"} >
            <img src={codingIcon} alt="Coding Icon" />
            <Typography>Code editor</Typography>
          </Stack>
          <Stack>
            <Button
              disabled={!watchedSourcecode || exerciseQuery.isError || saveStatus !== "Saved!" || sendExerciseSubmission.isPending || checkKeywordMutation.isPending || !passPermission || alreadyPassed}
              startIcon={(saveStatus === "Saving..." || sendExerciseSubmission.isPending || checkKeywordMutation.isPending) && <CircularProgress size="20px" sx={{ color: "white" }} />}
              onClick={handleSubmit(onSubmit)}
              color="primary"
              variant="contained"
              sx={{ textTransform: "none" }} >
              {saveStatus === "Saving..." ? "Saving..." : "Submit"}
            </Button>
          </Stack>
        </PanelHeader>

        <Box height={"calc(100% - 44px)"} >
          <Box overflow={"auto"} height={"100%"} borderRadius="0px 0px 8px 8px">
            <Controller
              name="sourcecode"
              control={control}
              render={({ field: { value, onChange } }) => (
                <MyCodeEditor
                  editable={exerciseQuery.isError || alreadyPassed ? false : true}
                  value={value}
                  onChange={onChange}
                  minHeight={"100%"}
                />
              )}
            />
          </Box>
        </Box>
      </Stack>
    </>
  )
}

export default WorkSpacePanel