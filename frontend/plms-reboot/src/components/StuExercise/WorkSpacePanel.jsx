import { Stack, Typography, Box, Button } from "@mui/material"
import PanelHeader from "@/components/StuExercise/PanelHeader"
import CodeIcon from '@mui/icons-material/Code';
import ExpandLessIcon from '@mui/icons-material/ExpandLess';
import MyCodeEditor from "@/components/_shared/MyCodeEditor";
import Split from "react-split";
import MyDiff from "@/components/_shared/MyDiff";
import { useEffect, useState } from "react";
import { Controller, useFormContext } from "react-hook-form";
import { useAtom } from "jotai";
import { userAtom } from "@/store/store";
import { useParams } from "react-router-dom";
import { useMutation, useQueryClient } from "@tanstack/react-query"
import codingIcon from '@/assets/images/codingicon.svg'
import { studentExerciseSubmit, checkKeyword } from '@/utils/api'
import { getConstraintsFailedMessage } from '@/utils'

/* const expected = ` *** Distance *** 
Enter Velocity Acceleration Time: 10,0,10
Your Distance = 80.00`
const actual = ` *** Distance *** 
Enter Velocity Acceleration Time: 10,0,10
Your Distance = 100.00` */

const WorkSpacePanel = ({ exercise, submissionList, selectedTab, shouldShowLatestSubmission }) => {

  const [isCollapsed, setIsCollapsed] = useState(true);
  const [saveStatus, setSaveStatus] = useState('');
  const [user, setUser] = useAtom(userAtom);
  const handleCollapse = () => {
    setIsCollapsed(prev => !prev);
  }

  const queryClient = useQueryClient();

  const { chapterId, itemId } = useParams();

  const { control, handleSubmit, setValue, watch } = useFormContext();

  const watchedSourcecode = watch("sourcecode");

  const { mutate: sendExerciseSubmission } = useMutation({
    mutationFn: studentExerciseSubmit,
    onSuccess: () => {
      queryClient.invalidateQueries(['submission-list', user.id, chapterId, itemId]);
      shouldShowLatestSubmission.setValue(true);
    }
  });

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
        }, 3000); // 3000ms = 3s

        return () => clearTimeout(timer);
      } else {
        setSaveStatus('Saved!');
      }
    } else {
      setSaveStatus('');
    }
  }, [watchedSourcecode, user.id, chapterId, itemId]);

  const onSubmit = async (data) => {
    try {
      if (exercise.data.user_defined_constraints !== null) {
        const req_body = {
          "sourcecode": data.sourcecode,
          "exercise_kw_list": exercise.data.user_defined_constraints,
        }
        const response_body = await checkKeyword(req_body)
        const is_kw_passed = response_body.status === "passed";

        if (!is_kw_passed) {
          const message = getConstraintsFailedMessage(response_body);
          alert(message);
          return;
        } else {
          if (data.sourcecode !== "" || data.sourcecode !== null) {
            const req_body = {
              stu_id: user.id,
              chapter_id: chapterId,
              item_id: itemId,
              sourcecode: data.sourcecode,
            }
            sendExerciseSubmission(req_body);
            selectedTab.setValue(1);
          }
        }
      } else {
        if (data.sourcecode !== "" || data.sourcecode !== null) {
          const req_body = {
            stu_id: user.id,
            chapter_id: chapterId,
            item_id: itemId,
            sourcecode: data.sourcecode,
          }
          sendExerciseSubmission(req_body);
          selectedTab.setValue(1);
        }
      }
    } catch (error) {
      console.log(error);
    }
  }

  return (
    <>
      <Stack height={"calc(100vh - 140px)"} sx={{ borderRadius: "8px", position: "relative" }}>
        <PanelHeader display={"flex"} justifyContent={"space-between"} alignItems={"center"} >
          <Stack direction={"row"} spacing={"10px"} >
            <img src={codingIcon} alt="Coding Icon" />
            <Typography>Code editor</Typography>
            <Typography sx={{ fontSize: "16px", color: "var(--raven)" }} >{saveStatus}</Typography>
          </Stack>
          <Stack>
            <Button disabled={!watchedSourcecode || exercise.isError} onClick={handleSubmit(onSubmit)} color="primary" variant="contained" sx={{ textTransform: "none" }} >Submit</Button>
          </Stack>
        </PanelHeader>

        <Box height={"calc(100% - 44px)"} >
          <Box overflow={"auto"} height={"100%"} borderRadius="0px 0px 8px 8px" /* onDrop={handleFileDrop} */ >
            <Controller
              name="sourcecode"
              control={control}
              render={({ field: { value, onChange } }) => (
                <MyCodeEditor
                  editable={exercise.isError ? false : true}
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