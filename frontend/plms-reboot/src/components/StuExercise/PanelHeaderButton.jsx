
/* eslint-disable react/prop-types */
import { Typography } from "@mui/material"
import StyledButton from "@/components/_shared/StyledButton"

const PanelHeaderButton = ({ title, num, ...props }) => {
  return (
    <StyledButton variant="outlined" {...props}>
      <Typography>{title}</Typography>
      {num && <Typography marginLeft={"8px"} >({String(num)})</Typography>}
    </StyledButton>
  )
}

export default PanelHeaderButton