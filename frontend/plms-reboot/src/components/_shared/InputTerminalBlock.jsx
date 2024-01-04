/* eslint-disable react/prop-types */
import { TextareaAutosize } from "@mui/material";

const InputTerminalBlock = ({ value, onChange, ...props }) => {
  const inputStyle = {
    whiteSpace: 'pre', // Preserve whitespace and line breaks
    fontFamily: 'monospace', // Use a monospaced font
    padding: '10px', // Add some padding for better visibility
    backgroundColor: '#0d1117', // Background color for the input block
    color: '#FFF', // Text color
    border: 'none', // Remove default border
    outline: 'none', // Remove outline on focus
    resize: 'none', // Disable textarea resizing
    minHeight: '130px', // Set minimum height
    fontSize: '13px', // Set font size
    width: '100%', // Take up full width
    boxSizing: 'border-box', // Ensure the box size includes border and padding
    lineHeight: '1.5', // Increase line spacing a little
    height: '100%',
  };

  return (
    <TextareaAutosize
      value={value}
      onChange={onChange}
      style={inputStyle}
      {...props}
    />
  );
};

export default InputTerminalBlock;