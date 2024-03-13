/* eslint-disable react/prop-types */
import ClassInfoBox from "@/components/InsGroupPage/ClassInfoBox"
import { Typography, Stack, Skeleton } from "@mui/material"
import TimeSchedule from "@/components/_shared/TimeSchedule"
const LeftBox = ({ isClassLoading, groupData }) => {
  return (

    <ClassInfoBox stackProps={{ sx: { height: "100%" } }}>
      <Stack direction={"row"} spacing={"20px"} >
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >Group ID:</Typography>
          <Typography >{isClassLoading ? <Skeleton variant="text" width={90} sx={{ fontSize: "16px" }} /> : groupData?.group_id}</Typography>
        </Stack>
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >Group:</Typography>
          <Typography >{isClassLoading ? <Skeleton variant="text" width={45} sx={{ fontSize: "16px" }} /> : groupData?.group_no}</Typography>
        </Stack>
      </Stack>

      <Stack direction={"row"} spacing={"20px"} >
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >Year:</Typography>
          <Typography >{isClassLoading ? <Skeleton variant="text" width={55} sx={{ fontSize: "16px" }} /> : groupData?.year}</Typography>
        </Stack>
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >Semester:</Typography>
          <Typography >{isClassLoading ? <Skeleton variant="text" width={30} sx={{ fontSize: "16px" }} /> : groupData?.semester}</Typography>
        </Stack>
      </Stack>

      <Stack direction={"row"} spacing={"20px"} >
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >Instructor:</Typography>
          <Typography >{isClassLoading ? <Skeleton variant="text" width={180} sx={{ fontSize: "16px" }} /> : (groupData?.supervisor_firstname + " " + groupData?.supervisor_lastname)}</Typography>
        </Stack>
      </Stack>

      <Stack direction={"row"} spacing={"20px"} >
        <Stack direction={"row"} gap={"5px"} >
          <Typography color={"primary"}  >Class date:</Typography>
        </Stack>
      </Stack>

      {
        isClassLoading ? <Skeleton variant="rounded" width={250} height={24} /> : <TimeSchedule
          classDate={`${groupData?.day_of_week}, ${groupData?.time_start} - ${groupData?.time_end}`}
        />
      }
    </ClassInfoBox>
  )
}

export default LeftBox