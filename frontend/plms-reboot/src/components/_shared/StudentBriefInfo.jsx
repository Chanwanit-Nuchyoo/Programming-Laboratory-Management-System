import { useState } from 'react';
import { Stack, Box, Typography, Button, Skeleton, Modal } from '@mui/material'
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query'
import { modalStyle } from '@/utils';
import { useNavigate } from 'react-router';
import { studentInfoCard, resetStudentPassword, deleteStudent } from '@/utils/api'
import { ABS_INS_URL } from '@/utils/constants/routeConst';
import { useParams } from 'react-router-dom';

import avatarPlaceholder from '@/assets/images/avatarplaceholder.svg'
import ErrorIcon from '@mui/icons-material/Error';
import CircleIcon from '@mui/icons-material/Circle';
import useOnlineStudentsList from "@/hooks/useOnlineStudentsList";
import useSetStudentCanSubmitMutation from '@/hooks/useSetStudentCanSubmitMutation';

const StudentBriefInfo = ({ studentId }) => {
  const { groupId } = useParams();
  const queryClient = useQueryClient();
  const onlineStudentsList = useOnlineStudentsList(groupId);

  const setStuCanSubmitMutation = useSetStudentCanSubmitMutation(groupId);
  const handleToggleCanSubmit = (stuId, canSubmit) => {
    setStuCanSubmitMutation.mutate({
      stu_id: stuId,
      can_submit: canSubmit === "yes" ? "no" : "yes"
    })
  }

  const [filterRule, setFilterRule] = useState('all');
  const [isResetModalOpen, setIsResetModalOpen] = useState(false);
  const [isDelModalOpen, setIsDelModalOpen] = useState(false);

  const navigate = useNavigate();

  const { data: studentInfoCardData, isLoading: isStudentInfoCardLoading } = useQuery({
    queryKey: ['studentInfoCard', studentId],
    queryFn: () => studentInfoCard(studentId),
  });

  const { mutate: resetPassword } = useMutation({
    mutationFn: resetStudentPassword,
    onSuccess: () => {
      setIsResetModalOpen(false);
    },
  });

  const { mutate: deleteStu } = useMutation({
    mutationFn: deleteStudent,
    onSuccess: () => {
      setIsDelModalOpen(false);
      queryClient.invalidateQueries(['studentList', groupId]);
      navigate(ABS_INS_URL.DYNAMIC.STUDENT_LIST(groupId))
    },
  });

  const handleConfirmResetPassword = () => {
    resetPassword({
      stu_id: studentId
    });
  }

  const handleConfirmDeleteStudent = () => {
    deleteStu({
      stu_id: studentId
    });
  }

  const isOnline = onlineStudentsList?.includes(studentId);

  return (
    <Stack spacing={"5px"} direction={"row"} height="115px"  >
      {/* Avatar */}
      {!isStudentInfoCardLoading &&
        <Box width={115} height={115} borderRadius={"8px"} overflow={"hidden"} >
          <img className="image-contain" src={(!isStudentInfoCardLoading && studentInfoCardData.stu_avatar) ? `${studentInfoCardData["stu_avatar"]}` : avatarPlaceholder} alt="user avatar image" />
        </Box>
      }

      {
        isStudentInfoCardLoading &&
        <Skeleton variant="circular" width={115} height={115} />
      }

      {
        isStudentInfoCardLoading && <>
          <Skeleton variant="text" width={510} height={115} />
          <Skeleton variant="text" width={266} height={115} />
          <Skeleton variant="text" width={266} height={115} />
        </>
      }

      {!isStudentInfoCardLoading &&
        <>
          {/* Info */}
          <Stack className="outlined" bgcolor={"var(--mirage)"} padding={"10px 20px"} borderRadius={"8px"}
            display="flex" flexDirection="row" width="510px" height="115px" alignItems="center" gap="20px" flexShrink={0} flex='1'
          >
            <Stack sx={{ display: 'flex', width: '265px', flexDirection: 'column', alignItems: 'flex-start', gap: '10px', flexShrink: '0' }}>
              <Stack width="100%" direction={"row"} spacing={"5px"} >
                <Typography variant="subitem2" color="primary" sx={{ whiteSpace: "nowrap" }} >Student ID</Typography>
                {!isStudentInfoCardLoading ? (
                  <Typography sx={{ overflow: "hidden", whiteSpace: "nowrap", textOverflow: "ellipsis" }}>
                    {studentInfoCardData?.stu_id}
                  </Typography>
                ) : (
                  <Skeleton variant="text" width={100} />
                )}
              </Stack>
              <Stack width="100%" direction={"row"} spacing={"5px"}>
                <Typography variant="subitem2" color="primary" sx={{ whiteSpace: "nowrap" }} >Name</Typography>
                {!isStudentInfoCardLoading ? (
                  <Typography sx={{ overflow: "hidden", whiteSpace: "nowrap", textOverflow: "ellipsis" }}>
                    {`${studentInfoCardData?.stu_firstname} ${studentInfoCardData?.stu_lastname} ${studentInfoCardData?.stu_nickname ? `(${studentInfoCardData?.stu_nickname})` : ""}`}
                  </Typography>
                ) : (
                  <Skeleton variant="text" width={100} />
                )}
              </Stack>
            </Stack>

            <Stack sx={{ display: 'flex', width: '180px', flexDirection: 'column', alignItems: 'flex-start', gap: '10px', flexShrink: '0' }}>
              <Stack width="100%" direction={"row"} spacing={"5px"} flex="1">
                <Typography variant="subitem2" color="primary" sx={{ whiteSpace: "nowrap" }} >Group ID</Typography>
                {!isStudentInfoCardLoading ? (
                  <Typography sx={{ overflow: "hidden", whiteSpace: "nowrap", textOverflow: "ellipsis" }}>
                    {studentInfoCardData?.group_id}
                  </Typography>
                ) : (
                  <Skeleton variant="text" width={100} />
                )}
              </Stack>
              <Stack width="100%" direction={"row"} spacing={"5px"} flex="1">
                <Typography variant="subitem2" color="primary" sx={{ whiteSpace: "nowrap" }} >Group</Typography>
                {!isStudentInfoCardLoading ? (
                  <Typography sx={{ overflow: "hidden", whiteSpace: "nowrap", textOverflow: "ellipsis" }}>
                    {studentInfoCardData?.group_no}
                  </Typography>
                ) : (
                  <Skeleton variant="text" width={100} />
                )}
              </Stack>
            </Stack>
          </Stack>

          {/* Role */}
          <Stack className="outlined" bgcolor={"var(--mirage)"} padding={"10px 20px"} borderRadius={"8px"}
            width="266px" height="115px" spacing="10px" flexShrink={0} justifyContent="center" alignItems="center"
          >
            <Button
              variant='outlined'
              color={isOnline ? "success" : "error"}
              startIcon={<CircleIcon color={isOnline ? "success" : "error"} />}
              sx={{ fontSize: "16px", borderRadius: "30px", textTransform: "none", height: "40px", width: "160px", pointerEvents: "none" }}
            >
              {isOnline ? "Online" : "Offline"}
            </Button>
            <Button
              variant="outlined"
              size="small"
              startIcon={<CircleIcon color={studentInfoCardData.can_submit === "yes" ? "success" : "error"} />}
              color={studentInfoCardData.can_submit === "yes" ? "success" : "error"}
              onClick={() => handleToggleCanSubmit(studentId, studentInfoCardData.can_submit)}
              sx={{ fontSize: "16px", borderRadius: "30px", textTransform: "none", height: "40px", width: "160px" }}
            >{studentInfoCardData.can_submit === "yes" ? "Can Submit" : "Can't Submit"}</Button>
          </Stack>

          {/* Reset */}
          <Stack className="outlined" bgcolor={"var(--mirage)"} padding={"10px 20px"} borderRadius={"8px"}
            display="flex" flexDirection="column" width="266px" height="115px" justifyContent="center" alignItems="center" gap="20px" flexShrink={0}
          >
            <Stack spacing="10px" >
              <Button
                variant="contained"
                size="small"
                onClick={() => setIsResetModalOpen(true)}
                sx={{ fontSize: "16px", borderRadius: "30px", textTransform: "none", height: "40px", width: "160px" }}
              >Reset Password</Button>
              <Button
                variant="contained"
                size="small"
                color="error"
                onClick={() => { setIsDelModalOpen(true) }/* setIsResetModalOpen(true) */}
                sx={{ fontSize: "16px", borderRadius: "30px", textTransform: "none", height: "40px", width: "160px" }}
              >Delete Student</Button>
            </Stack>

            <Modal
              open={isResetModalOpen}
              onClose={() => setIsResetModalOpen(false)}
            >
              <Stack spacing="20px" sx={{ ...modalStyle, paddingY: "25px", minWidth: "500px" }} >
                <Stack direction="row" spacing="10px" alignItems="center" >
                  <ErrorIcon sx={(theme) => ({ fontSize: '32px', color: theme.palette.error.main })} />
                  <Typography variant='h5' color="error" sx={{ fontWeight: "bolder" }} >Reset Password</Typography>
                </Stack>
                <Stack spacing="5px" sx={{ fontSize: "15px", paddingX: "20px" }} >
                  <Typography >This action cannot be undone !</Typography>
                  <Typography >Are you sure you want to reset the password ?</Typography>
                </Stack>
                <Stack spacing="10px" direction="row" justifyContent="flex-end" >
                  <Button variant='contained' color="error" sx={{ width: '80px' }} onClick={handleConfirmResetPassword} >Yes</Button>
                  <Button variant="outlined" onClick={() => setIsResetModalOpen(false)} sx={{ width: '80px' }} >No</Button>
                </Stack>
              </Stack>
            </Modal>

            <Modal
              open={isDelModalOpen}
              onClose={() => setIsDelModalOpen(false)}
            >
              <Stack spacing="20px" sx={{ ...modalStyle, paddingY: "25px", minWidth: "500px" }} >
                <Stack direction="row" spacing="10px" alignItems="center" >
                  <ErrorIcon sx={(theme) => ({ fontSize: '32px', color: theme.palette.error.main })} />
                  <Typography variant='h5' color="error" sx={{ fontWeight: "bolder" }} >Delete Student</Typography>
                </Stack>
                <Stack spacing="5px" sx={{ fontSize: "15px", paddingX: "20px" }} >
                  <Typography >This action can not be undone !</Typography>
                  <Typography >Are you sure you want to delete this student and all his/her data ?</Typography>
                </Stack>
                <Stack spacing="10px" direction="row" justifyContent="flex-end" >
                  <Button variant='contained' color="error" sx={{ width: '80px' }} onClick={handleConfirmDeleteStudent} >Yes</Button>
                  <Button variant="outlined" onClick={() => setIsDelModalOpen(false)} sx={{ width: '80px' }} >No</Button>
                </Stack>
              </Stack>
            </Modal>

          </Stack>
        </>
      }
    </Stack>
  )
}

export default StudentBriefInfo
