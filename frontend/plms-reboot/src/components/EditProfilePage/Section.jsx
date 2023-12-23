/* eslint-disable react/prop-types */
import { Stack, Typography } from "@mui/material";

const boxStyle = {
  padding: "20px",
  border: "1px solid var(--raven)",
  borderRadius: "8px",
  flex: "1"
};

const Section = ({ title, children, ...props }) => (
  <Stack {...props} spacing={"30px"} sx={boxStyle}>
    {title && <Typography variant="h6">{title}</Typography>}
    {children}
  </Stack>
);
export default Section;