/* eslint-disable react/prop-types */
import { Stack, Box, Typography } from "@mui/material"
import TerminalBlock from "@/components/_shared/TerminalBlock";


const Testcase = ({ testcase, index }) => {
  return <Stack>
    <Box padding={"10px"} bgcolor={"var(--biscay)"} borderRadius={"8px 8px 0px 0px"} >
      <Typography>Testcase {index + 1}:</Typography>
    </Box>
    <Box borderRadius={"0px 0px 8px 8px"} >
      <TerminalBlock text={testcase.show_to_student === 'yes' ? testcase.testcase_output : "Hidden testcase"} hug="true" />
    </Box>
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