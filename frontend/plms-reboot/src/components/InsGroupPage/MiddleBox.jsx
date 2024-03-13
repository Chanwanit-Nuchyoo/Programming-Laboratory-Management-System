/* eslint-disable react/prop-types */
import ClassInfoBox from "@/components/InsGroupPage/ClassInfoBox"
import { Typography, Stack, Skeleton, Box, Button } from "@mui/material"
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { logoutAllStudentInGroup } from "@/utils/api";
import { useParams } from "react-router-dom"
import { useNavigate } from "react-router-dom";
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import LogoutIcon from '@/assets/images/logouticon.svg';
import usericon from '@/assets/images/usericon.svg';

const MiddleBox = ({ isClassLoading, groupData, onlineStudentsList }) => {
  const { groupId } = useParams();
  const queryClient = useQueryClient();
  const navigate = useNavigate();

  const { mutate: logoutAllStudent } = useMutation({
    mutationFn: logoutAllStudentInGroup,
    onSuccess: () => {
      queryClient.invalidateQueries(['groupData', groupId])
    },
    onError: (error) => {
      console.log(error)
    }
  })

  const handleLogoutAllStudent = () => {
    logoutAllStudent(groupId)
  }

  const handleGoToStudentListPage = () => {
    navigate(ABS_INS_URL.DYNAMIC.STUDENT_LIST(groupId));
  }

  const handleGoToLogPage = () => {
    navigate(ABS_INS_URL.DYNAMIC.LOGPAGE(groupId));
  }

  return (
    <ClassInfoBox>
      <Stack direction={"row"} spacing={"20px"} >
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >Department:</Typography>
          <Typography >{isClassLoading ? <Skeleton variant="text" width={90} sx={{ fontSize: "16px" }} /> : groupData?.dept_name}</Typography>
        </Stack>
      </Stack>
      <Stack direction={"row"} spacing={"20px"} >
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >All Student:</Typography>
          <Typography >{isClassLoading ? <Skeleton variant="text" width={40} sx={{ fontSize: "16px" }} /> : groupData?.student_no}</Typography>
        </Stack>
      </Stack>
      <Stack direction={"row"} spacing={"20px"} >
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >Student online:</Typography>
          <Typography >{onlineStudentsList.length}</Typography>
        </Stack>
      </Stack>
      <Stack direction="row" spacing="10px" >
        <Button variant="contained" color="primary" startIcon={<img src={usericon} alt="Logout" />} sx={{ textTransform: "none", fontSize: "16px", height: "40px" }} onClick={handleGoToStudentListPage} >
          Students
        </Button>
        <Button variant="contained" color="primary" startIcon={<img src={LogoutIcon} alt="Logout" />} sx={{ textTransform: "none", fontSize: "16px", height: "40px" }} onClick={handleLogoutAllStudent} >
          Log out all
        </Button>
      </Stack>
      <Button variant="contained" color="primary" sx={{ textTransform: "none", fontSize: "16px", height: "40px" }}  onClick={handleGoToLogPage} >
          Log Page
        </Button>
    </ClassInfoBox>
  )
}

export default MiddleBox