import { EditorView } from 'codemirror';
import { EditorState } from '@codemirror/state';
import CodeMirrorMerge from 'react-codemirror-merge';
import { githubDark } from "@uiw/codemirror-theme-github"
import { Box, Stack, Typography } from '@mui/material';

const Original = CodeMirrorMerge.Original;
const Modified = CodeMirrorMerge.Modified;


const MyDiff = ({ expected, actual, testcaseNo }) => {
  return (
    <Stack width={"100%"} boxShadow="0px 2px 4px rgba(0, 0, 0, 0.25)" border="3px solid white" borderRadius="8px" >
      <Box bgcolor={"var(--biscay)"} padding={1} borderRadius={"8px 8px 0px 0px"} >
        <Typography variant={"h6"}>Testcase {testcaseNo}</Typography>
      </Box>

      <Box flex={1} padding={2} bgcolor={"black"} borderRadius={"0px 0px 8px 8px"} >
        <Stack direction={"row"} spacing={"5px"} marginBottom={1} >
          <Typography sx={{ flex: 1 }}>Actual output</Typography>
          <Typography sx={{ flex: 1 }}>Expected output</Typography>
        </Stack>
        <CodeMirrorMerge
          style={{
            fontSize: "14px",
            fontFamily: "monospace",
            borderRadius: "8px 8px 8px 8px",
            overflow: "hidden",
          }}
          orientation="b-a"
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