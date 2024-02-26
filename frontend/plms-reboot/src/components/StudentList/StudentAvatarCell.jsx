import { Stack, Box } from '@mui/system'
import avatarPlaceHolder from "@/assets/images/avatarplaceholder.svg";
import { useNavigate } from 'react-router-dom';
import { ABS_INS_URL } from "@/utils/constants/routeConst";

const onlineStatusDot = {
  width: "30px", height: "30px", bottom: "5px", borderRadius: "50%", right: "5px", zIndex: "10", position: "absolute"
}

const StudentAvatarCell = ({ groupId, stuId, avatar, onlineStudentsList }) => {
  const navigate = useNavigate();

  const handleAvatarClick = () => {
    navigate(ABS_INS_URL.DYNAMIC.STUDENT_SCORE(groupId, stuId));
  }

  return (
    <Stack justifyContent='center' alignItems="center" sx={{ width: '100px', height: "100px", overflow: 'hidden', position: "relative" }}>
      <img
        src={avatar
          ? avatar
          : avatarPlaceHolder
        }
        onClick={handleAvatarClick}
        alt="user avatar"
        style={{ borderRadius: '8px', objectFit: "cover", maxWidth: '100%', maxHeight: '100%', cursor: "pointer" }}
      />
      <Box sx={{ ...onlineStatusDot, bgcolor: onlineStudentsList.includes(stuId) ? "#4CAF50" : "#F44336" }} />
    </Stack>
  )
}

export default StudentAvatarCell;