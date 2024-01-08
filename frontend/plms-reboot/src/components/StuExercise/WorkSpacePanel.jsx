import { Stack, Typography, Box, Button } from "@mui/material"
import PanelHeader from "@/components/StuExercise/PanelHeader"
import CodeIcon from '@mui/icons-material/Code';
import ExpandLessIcon from '@mui/icons-material/ExpandLess';
import MyCodeEditor from "@/components/_shared/MyCodeEditor";
import Split from "react-split";
import MyDiff from "@/components/_shared/MyDiff";
import { useEffect, useRef, useState } from "react";
import { useForm, Controller } from "react-hook-form";

/* const expected = ` *** Distance *** 
Enter Velocity Acceleration Time: 10,0,10
Your Distance = 80.00`
const actual = ` *** Distance *** 
Enter Velocity Acceleration Time: 10,0,10
Your Distance = 100.00` */

const WorkSpacePanel = () => {
  const [isCollapsed, setIsCollapsed] = useState(true);

  const handleCollapse = () => {
    setIsCollapsed(prev => !prev);
  }

  const { control, handleSubmit } = useForm({
    defaultValues: {
      sourcecode: ""
    }
  });

  const onSubmit = (data) => {
    console.log(data);
  }

  return (
    <Stack height={"100%"} sx={{ borderRadius: "8px", position: "relative" }}>
      <PanelHeader display={"flex"} justifyContent={"space-between"} alignItems={"center"} >
        <Stack direction={"row"} spacing={"10px"} >
          <CodeIcon />
          <Typography>Code editor</Typography>
        </Stack>
        <Stack>

        </Stack>
      </PanelHeader>

      <Box sx={{ flex: "1" }} >
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
              name="source"
              control={control}
              render={({ field: { value, onChange } }) => (
                <MyCodeEditor
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
            <Stack spacing={"10px"} padding="5px" bgcolor="black" height="100%" sx={{ overflowY: "auto" }} >
              {/* 
                <MyDiff actual={actual} expected={expected} />
                <MyDiff actual={actual} expected={expected} />
                <MyDiff actual={actual} expected={expected} />
                <MyDiff actual={actual} expected={expected} /> 
              */}
            </Stack>
          </Stack>
        </Split>
      </Box>
    </Stack>
  )
}

export default WorkSpacePanel