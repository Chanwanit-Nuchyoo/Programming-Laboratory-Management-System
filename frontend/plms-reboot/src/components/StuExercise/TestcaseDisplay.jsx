/* eslint-disable react/prop-types */
import { Stack, Box, Typography } from "@mui/material"
import TerminalBlock from "@/components/_shared/TerminalBlock";


const Testcase = ({ testcase, index }) => {
  return <Stack>
    <Stack direction="row" spacing="10px" alignItems="center" padding={"10px"} bgcolor={"var(--biscay)"} borderRadius={"8px 8px 0px 0px"} >
      <Typography>Testcase {index + 1}:</Typography>
      {testcase.active === "no" &&
        <Box sx={{ display: "flex", alignItems: "center", padding: "2.5px 10px", bgcolor: "#e84736", borderRadius: "20px" }} >
          <Typography>Not scored</Typography>
        </Box>
      }
    </Stack>

    <TerminalBlock text={testcase.show_to_student === 'yes' ? testcase.testcase_output : "Hidden testcase"} hug="true" style={{ borderRadius: "0px 0px 8px 8px" }} />
  </Stack>
}

const TestcaseDisplay = ({ testcaseList }) => {
  return (
    <Stack spacing={"10px"} >
      {testcaseList.map((testcase, index) => (<Testcase key={index} testcase={testcase} index={index} />))}
    </Stack>
  )
}

export default TestcaseDisplay