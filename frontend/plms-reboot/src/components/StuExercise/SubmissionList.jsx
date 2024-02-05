import { buttonStyle } from "@/utils";
import { Button, Typography, Box, Stack } from "@mui/material";
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import { useState } from "react";
import { useFormContext } from "react-hook-form";
import { statusProperties } from "@/utils";
import moment from 'moment';
import SubmissionInfo from "@/components/StuExercise/SubmissionInfo";

const col_width = ["120px", "180px", "100px", "250px", ""];

const headers = [
  { title: "# Attempt", width: col_width[0] },
  { title: "Status", width: col_width[1] },
  { title: "Score", width: col_width[2] },
  { title: "Submitted Time", width: col_width[3] },
  { title: "Feedback", width: col_width[4] },
];

const extendedButtonStyle = { ...buttonStyle, textOverflow: "ellipsis", overflow: "hidden", whiteSpace: "nowrap", minWidth: "290-content", bgcolor: "var(--mirage)" }
const boxStyle = { display: "flex", alignItems: "center", justifyContent: "center", whiteSpace: "nowrap", textOverflow: "ellipsis", overflow: "auto" }

const TableHeader = ({ header }) => {
  const feedback = header.title === "Feedback" ? { flex: 1, minWidth: "290px" } : {};

  return (
    <Button variant="contained" sx={{ ...extendedButtonStyle, width: header.width, flexShrink: 0, borderRadius: "0px", ...feedback }} >
      <Typography>{header.title}</Typography>
    </Button>
  )
}

const TableRow = ({ submission, index, setSelected }) => {
  const { message, color } = statusProperties[submission.status];

  const is_odd = index % 2 === 1;
  const rowBgColor = is_odd ? "#1E1E1E" : "#2D2D2D";

  const handleClicked = () => {
    setSelected(index);
  }

  return (
    <Stack
      direction="row"
      width="100%"
      sx={{
        paddingY: "10px",
        bgcolor: rowBgColor,
        '&:hover': {
          backgroundColor: "var(--hover)",
          cursor: "pointer"
        }
      }}
      onClick={handleClicked}
    >
      <Box sx={{ ...boxStyle, flexShrink: 0, width: col_width[0] }} >
        <Typography>{index + 1}</Typography>
      </Box>
      <Box sx={{ ...boxStyle, flexShrink: 0, width: col_width[1] }} >
        <Typography sx={{ color: color }} >{message}</Typography>
      </Box>
      <Box sx={{ ...boxStyle, flexShrink: 0, width: col_width[2] }} >
        <Typography>{submission.marking}/2</Typography>
      </Box>
      <Box sx={{ ...boxStyle, flexShrink: 0, width: col_width[3] }} >
        <Typography>{moment(submission.time_submit).format('MMM D, YYYY HH:mm:ss')}</Typography>
      </Box>
      <Box sx={{ ...boxStyle, paddingX: "10px", justifyContent: "flex-start", flexShrink: 0, width: col_width[4], flex: 1, minWidth: "290px" }} >
        <Typography sx={{ color: submission.feedback ? "white" : "#ccc" }} >{submission.feedback ? submission.feedback : "No feedback.."}</Typography>
      </Box>
    </Stack>
  )
}

const SubmissionList = ({ submissionList, selectedSubmission }) => {

  return (
    <Stack spacing="0px" sx={{ borderRadius: "8px", overflow: "hidden" }}  >
      {selectedSubmission.value !== null ?
        <>
          <SubmissionInfo selectedSubmission={selectedSubmission} />
        </>
        :
        <>
          <Stack direction="row" width="100%">
            {headers.map((header, index) => (
              <TableHeader key={index} header={header} />
            ))}
          </Stack>
          {
            submissionList.value && submissionList.value.length === 0 &&
            <Stack padding="20px" direction="row" justifyContent="center" alignItems="center" >
              <Typography>No submission yet....</Typography>
            </Stack>
          }
          {submissionList.value && [...submissionList.value].reverse().map((submission, index) => {
            return <TableRow key={index} submission={submission} setSelected={selectedSubmission.setValue} index={submissionList.value.length - 1 - index} />
          })}
        </>
      }
    </Stack>
  )
}

export default SubmissionList