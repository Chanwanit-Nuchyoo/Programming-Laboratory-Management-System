import { buttonStyle } from "@/utils";
import { Button, Typography, Box, Stack } from "@mui/material";

const extendedButtonStyle = { ...buttonStyle, textOverflow: "ellipsis", overflow: "hidden", whiteSpace: "nowrap" }
const boxStyle = { display: "flex", alignItems: "center", justifyContent: "center" }

const SubmissionList = ({ submissionList }) => {
  return (
    <>
      <table style={{ width: "100%" }} >
        <thead>
          <tr>
            <th style={{ width: '70px' }} className="table-head-column2" >
              <Button fullWidth sx={extendedButtonStyle}>
                <Typography>Times</Typography>
              </Button>
            </th>
            <th className="table-head-column2" >
              <Button fullWidth sx={extendedButtonStyle}>
                <Typography >Status</Typography>
              </Button>
            </th>
            <th className="table-head-column2" >
              <Button fullWidth sx={extendedButtonStyle}>
                <Typography >Submission date-time</Typography>
              </Button>
            </th>
            <th className="table-head-column2" >
              <Button fullWidth sx={extendedButtonStyle}>
                <Typography >View code</Typography>
              </Button>
            </th>
            <th className="table-head-column2" >
              <Button fullWidth sx={extendedButtonStyle}>
                <Typography >Duplicate</Typography>
              </Button>
            </th>
          </tr>
        </thead>
        <tbody>
          {submissionList.value && [...submissionList.value].reverse().map((submission, index) => {
            const isPassed = submission.marking !== '-1' && submission.marking === '2'

            return (
              <tr key={index} >
                <td style={{ width: '70px' }} className="table-body-column2" >
                  <Box sx={boxStyle}>
                    <Typography>{submissionList.value.length - index}</Typography>
                  </Box>
                </td>
                <td className="table-body-column2" >
                  <Box sx={boxStyle}>
                    <Typography sx={{
                      display: "flex",
                      justifyContent: "center",
                      alignItems: "center",
                      height: "34px",
                      width: "90px",
                      bgcolor: isPassed ? "#4EC753" : "#F44336",
                      borderRadius: "20px",
                    }} >{submission.marking === "2" ? "Passed" : "Not passed"}</Typography>
                  </Box>
                </td>
                <td className="table-body-column2" >
                  <Box sx={boxStyle}>
                    <Typography>{submission.time_submit}</Typography>
                  </Box>
                </td>
                <td className="table-body-column2" >
                  <Box sx={boxStyle}>
                    <Typography>View code</Typography>
                  </Box>
                </td>
                <td className="table-body-column2" >
                  <Box sx={boxStyle}>
                    <Typography>Duplicate</Typography>
                  </Box>
                </td>
              </tr>
            )
          })}
        </tbody>
      </table>
      {submissionList.value && submissionList.value.length === 0 &&
        <Stack padding="20px" direction="row" justifyContent="center" alignItems="center" >
          <Typography>No submission yet....</Typography>
        </Stack >
      }
    </>
  )
}

export default SubmissionList