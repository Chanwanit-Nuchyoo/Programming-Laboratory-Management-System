import { EditorView } from 'codemirror';
import { EditorState } from '@codemirror/state';
import CodeMirrorMerge from 'react-codemirror-merge';
import { githubDark } from "@uiw/codemirror-theme-github"
import { Box, Stack, Typography } from '@mui/material';
import correct from "@/assets/images/correct.svg"
import incorrect from "@/assets/images/incorrect.svg"

const Original = CodeMirrorMerge.Original;
const Modified = CodeMirrorMerge.Modified;


const MyDiff = ({ isPassed, expected, actual, testcaseNo }) => {
  const iconPath = isPassed ? correct : incorrect;
  const alt = isPassed ? "correct" : "incorrect";

  return (
    <Stack width={"100%"} boxShadow="0px 2px 4px rgba(0, 0, 0, 0.25)" borderRadius="8px">
      <Stack direction="row" justifyContent="baseline" spacing="5px" bgcolor={"var(--biscay)"} padding={1} borderRadius={"8px 8px 0px 0px"} >
        <img src={iconPath} alt={alt} />
        <Typography>Testcase {testcaseNo}</Typography>
      </Stack>

      <Box flex={1} padding={2} bgcolor={"#1e1e1e"} borderRadius={"0px 0px 8px 8px"} >
        <Stack direction={"row"} spacing={"5px"} marginBottom={1} >
          <Typography sx={{ flex: 1 }}>Actual output</Typography>
          <Typography sx={{ flex: 1 }}>Expected output</Typography>
        </Stack>
        <CodeMirrorMerge
          style={{
            fontSize: "14px",
            fontFamily: "monospace",
            overflow: "hidden",
          }}
          orientation="b-a"
          /* className='my-diff' */
          theme={githubDark}
        >
          {/* Left side the actual output from user sourcecode */}
          <Modified
            extensions={[
              EditorView.editable.of(false),
              EditorState.tabSize.of(4),
            ]}
            value={actual ? actual : ""}
          />

          {/* Right side the expected output from testcase */}
          <Original
            extensions={[
              EditorView.editable.of(false),
              EditorState.tabSize.of(4),
            ]}
            value={expected ? expected : ""}
          />
        </CodeMirrorMerge>
      </Box>
    </Stack>
  )
}

export default MyDiff