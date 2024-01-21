import React, { useState } from 'react';
import { Stack, Box, Typography, Button} from '@mui/material'
import avatarPlaceholder from '@/assets/images/avatarplaceholder.svg'
import PropTypes from 'prop-types'

const StudentBriefInfo = ({ imgSrc, studentId, studentName, studentNickName, groupId, groupNo }) => {
  const [filterRule, setFilterRule] = useState('all');

  return (
    <Stack spacing={"5px"} direction={"row"} >

      {/* Avatar */}
      <Box width={80} height={80} borderRadius={"8px"} overflow={"hidden"} >
        <img className="image-contain" src={imgSrc ? imgSrc : avatarPlaceholder} alt="user avatar image" />
      </Box>

      {/* Info */}
      <Stack className="outlined" bgcolor={"var(--mirage)"} padding={"10px 20px"} borderRadius={"8px"}
        display="flex" flexDirection="row" width="510px" height="80px" alignItems="center" gap="20px" flexShrink={0} flex='1'
      >
        <Stack sx={{ display: 'flex', width: '245px', flexDirection: 'column', alignItems: 'flex-start', gap: '10px', flexShrink: '0' }}>
          <Stack direction={"row"} spacing={"5px"} flex="1">
            <Typography variant="subitem2" color="primary" >Student ID</Typography>
            <Typography>{studentId}</Typography>
          </Stack>
          <Stack direction={"row"} spacing={"5px"} flex="1">
            <Typography variant="subitem2" color="primary" >Name</Typography>
            <Typography>{studentName} ({studentNickName})</Typography>
          </Stack>
        </Stack>

        <Stack sx={{ display: 'flex', width: '200px', flexDirection: 'column', alignItems: 'flex-start', gap: '10px', flexShrink: '0' }}>
          <Stack direction={"row"} spacing={"5px"} flex="1">
            <Typography variant="subitem2" color="primary" >Group ID</Typography>
            <Typography>{groupId}</Typography>
          </Stack>
          <Stack direction={"row"} spacing={"5px"} flex="1">
            <Typography variant="subitem2" color="primary" >Group</Typography>
            <Typography>{groupNo}</Typography>
          </Stack>
        </Stack>
      </Stack>

      {/* Role */}
      <Stack className="outlined" bgcolor={"var(--mirage)"} padding={"10px 20px"} borderRadius={"8px"}
        display="flex" flexDirection="row" width="266px" height="80px" justifyContent="center" alignItems="center" gap="20px" flexShrink={0}
      >
        <Typography variant="subitem2" color="primary" >Role</Typography>
        <Button
          variant="outlined"
          size="small"
          sx={{ textTransform: "none", fontSize: "16px", height: "40px", width: "120px",  border: "solid 2px", borderRadius: "24px",pointerEvents: "none" }}
        >Student</Button>
      </Stack>

      {/* Reset */}
      <Stack className="outlined" bgcolor={"var(--mirage)"} padding={"10px 20px"} borderRadius={"8px"}
        display="flex" flexDirection="column" width="266px" height="80px" justifyContent="center" alignItems="center" gap="20px" flexShrink={0}
      >
        <Button
          variant="contained"
          size="small"
          sx={{ textTransform: "none", fontSize: "16px", height: "40px", width: "200px" }}
        >Reset Password</Button>
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
