/* eslint-disable react/prop-types */
import { Stack, Typography } from "@mui/material"

const Header = ({ logoSrc, logoIcon, title }) => {
  return (
    <Stack spacing={1} direction={"row"} alignItems="center" >
      {(logoSrc && !logoIcon) && <div className="page-icon"><img src={logoSrc} alt="page name icon" /></div>}
      {(!logoSrc && logoIcon) && <div className="page-icon">{logoIcon}</div>}
      <Typography variant='h6' component={"h1"}>{title}</Typography>
    </Stack>
  )
}

export default Header