import { Box, Stack, Typography, Button, IconButton } from "@mui/material";
import { useState } from "react";
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import TerminalBlock from '@/components/_shared/TerminalBlock'

const containerStyle = {
  overflow: "hidden",
  transition: "max-height 0.25s ease-in-out",
};

const ExerciseInfoBox = () => {
  const [isExpanded, setIsExpanded] = useState(false);

  return (
    <Stack spacing={"20px"} sx={{ position: "relative", padding: "20px", border: "1px solid var(--raven)", borderRadius: "8px" }}>
      <Stack direction={'row'} justifyContent={"space-between"} alignItems="center" >
        <Typography>Level 4 - Expert</Typography>
        <Stack direction={"row"} spacing={"20px"}>
          <Button variant="contained" color="success">2/2</Button>
          <Button variant="contained" color="error">Deny this submission</Button>
        </Stack>
      </Stack>

      <Stack>
        <Typography>Lab Name</Typography>
        <Stack direction={"row"} width={"100%"} height={40} bgcolor={"var(--biscay)"} borderRadius={"8px"} padding={"10px 15px"}>
          <Typography>distance</Typography>
        </Stack>
      </Stack>

      <Stack>
        <Typography>Content</Typography>
        <Stack direction={"row"} width={"100%"} minHeight={350} bgcolor={"var(--biscay)"} borderRadius={"8px"} padding={"10px 15px"}>
          <Typography>distance</Typography>
        </Stack>
      </Stack>
      <Stack spacing={"20px"} height={isExpanded ? "fit-content" : "0px"} sx={containerStyle}>
        {[...Array(5)].map((_, index) => (
          <Stack key={index} sx={{ borderRadius: "8px", overflow: "hidden" }} >
            <Stack direction={"row"} width={"100%"} height={"50px"} alignItems={"center"} bgcolor={"var(--biscay)"} padding={"10px"} >
              <Typography>Testcase {index + 1}:</Typography>
            </Stack>
            <TerminalBlock />
          </Stack>
        ))}
      </Stack>
      <Box sx={{ position: "absolute", bottom: "-20px", left: "50%", transform: "translateX(-50%)" }}>
        <IconButton onClick={() => { setIsExpanded(prev => !prev) }} size="medium" sx={{ bgcolor: "var(--chathamBlue)", ":hover": { bgcolor: "var(--hover)" }, transform: isExpanded ? "rotate(180deg)" : "", transition: "all ease-in-out 0.25s" }}>
          <ExpandMoreIcon />
        </IconButton>
      </Box>
    </Stack>
  )
}

export default ExerciseInfoBox