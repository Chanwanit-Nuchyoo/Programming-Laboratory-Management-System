/* eslint-disable react/prop-types */
import { Box } from "@mui/material";

const TerminalBlock = ({ text, error, hug, ...props }) => {

  const terminalStyle = {
    whiteSpace: 'pre', // Preserve whitespace and line breaks
    fontFamily: 'monospace', // Use a monospaced font
    padding: '10px', // Add some padding for better visibility
    bgcolor: '#0d1117', // Background color for the terminal block
    color: error ? 'red' : '#FFF', // Text color
    tabSize: '4',
    minHeight: hug ? "" : '150px',
    overflowX: "auto",
    minWidth: "0px",
    fontSize: "14px",
    borderRadius: '0px 0px 8px 0px'
  };

  return (
    <Box sx={terminalStyle} {...props} >
      {text}
    </Box>
  );
};

export default TerminalBlock