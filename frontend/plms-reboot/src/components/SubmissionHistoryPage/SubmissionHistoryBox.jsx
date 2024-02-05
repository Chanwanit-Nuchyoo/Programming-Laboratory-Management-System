import { Stack, Typography, ToggleButtonGroup, ToggleButton, Tooltip, Box, FormControl, InputLabel, Select, MenuItem, Menu } from "@mui/material"
import HorizontalSplitIcon from '@mui/icons-material/HorizontalSplit';
import VerticalSplitIcon from '@mui/icons-material/VerticalSplit';
import CodeMirrorMerge from 'react-codemirror-merge';
import { githubDark } from "@uiw/codemirror-theme-github"
import { useEffect, useState } from "react";
import { EditorView } from 'codemirror';
import { EditorState } from '@codemirror/state';
import { python } from '@codemirror/lang-python';


const Original = CodeMirrorMerge.Original;
const Modified = CodeMirrorMerge.Modified;

const SubmissionHistoryBox = ({ subHistory, isSubHistoryLoading }) => {
  const [alignment, setAlignment] = useState(() => ["vertical", "horizontal"]);
  const [selectedSubmission, setSelectedSubmission] = useState({
    left: null,
    right: null,
  })

  useEffect(() => {
    if (!isSubHistoryLoading && subHistory.length > 0) {
      if (subHistory.length < 2) {
        setSelectedSubmission({
          left: subHistory.length - 1,
          right: null
        })
      } else {
        setSelectedSubmission({
          left: subHistory.length - 1,
          right: subHistory.length - 2
        })
      }
    }
  }, [isSubHistoryLoading, subHistory])

  const handleAlignment = (event, newFormats) => {
    setAlignment(newFormats);
  };

  return (
    <Stack spacing={"20px"} sx={{ position: "relative", padding: "20px", border: "1px solid var(--raven)", borderRadius: "8px" }}>
      <Stack direction={'row'} justifyContent={"space-between"} alignItems="center" >
        <Typography>Submission History</Typography>
        <Stack direction={'row'} >
          <ToggleButtonGroup
            exclusive
            aria-label="history alignment"
            value={alignment}
            onChange={handleAlignment}
          >
            <Tooltip title="Vertical" >
              <ToggleButton value="vertical" aria-label="vertical-alignment" >
                <VerticalSplitIcon />
              </ToggleButton>
            </Tooltip>
            <Tooltip title="Horizontal">
              <ToggleButton value="horizontal" aria-label="horizontal-alignment" >
                <HorizontalSplitIcon />
              </ToggleButton>
            </Tooltip>
          </ToggleButtonGroup>
        </Stack>
      </Stack>

      <Box>
        <Stack spacing="5px" direction="row">
          <Stack flex="1" sx={{ padding: "2px", borderRadius: "8px 8px 0px 0px", bgcolor: "var(--biscay)" }}>
            <FormControl sx={{ m: 1, width: "200px" }} size="small">
              <InputLabel id="submission-lebel-left" shrink={selectedSubmission.left !== null}>
                # Submission
              </InputLabel>
              <Select
                labelId="submission-lebel-left"
                id="submission-left"
                value={selectedSubmission.left}
                label="# Submission"
                onChange={(event) => {
                  setSelectedSubmission((prevState) => ({
                    ...prevState,
                    left: event.target.value
                  }));
                }}
              >
                <MenuItem value={null}>None</MenuItem>
                {subHistory?.map((sub, index) => (
                  <MenuItem key={index} value={index}>
                    Submission {index + 1}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
          </Stack>
          <Stack flex="1" sx={{ padding: "2px", borderRadius: "8px 8px 0px 0px", bgcolor: "var(--biscay)" }}>
            <FormControl sx={{ m: 1, width: "200px" }} size="small">
              <InputLabel id="submission-lebel-right" shrink={selectedSubmission.right !== null}>
                # Submission
              </InputLabel>
              <Select
                labelId="submission-lebel-right"
                id="submission-left"
                value={selectedSubmission.right}
                label="# Submission"
                onChange={(event) => {
                  setSelectedSubmission((prevState) => ({
                    ...prevState,
                    right: event.target.value
                  }));
                }}
              >
                <MenuItem value={null}>None</MenuItem>
                {subHistory?.map((sub, index) => (
                  <MenuItem key={index} value={index}>
                    Submission {index + 1}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
          </Stack>
        </Stack>
        {!isSubHistoryLoading && subHistory.length === 0 &&
          <Stack spacing="5px" direction="row" >
            <Stack flex="1" spacing={"20px"} sx={{ position: "relative" }} >
              <Stack direction="row" justifyContent="center" alignItems="center" sx={{ width: "100%", height: "200px", bgcolor: "var(--mirage)", borderRadius: '8px' }} >
                <Typography>No student submission yet ...</Typography>
              </Stack>
            </Stack>
            <Stack flex="1" spacing={"20px"} sx={{ position: "relative" }} >
              <Stack direction="row" justifyContent="center" alignItems="center" sx={{ width: "100%", height: "200px", bgcolor: "var(--mirage)", borderRadius: '8px' }} >
                <Typography>No student submission yet ...</Typography>
              </Stack>
            </Stack>
          </Stack>
        }
        {!isSubHistoryLoading && subHistory.length > 0 &&
          <CodeMirrorMerge
            style={{
              fontSize: "14px",
              fontFamily: "monospace",
              overflow: "hidden",
            }}
            className="submission-history-box"
            orientation="b-a"
            theme={githubDark}
          >
            {/* Left side the actual output from user sourcecode */}
            <Modified
              extensions={[
                EditorView.editable.of(false),
                EditorState.tabSize.of(4),
                python()
              ]}
              value={selectedSubmission.left !== null ? subHistory[selectedSubmission.left].sourcecode_content : ""}
            />

            {/* Right side the expected output from testcase */}
            <Original
              extensions={[
                EditorView.editable.of(false),
                EditorState.tabSize.of(4),
                python()
              ]}
              value={selectedSubmission.right !== null ? subHistory[selectedSubmission.right].sourcecode_content : ""}
            />
          </CodeMirrorMerge>
        }
      </Box>
    </Stack>
  )
}

export default SubmissionHistoryBox