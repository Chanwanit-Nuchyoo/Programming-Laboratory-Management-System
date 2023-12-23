import { Stack, Box, Button } from "@mui/material"

const buttons = [
  { label: "Chapter", boxProps: { flex: 1.5, width: 120 } },
  { label: "Allow Submit", boxProps: { flex: 1, width: 150 } },
  { label: "Item Score", boxProps: { width: 395 } },
  { label: "Score", boxProps: { width: 90 } },
]

const buttonProps = {
  fullWidth: true,
  sx: { height: "100%" }
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