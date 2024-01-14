import { Stack, Typography, Box, Button } from "@mui/material"
import PanelHeader from "@/components/StuExercise/PanelHeader"
import CodeIcon from '@mui/icons-material/Code';
import ExpandLessIcon from '@mui/icons-material/ExpandLess';
import MyCodeEditor from "@/components/_shared/MyCodeEditor";
import Split from "react-split";
import MyDiff from "@/components/_shared/MyDiff";
import { useEffect, useState } from "react";
import { useForm, Controller } from "react-hook-form";
import { useAtom } from "jotai";
import { userAtom } from "@/store/store";
import { useParams } from "react-router-dom";
import { useMutation, useQueryClient } from "@tanstack/react-query"
import { studentExerciseSubmit } from '@/utils/api'

/* const expected = ` *** Distance *** 
Enter Velocity Acceleration Time: 10,0,10
Your Distance = 80.00`
const actual = ` *** Distance *** 
Enter Velocity Acceleration Time: 10,0,10
Your Distance = 100.00` */

const WorkSpacePanel = ({ submissionList }) => {
  const [isCollapsed, setIsCollapsed] = useState(true);
  const [user, setUser] = useAtom(userAtom);
  const handleCollapse = () => {
    setIsCollapsed(prev => !prev);
  }

  const queryClient = useQueryClient();

  const { chapterId, itemId } = useParams();

  const { control, handleSubmit, setValue } = useForm({
    defaultValues: {
      "sourcecode": "",
    }
  });

  useEffect(() => {
    if (!submissionList.isLoading && submissionList.value.length > 0) {
      setValue("sourcecode", submissionList.latest.sourcecode_content);
    }
  }, [submissionList.isLoading, submissionList.value])

  const { mutate: sendExerciseSubmission } = useMutation({
    mutationFn: studentExerciseSubmit,
    onSuccess: () => {
      queryClient.invalidateQueries(['submission-list', user.id, chapterId, itemId]);
    }
  })

  const onSubmit = (data) => {
    const req_body = {
      stu_id: user.id,
      chapter_id: chapterId,
      item_id: itemId,
      sourcecode: data.sourcecode,
    }
    sendExerciseSubmission(req_body);
  }

  return (
    <>
      <Stack height={"calc(100vh - 140px)"} sx={{ borderRadius: "8px", position: "relative" }}>
        <PanelHeader display={"flex"} justifyContent={"space-between"} alignItems={"center"} >
          <Stack direction={"row"} spacing={"10px"} >
            <CodeIcon />
            <Typography>Code editor</Typography>
          </Stack>
          <Stack>

          </Stack>
        </PanelHeader>

        <Box height={"calc(100% - 44px)"} >
          <Split
            className="work-space"
            sizes={isCollapsed ? [100, 0] : [55, 45]}
            minSize={[0, 54]}
            expandToMin={false}
            gutterSize={10}
            gutterAlign="center"
            direction="vertical"
            cursor="col-resize"
          >
            <Box overflow={"auto"} borderRadius="0px 0px 8px 8px" >
              <Controller
                name="sourcecode"
                control={control}
                render={({ field: { value, onChange } }) => (
                  <MyCodeEditor
                    editable={true}
                    value={value}
                    onChange={onChange}
                    minHeight={"100%"}
                  />
                )}
              />
            </Box>

            <Stack borderRadius={"8px"} sx={{ overflowY: "hidden", position: "relative" }} >
              <PanelHeader display={"flex"} justifyContent={"space-between"} alignItems={"center"}>
                <Stack onClick={handleCollapse} direction={"row"} spacing={"10px"} flex={1} sx={{ cursor: "pointer" }} >
                  <CodeIcon />
                  <Typography>Result</Typography>
                  <ExpandLessIcon sx={{
                    transform: isCollapsed ? "rotate(180deg)" : "rotate(0deg)",
                    transition: "transform 0.2s ease-in-out"
                  }} />
                </Stack>
                <Stack>
                  <Button onClick={handleSubmit(onSubmit)} color="primary" variant="contained" sx={{ textTransform: "none" }} >Submit</Button>
                </Stack>
              </PanelHeader>
              <Stack spacing={"20px"} padding="10px" bgcolor="black" flex={1} sx={{ overflowY: "auto" }} >
                {
                  !submissionList.isLoading && submissionList.latest && submissionList.latest.result?.length > 0 &&
                  submissionList.latest.result.map((item, index) => (
                    <MyDiff key={index} actual={item.actual} expected={item.expected} testcaseNo={item.testcase_no} />
                  ))
                }
              </Stack>
            </Stack>
          </Split>
        </Box>
      </Stack>
    </>
  )
}

export default WorkSpacePanel