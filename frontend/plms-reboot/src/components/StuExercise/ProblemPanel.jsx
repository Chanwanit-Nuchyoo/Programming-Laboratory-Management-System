/* eslint-disable react/prop-types */
import { useState, useEffect } from "react";
import { Stack, Box, Modal, Typography, Button, CircularProgress } from "@mui/material"
import { modalStyle } from '@/utils';
import { ABS_STU_URL } from "@/utils/constants/routeConst";
import { useNavigate } from "react-router-dom";
import PanelHeader from "@/components/StuExercise/PanelHeader"
import PanelHeaderButton from "@/components/StuExercise/PanelHeaderButton"
import DateRangeIcon from '@mui/icons-material/DateRange';
import Problem from "@/components/StuExercise/Problem"
import ErrorIcon from '@mui/icons-material/Error';
import SubmissionList from "@/components/StuExercise/SubmissionList";
import assignmentIcon from '@/assets/images/assignmenticon.svg'
import historyIcon from '@/assets/images/historyicon.svg'

const tabs = [
  { label: "Problem", icon: <img src={assignmentIcon} alt="Problem Icon" /> }, 
  { label: "Submission history", icon: <img src={historyIcon} alt="History Icon" /> },
]

const ProblemPanel = ({ exercise, submissionList, selectedTab, selectedSubmission }) => {
  const handleSelectTab = (index) => selectedTab.setValue(index)
  const isPassed = submissionList.latest && submissionList.latest.marking !== '-1' && submissionList.latest.marking === '2';
  const [isModalOpen, setIsModalOpen] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    if (exercise.isError) {
      setIsModalOpen(true);
    }
  }, [exercise.isError])

  const handleGoback = () => {
    setIsModalOpen(false);
    navigate(ABS_STU_URL.STATIC.EXERCISE_LIST);
  }

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
      {exercise.isLoading ?
        <Box height={"calc(100% - 54px)"} marginTop={"54px"} width={"100%"} padding={"15px"} sx={{ display: "flex", justifyContent: "center", alignItems: "center" }}>
          <CircularProgress size="50px" sx={{ color: "white" }} />
        </Box>
        :
        <Box height={"calc(100% - 54px)"} marginTop={"54px"} width={"100%"} padding={"15px"} sx={{ overflowY: "auto", position: "absolute" }} >
          {exercise.isError ?
            <Modal
              open={isModalOpen}
            >
              <Stack spacing="20px" sx={{ ...modalStyle, paddingY: "25px", minWidth: "500px" }} >
                <Stack direction="row" spacing="10px" alignItems="center" >
                  <ErrorIcon sx={(theme) => ({ fontSize: '32px', color: theme.palette.error.main })} />
                  <Typography variant='h5' color="error" sx={{ fontWeight: "bolder" }} >Error</Typography>
                </Stack>
                <Stack spacing="5px" sx={{ fontSize: "15px", paddingX: "20px" }} >
                  <Typography >There is no exercise assigned to the random pool.</Typography>
                  <Typography >Please contact your class instructor.</Typography>
                </Stack>
                <Stack spacing="10px" direction="row" justifyContent="flex-end" >
                  <Button variant='contained' onClick={handleGoback} >Go back</Button>
                </Stack>
              </Stack>
            </Modal>
            :
            <>
              {selectedTab.value === 0 && !exercise.isLoading && <Problem exercise={exercise.data} />}
              {selectedTab.value === 1 && <SubmissionList submissionList={submissionList} selectedSubmission={selectedSubmission} />}
            </>
          }
        </Box>
      }
    </Stack>
  )
}

export default ProblemPanel