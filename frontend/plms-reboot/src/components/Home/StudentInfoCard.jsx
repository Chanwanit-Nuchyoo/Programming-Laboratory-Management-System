/* eslint-disable react/prop-types */
import { Box, Stack, Avatar, Typography } from "@mui/material"
import avatarPlaceholder from "@/assets/images/avatarplaceholder.svg"
import { useQuery } from "@tanstack/react-query";
import { getStudentCardInfo } from "@/utils/api"
import { studentCardAtom } from "@/store/store";
import { useAtom } from "jotai";
import { useEffect } from "react";
const StudentInfoCard = ({ user }) => {
  const [studentCardInfo, setStudentCardInfo] = useAtom(studentCardAtom)

  const { data: studentCard, isLoading } = useQuery({
    queryKey: ['student-card-info', user.id],
    queryFn: () => getStudentCardInfo(user.id),
    staleTime: Infinity,
  })

  useEffect(() => {
    if (!isLoading && studentCard) {
      setStudentCardInfo(studentCard);
    }
  }, [isLoading, studentCard])

  return (
    <Box bgcolor={"var(--ebony)"} borderRadius={"8px"} padding={"20px"} >
      <Stack direction={"row"} justifyContent={"space-between"} >
        <Stack spacing={"10px"} justifyContent={"space-between"}  >
          <Avatar src={user ? `${user.avatar}` : avatarPlaceholder} alt={user ? user.name : "Avatar Image"} variant="rounded" sx={{ width: 150, height: 150 }} />
          <Stack justifyContent={"center"} alignItems={"center"} width={"150px"} height={"30px"} sx={{ textAlign: "center" }} paddingY={"5px"} borderRadius={"8px"} bgcolor={"rgba(78, 199, 83, 0.50)"} >
            <Typography>{!isLoading && studentCard && studentCard.stu_ip}</Typography>
          </Stack>
        </Stack>

        <Stack spacing={"8px"} width={"70%"} >
          <Stack direction={"row"} spacing="20px" >
            <Stack direction="row">
              <Typography color={"var(--cerulean)"} >Student info</Typography>
              <Typography>&nbsp;</Typography>
              <Typography>{!isLoading && studentCard && `${studentCard.stu_id} ${studentCard.stu_firstname} ${studentCard.stu_lastname}`}</Typography>
            </Stack>
          </Stack>
          <Stack direction={"row"} spacing="20px" >
            <Stack direction={"row"} >
              <Typography color={"var(--cerulean)"} >Group ID</Typography>
              <Typography>&nbsp;</Typography>
              <Typography>{!isLoading && studentCard && studentCard.group_id}</Typography>
            </Stack>
            <Stack direction={"row"} >
              <Typography color={"var(--cerulean)"} >Group</Typography>
              <Typography>&nbsp;</Typography>
              <Typography>{!isLoading && studentCard && studentCard.group_no}</Typography>
            </Stack>
          </Stack>
          <Stack direction={"row"} spacing="20px" >
            <Stack direction={"row"} >
              <Typography color={"var(--cerulean)"} >Class date</Typography>
              <Typography>&nbsp;</Typography>
              <Typography>{!isLoading && studentCard && `${studentCard.day_of_week}, ${studentCard.time_start} - ${studentCard.time_end}`}</Typography>
            </Stack>
          </Stack>
          <Stack direction={"row"} spacing="20px" >
            <Stack direction={"row"} >
              <Typography color={"var(--cerulean)"} >Year</Typography>
              <Typography>&nbsp;</Typography>
              <Typography>{!isLoading && studentCard && studentCard.year}</Typography>
            </Stack>
            <Stack direction={"row"} >
              <Typography color={"var(--cerulean)"} >Semeseter</Typography>
              <Typography>&nbsp;</Typography>
              <Typography>{!isLoading && studentCard && studentCard.semester}</Typography>
            </Stack>
          </Stack>
          <Stack direction={"row"} spacing="20px" >
            <Stack direction={"row"} >
              <Typography color={"var(--cerulean)"} >Instructor</Typography>
              <Typography>&nbsp;</Typography>
              <Typography>{!isLoading && studentCard && studentCard.lecturer}</Typography>
            </Stack>
          </Stack>

          {/* <Stack justifyContent={"center"} alignItems={"center"} width={"100%"} height={"30px"} sx={{ textAlign: "center" }} paddingY={"5px"} borderRadius={"8px"} bgcolor={"var(--chathamBlue)"} >
            <Typography>คะแนนสอบกลางภาค (60) {!isLoading && studentCard && studentCard.mid_score} คะแนน</Typography>
          </Stack> */}

        </Stack>
      </Stack>
    </Box>
  )
}

export default StudentInfoCard