import { Box, Stack, Typography, Button, IconButton, Skeleton } from "@mui/material";
import { useEffect, useRef, useState } from "react";
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import TerminalBlock from '@/components/_shared/TerminalBlock'
import { useParams } from 'react-router-dom';
import { RichTextReadOnly } from "mui-tiptap";
import { extensions } from "@/utils/tiptap-extensions";

const containerStyle = {
  overflow: "hidden",
  transition: "max-height 0.25s ease-in-out",
};

const ExerciseInfoBox = ({ exercise, isExerciseLoading }) => {
  const [isExpanded, setIsExpanded] = useState(false);
  const { itemId } = useParams();
  const rteRef = useRef(null);

  useEffect(() => {
    const editor = rteRef.current?.editor;

    if (!isExerciseLoading && exercise && editor) {
      editor
        .chain()
        .setContent(formData.lab_content)
        .run();
    }
  }, [rteRef, exercise, isExerciseLoading])

  return (
    <Stack spacing={"20px"} sx={{ position: "relative", padding: "20px", border: "1px solid var(--raven)", borderRadius: "8px" }}>
      <Stack direction={'row'} justifyContent={"space-between"} alignItems="center" >
        <Typography variant="h6" fontWeight="600" >Item {itemId}</Typography>
      </Stack>

      {/* Loading */}
      {isExerciseLoading &&
        <Stack spacing={"20px"} sx={{ position: "relative" }} >
          <Skeleton variant="rectangular" width={"100%"} height={45} />
          <Skeleton variant="rectangular" width={"100%"} height={350} />
        </Stack>
      }

      {/* No exercise assigned to this student*/}
      {!isExerciseLoading && !exercise &&
        <Stack spacing={"20px"} sx={{ position: "relative" }} >
          <Stack direction="row" justifyContent="center" alignItems="center" sx={{ width: "100%", height: "350px", bgcolor: "var(--mirage)", borderRadius: '8px' }} >
            <Typography>No exercise assigned to this student</Typography>
          </Stack>
        </Stack>
      }

      {/* There already exercise assigned to this student */}
      {!isExerciseLoading && exercise &&
        <Stack spacing={"20px"} sx={{ position: "relative" }} >
          <Stack spacing="10px">
            <Typography>Lab name</Typography>
            <Stack direction={"row"} width={"100%"} height={45} bgcolor={"var(--biscay)"} borderRadius={"8px"} padding={"10px 15px"}>
              <Typography>{exercise.lab_name}</Typography>
            </Stack>
          </Stack>
          <Stack spacing="10px" >
            <Typography>Content</Typography>
            <Stack direction={"row"} width={"100%"} minHeight={350} bgcolor={"var(--biscay)"} borderRadius={"8px"} padding={"10px 15px"}>
              <RichTextReadOnly content={exercise.lab_content} extensions={extensions} />
            </Stack>
          </Stack>
          <Stack spacing={"20px"} height={isExpanded ? "fit-content" : "0px"} sx={containerStyle}>
            {typeof exercise.testcase !== 'string' && exercise.testcase.map((tc, index) => (
              <Stack key={index} sx={{ borderRadius: "8px", overflow: "hidden" }} >
                <Stack direction={"row"} width={"100%"} height={"50px"} alignItems={"center"} bgcolor={"var(--biscay)"} padding={"10px"} >
                  <Typography>Testcase {index + 1}:</Typography>
                </Stack>
                <TerminalBlock text={tc.testcase_output} />
              </Stack>
            ))}
          </Stack>
          {typeof exercise.testcase !== 'string' && <Box sx={{ position: "absolute", bottom: "-20px", left: "50%", transform: "translateX(-50%)" }}>
            <IconButton onClick={() => { setIsExpanded(prev => !prev) }} size="medium" sx={{ bgcolor: "var(--chathamBlue)", ":hover": { bgcolor: "var(--hover)" }, transform: isExpanded ? "rotate(180deg)" : "", transition: "all ease-in-out 0.25s" }}>
              <ExpandMoreIcon />
            </IconButton>
          </Box>}
        </Stack>
      }
    </Stack>
  )
}

export default ExerciseInfoBox