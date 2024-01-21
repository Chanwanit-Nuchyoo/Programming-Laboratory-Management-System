import { Stack, Box, Button } from "@mui/material"

const buttons = [
  { label: "Chapter", boxProps: { flex: 1.5, width: 120 } },
  { label: "Allow Submit", boxProps: { width: 262.81 } },
  { label: "Item Score", boxProps: { width: 395 } },
  { label: "Score", boxProps: { width: 95 } },
]

const buttonProps = {
  fullWidth: true,
  //sx: { height: "100%" }
  sx:{pointerEvents: "none", color: 'white' }
}
const ChapterListTableHead = () => {

  return (
    <Stack direction={"row"} spacing={"5px"} >
      {buttons.map((button, index) => (
        <Box key={index} {...button.boxProps} className="table-head-column">
          <Button {...buttonProps} >{button.label}</Button>
        </Box>
      ))}
    </Stack>
  )
}

export default ChapterListTableHead