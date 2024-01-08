/* eslint-disable react/prop-types */
import { Box } from "@mui/material";

const TerminalBlock = ({ text, error, ...props }) => {

  const terminalStyle = {
    whiteSpace: 'pre', // Preserve whitespace and line breaks
    fontFamily: 'monospace', // Use a monospaced font
    padding: '10px', // Add some padding for better visibility
    bgcolor: '#0d1117', // Background color for the terminal block
    color: error ? 'red' : '#FFF', // Text color
    tabSize: '4',
    height: "100%",
    overflowX: "auto",
    fontSize: "13px",
  };

  return (
    <Box sx={terminalStyle} {...props} >
      {text}
    </Box>
  );
};

export default TerminalBlock