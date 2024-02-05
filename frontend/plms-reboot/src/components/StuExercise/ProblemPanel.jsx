/* eslint-disable react/prop-types */
import { useState } from "react";
import { useQuery } from "@tanstack/react-query"
import { Stack, Box } from "@mui/material"
import PanelHeader from "@/components/StuExercise/PanelHeader"
import PanelHeaderButton from "@/components/StuExercise/PanelHeaderButton"
import DateRangeIcon from '@mui/icons-material/DateRange';
import Problem from "@/components/StuExercise/Problem"
import SubmissionList from "@/components/StuExercise/SubmissionList";
import assignmentIcon from '@/assets/images/assignmenticon.svg'
import historyIcon from '@/assets/images/historyicon.svg'

const tabs = [
  { label: "Problem", icon: <img src={assignmentIcon} alt="Problem Icon" /> }, 
  { label: "Submission history", icon: <img src={historyIcon} alt="History Icon" /> },
]

const ProblemPanel = ({ exercise, submissionList, selectedTab }) => {
  const handleSelectTab = (index) => selectedTab.setValue(index)
  const isPassed = submissionList.latest && submissionList.latest.marking !== '-1' && submissionList.latest.marking === '2'

  return (
    <Stack height={"100%"} sx={{ bgcolor: "#0D1117", borderRadius: "8px", position: "relative" }} >
      <PanelHeader display={"flex"} justifyContent={"space-between"} alignItems={"center"} >
        <Stack direction={"row"} spacing={"10px"} >
          {tabs.map((tab, index) => <PanelHeaderButton key={index} onClick={() => handleSelectTab(index)} title={tab.label} startIcon={tab.icon} isactive={selectedTab.value === index} />)}
        </Stack>
        <Box sx={{
          bgcolor: isPassed ? "#4EC753" : "#737984",
          color: isPassed ? 'black' : "white",
          fontWeight: "bold",
          borderRadius: "8px",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          paddingY: "7px",
          width: "80px"
        }}>
          {submissionList.latest && submissionList.latest.marking !== '-1' ? submissionList.latest.marking : '0'}/2
        </Box>
      </PanelHeader>
      <Box height={"calc(100% - 54px)"} marginTop={"54px"} width={"100%"} padding={"15px"} sx={{ overflowY: "auto", position: "absolute" }} >
        {selectedTab.value === 0 && !exercise.isLoading && <Problem exercise={exercise.value} />}
        {selectedTab.value === 1 && <SubmissionList submissionList={submissionList} />}
      </Box>
    </Stack>
  )
}

export default ProblemPanel