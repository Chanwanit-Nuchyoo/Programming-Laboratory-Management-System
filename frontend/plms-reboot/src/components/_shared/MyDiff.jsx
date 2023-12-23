import { EditorView } from 'codemirror';
import { EditorState } from '@codemirror/state';
import CodeMirrorMerge from 'react-codemirror-merge';
import { githubDark } from "@uiw/codemirror-theme-github"
import { Box, Stack } from '@mui/material';

const Original = CodeMirrorMerge.Original;
const Modified = CodeMirrorMerge.Modified;


const MyDiff = ({ expected, actual }) => {
  return (
    <Stack width={"100%"}>
      <Stack direction={"row"} spacing={"5px"} >
        <Box flex={1} padding="8px" borderRadius={"8px 8px 0px 0px"} bgcolor="var(--biscay)" >Testcase 1</Box>
        <Box flex={1} padding="8px" borderRadius={"8px 8px 0px 0px"} bgcolor="var(--biscay)" >Testcase 1</Box>
      </Stack>
      <Box flex={1} >
        <CodeMirrorMerge
          style={{
            fontSize: "14px",
            fontFamily: "monospace",
            borderRadius: "0px 0px 8px 8px",
            overflow: "hidden",
          }}
          orientation="b-a"
          theme={githubDark}
        >
          <Original
            extensions={[
              EditorView.editable.of(false),
              EditorState.tabSize.of(4),
            ]}
            value={expected ? expected : ""} />

          <Modified
            extensions={[
              EditorView.editable.of(false),
              EditorState.tabSize.of(4),
            ]}
            value={actual ? actual : ""} />
        </CodeMirrorMerge>
      </Box>
    </Stack>
  )
}

export default MyDiff