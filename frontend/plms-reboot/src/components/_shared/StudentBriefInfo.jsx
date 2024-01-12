import { Stack, Box, Typography } from '@mui/material'
import avatarPlaceholder from '@/assets/images/avatarplaceholder.png'
import PropTypes from 'prop-types'

const StudentBriefInfo = ({ imgSrc, studentId, studentName, studentNickName, groupId, groupNo }) => {
  return (
    <Stack spacing={"10px"} direction={"row"} >
      <Box width={80} height={80} borderRadius={"8px"} overflow={"hidden"} >
        <img className="image-contain" src={imgSrc ? imgSrc : avatarPlaceholder} alt="user avatar image" />
      </Box>
 
      <Stack className="outlined" spacing={"10px"} bgcolor={"var(--mirage)"} padding={"10px 20px"} borderRadius={"8px"} >
        <Stack direction={"row"} spacing={"5px"}>
          <Typography variant="subitem2" color="primary" >Student ID</Typography>
          <Typography>{studentId}</Typography>
        </Stack>
        <Stack direction={"row"} spacing={"5px"}>
          <Typography variant="subitem2" color="primary" >Name</Typography>
          <Typography>{studentName} ({studentNickName})</Typography>
        </Stack>
      </Stack>

      <Stack className="outlined" spacing={"10px"} bgcolor={"var(--mirage)"} padding={"10px 20px"} borderRadius={"8px"} >
        <Stack direction={"row"} spacing={"5px"}>
          <Typography variant="subitem2" color="primary" >Group ID</Typography>
          <Typography>{groupId}</Typography>
        </Stack>
        <Stack direction={"row"} spacing={"5px"}>
          <Typography variant="subitem2" color="primary" >Group</Typography>
          <Typography>{groupNo}</Typography>
        </Stack>
      </Stack>
    </Stack>
  )
}

StudentBriefInfo.propTypes = {
  imgSrc: PropTypes.string,
  studentId: PropTypes.string.isRequired,
  studentName: PropTypes.string.isRequired,
  studentNickName: PropTypes.string.isRequired,
  groupId: PropTypes.string.isRequired,
  groupNo: PropTypes.number.isRequired,
}

export default StudentBriefInfo