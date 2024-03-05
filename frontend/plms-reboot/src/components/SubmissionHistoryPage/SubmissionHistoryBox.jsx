import { Stack, Typography, ToggleButtonGroup, ToggleButton, Button, Box, FormControl, InputLabel, Select, MenuItem, Modal } from "@mui/material"
import CodeMirrorMerge from 'react-codemirror-merge';
import { githubDark } from "@uiw/codemirror-theme-github"
import { useEffect, useState } from "react";
import { EditorView } from 'codemirror';
import { EditorState } from '@codemirror/state';
import { python } from '@codemirror/lang-python';
import { modalStyle } from '@/utils';
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { useParams } from "react-router-dom";
import { cancleStudentSubmission } from "@/utils/api"
import SubmissionInfo from "@/components/StuExercise/SubmissionInfo";
import ErrorIcon from '@mui/icons-material/Error';

const Original = CodeMirrorMerge.Original;
const Modified = CodeMirrorMerge.Modified;

const SubmissionHistoryBox = ({ subHistory, isSubHistoryLoading }) => {
  const [view, setView] = useState('single');
  const [compareSelected, setCompareSelected] = useState({
    left: null,
    right: null,
  })
  const [singleSelected, setSingleSelected] = useState(0);
  const queryClient = useQueryClient();
  const { studentId, chapterId, itemId } = useParams();
  const [isModalOpen, setIsModalOpen] = useState(false);

  useEffect(() => {
    if (!isSubHistoryLoading && subHistory.length > 0) {
      if (subHistory.length < 2) {
        setCompareSelected({
          left: subHistory.length - 1,
          right: null
        })
      } else {
        setCompareSelected({
          left: subHistory.length - 1,
          right: subHistory.length - 2
        })
      }

      setSingleSelected(subHistory.length - 1)
    }
  }, [isSubHistoryLoading, subHistory])

  const rejectSubmissionMutation = useMutation({
    mutationFn: cancleStudentSubmission,
    onError: (err) => {
      alert(err.response.data.message)
    },
    onSuccess: () => {
      queryClient.invalidateQueries(['submission-list', studentId, chapterId, itemId]);
    }
  })

  const handleView = (event, newFormats) => {
    setView(newFormats);
  };

  const handleReject = () => {
    rejectSubmissionMutation.mutate({
      "submission_id": subHistory[singleSelected].submission_id
    })
  }


  return (
    <Stack spacing={"30px"} sx={{ position: "relative", padding: "20px", border: "1px solid var(--raven)", borderRadius: "8px" }}>
      <Stack direction={'row'} justifyContent={"space-between"} alignItems="center" >
        <Typography variant="h6" fontWeight="600" >Submission History</Typography>
        <Stack direction={'row'} >
          <ToggleButtonGroup
            exclusive
            aria-label="history alignment"
            value={view}
            onChange={handleView}
          >
            <ToggleButton value="single" size="small" sx={{ textTransform: "none", width: "150px" }} >
              Single view
            </ToggleButton>
            <ToggleButton value="compare" size="small" sx={{ textTransform: "none", width: "150px" }} >
              Comparison view
            </ToggleButton>
          </ToggleButtonGroup>
        </Stack>
      </Stack>

      {view === 'compare' &&
        <Box>
          {!isSubHistoryLoading && subHistory.length > 0 &&
            <Stack spacing="5px" direction="row">
              <Stack flex="1" sx={{ padding: "2px", borderRadius: "8px 8px 0px 0px", bgcolor: "var(--biscay)" }}>
                {subHistory && subHistory.length > 0 && (
                  <FormControl sx={{ m: 1, width: "200px" }} size="small">
                    <InputLabel id="submission-lebel-left" shrink={compareSelected.left !== null}>
                      # Submission
                    </InputLabel>
                    <Select
                      labelId="submission-lebel-left"
                      id="submission-left"
                      value={compareSelected.left !== null ? compareSelected.left : ""}
                      label="# Submission"
                      onChange={(event) => {
                        setCompareSelected((prevState) => ({
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
                )}
              </Stack>
              <Stack flex="1" sx={{ padding: "2px", borderRadius: "8px 8px 0px 0px", bgcolor: "var(--biscay)" }}>
                {subHistory && subHistory.length > 0 && (
                  <FormControl sx={{ m: 1, width: "200px" }} size="small">
                    <InputLabel id="submission-lebel-right" shrink={compareSelected.right !== null}>
                      # Submission
                    </InputLabel>
                    <Select
                      labelId="submission-lebel-right"
                      id="submission-left"
                      value={compareSelected.right !== null ? compareSelected.right : ""}
                      label="# Submission"
                      onChange={(event) => {
                        setCompareSelected((prevState) => ({
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
                )}
              </Stack>
            </Stack>
          }
          {!isSubHistoryLoading && subHistory.length === 0 &&
            <Stack Stack spacing="5px" direction="row" >
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
          {
            !isSubHistoryLoading && subHistory.length > 0 &&
            < CodeMirrorMerge
              style={{
                fontSize: "14px",
                fontFamily: "monospace",
                overflow: "hidden",
              }
              }
              className="submission-history-box"
              orientation="b-a"
              theme={githubDark}
            >
              {/* Left side the actual output from user sourcecode */}
              < Modified
                extensions={
                  [
                    EditorView.editable.of(false),
                    EditorState.tabSize.of(4),
                    python()
                  ]}
                value={compareSelected.left !== null ? subHistory[compareSelected.left].sourcecode_content : ""}
              />

              {/* Right side the expected output from testcase */}
              < Original
                extensions={
                  [
                    EditorView.editable.of(false),
                    EditorState.tabSize.of(4),
                    python()
                  ]}
                value={compareSelected.right !== null ? subHistory[compareSelected.right].sourcecode_content : ""}
              />
            </CodeMirrorMerge >
          }
        </Box >
      }

      {view === 'single' &&
        <Stack borderRadius="8px" >
          {subHistory && subHistory.length === 0 &&
            <Stack padding="20px" direction="row" justifyContent="center" alignItems="center" sx={{ width: "100%", height: "200px", bgcolor: "var(--mirage)", borderRadius: '8px' }}>
              <Typography>No submission yet....</Typography>
            </Stack>
          }
          {subHistory && subHistory.length > 0 &&
            <Box>
              <Stack direction="row" justifyContent="space-between" alignItems="center" paddingRight="30px" >
                <FormControl sx={{ m: 1, width: "200px" }} size="small">
                  <InputLabel id="submission-lebel" shrink={singleSelected !== null}>
                    # Submission
                  </InputLabel>
                  <Select
                    labelId="submission-lebel"
                    id="submission"
                    value={singleSelected !== null ? singleSelected : ""}
                    label="# Submission"
                    onChange={(event) => {
                      setSingleSelected(event.target.value);
                    }}
                  >
                    <MenuItem value={null}>None</MenuItem>
                    {subHistory.map((sub, index) => (
                      <MenuItem key={index} value={index}>
                        Submission {index + 1}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
                {singleSelected !== null && subHistory[singleSelected].status === "accepted" &&
                  <>
                    <Button variant="contained" color="error" onClick={() => setIsModalOpen(true)} sx={{ width: "100px" }} >
                      Reject
                    </Button>
                    <Modal
                      open={isModalOpen}
                      onClose={() => setIsModalOpen(false)}
                    >
                      <Stack spacing="20px" sx={{ ...modalStyle, paddingY: "25px", minWidth: "500px" }} >
                        <Stack direction="row" spacing="10px" alignItems="center" >
                          <ErrorIcon sx={(theme) => ({ fontSize: '32px', color: theme.palette.error.main })} />
                          <Typography variant='h5' color="error" sx={{ fontWeight: "bolder" }} >Reject Submission</Typography>
                        </Stack>
                        <Typography paddingX="20px" >Are you sure you want to reject this submission?</Typography>
                        <Stack spacing="10px" direction="row" justifyContent="flex-end" >
                          <Button variant='contained' color="error" sx={{ width: '80px' }} onClick={handleReject} >Yes</Button>
                          <Button variant="outlined" onClick={() => setIsModalOpen(false)} sx={{ width: '80px' }} >No</Button>
                        </Stack>
                      </Stack>
                    </Modal>
                  </>
                }
              </Stack>
            </Box>
          }
          {singleSelected !== null && subHistory && singleSelected < subHistory.length &&
            <SubmissionInfo insPage={true} submissionList={subHistory} selectedSubmission={{ value: singleSelected, setValue: setSingleSelected }} />
          }
        </Stack>
      }
    </Stack >
  )
}

export default SubmissionHistoryBox