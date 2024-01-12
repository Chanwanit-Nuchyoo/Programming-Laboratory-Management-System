/* eslint-disable react/prop-types */
import ClassInfoBox from "@/components/InsGroupPage/ClassInfoBox"
import { Typography, Stack, Skeleton, Box, Button } from "@mui/material"
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { logoutAllStudentInGroup } from "@/utils/api";
import { useParams } from "react-router-dom"
import LogoutIcon from '@/assets/images/logouticon.svg';

const MiddleBox = ({ isClassLoading, groupData }) => {
  const { groupId } = useParams();
  const queryClient = useQueryClient();

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
          <Typography ></Typography>
        </Stack>
      </Stack>
      <Box>
        <Button variant="contained" color="primary" startIcon={<img src={LogoutIcon} alt="Logout" />} sx={{ textTransform: "none", padding: "6px 26px", fontSize: "16px" }} onClick={handleLogoutAllStudent} >
          Log out all student
        </Button>
      </Box>
    </ClassInfoBox>
  )
}

export default MiddleBox