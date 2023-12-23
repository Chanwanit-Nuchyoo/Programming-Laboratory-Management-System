/* eslint-disable react/prop-types */
import { Stack, Box } from "@mui/material"
import PanelHeader from "@/components/StuExercise/PanelHeader"
import PanelHeaderButton from "@/components/StuExercise/PanelHeaderButton"
import DateRangeIcon from '@mui/icons-material/DateRange';

import Problem from "@/components/StuExercise/Problem"

const ProblemPanel = ({ exercise, isLoading }) => {
  return (
    <Stack height={"100%"} sx={{ bgcolor: "black", borderRadius: "8px", position: "relative" }} >
      <PanelHeader display={"flex"} justifyContent={"space-between"} alignItems={"center"} >
        <Stack direction={"row"} spacing={"10px"} >
          <PanelHeaderButton title={"Problem"} startIcon={<DateRangeIcon />} isactive={true} />
          <PanelHeaderButton title={"Submission history"} num={"0"} startIcon={<DateRangeIcon />} />
        </Stack>
        <Box sx={{
          bgcolor: "#737984",
          borderRadius: "8px",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          paddingY: "7px",
          width: "80px"
        }}>
          {"0"}/2
        </Box>
      </PanelHeader>
      {!isLoading && <Problem exercise={exercise} />}
    </Stack>
  )
}

export default ProblemPanel