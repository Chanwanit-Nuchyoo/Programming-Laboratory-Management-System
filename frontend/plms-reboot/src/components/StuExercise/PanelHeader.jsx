/* eslint-disable react/prop-types */
import { Box } from "@mui/material"

const PanelHeader = ({ children, ...props }) => {
  return (
    <Box {...props} padding={"10px"} color="hov" sx={{ height: "54px", bgcolor: "var(--mirage)", borderRadius: "8px 8px 0px 0px" }}>
      {children}
    </Box>
  )
}

export default PanelHeader