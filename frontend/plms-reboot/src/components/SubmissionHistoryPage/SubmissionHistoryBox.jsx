import { Stack, Typography, ToggleButtonGroup, ToggleButton, Tooltip } from "@mui/material"
import HorizontalSplitIcon from '@mui/icons-material/HorizontalSplit';
import VerticalSplitIcon from '@mui/icons-material/VerticalSplit';
import { useState } from "react";

const SubmissionHistoryBox = () => {
  const [alignment, setAlignment] = useState(() => ["vertical", "horizontal"])

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
    </Stack>
  )
}

export default SubmissionHistoryBox