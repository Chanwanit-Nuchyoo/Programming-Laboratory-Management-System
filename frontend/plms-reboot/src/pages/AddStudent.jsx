import { Box, Button, Stack, TextField } from "@mui/material"
import folderIcon from '@/assets/images/foldericon.svg';

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from "@/components/_shared/Header"

const placeholder = `Copy from Excel and paste here

1 6xxxxxxx Name Surname
2 6xxxxxxx Name Surname
3 6xxxxxxx Name Surname
...
          `

const AddStudent = () => {
  return (
    <Box >
      <Stack spacing={"20px"}>
        <MyBreadCrumbs items={[
          { label: 'My Groups', href: '#' },
          { label: 'Group 401', href: '#' },
        ]} />

        <Header logoSrc={folderIcon} title="Group 401" />

        <Box >
          <TextField color="primary" variant="outlined" fullWidth multiline rows={20} placeholder={placeholder} />
        </Box>

        <Stack direction="row" justifyContent={"flex-end"} >
          <Button variant="contained" color="primary" 
          sx={{
            height:'40px', 
            width: '120px', 
            fontSize: '16px',
            textTransform: 'none'
          }}>Submit</Button>
        </Stack>

      </Stack>
    </Box>
  )
}

export default AddStudent