import { useEffect } from "react";
import { Container, Typography, Box, Stack, Button } from "@mui/material"
import Grid from '@mui/material/Unstable_Grid2';
import StudentInfoCard from "@/components/Home/StudentInfoCard"
import KeyboardDoubleArrowRightIcon from '@mui/icons-material/KeyboardDoubleArrowRight';
import Assignments from "@/components/Home/Assignments"
import ComputerEng from "@/assets/images/logologin.svg"
import happyCoding from "@/assets/images/happycoding.png"
import { useAtomValue, useSetAtom } from "jotai"
import { userAtom, sidebarSelectedAtom } from "@/store/store"
import { useNavigate } from "react-router-dom";
import { ABS_STU_URL } from "@/utils/constants/routeConst"

const StuHome = () => {
  const user = useAtomValue(userAtom)
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const navigate = useNavigate();

  useEffect(() => {
    setSelected('stu_home');
  }, [])

  return (
    <Container>
      <Stack spacing={"20px"} >
        <Box padding={"30px"} bgcolor={"var(--mirage)"} borderRadius={"16px"} >
          <Grid container spacing={1} >
            <Grid xs={12} md={8} >
              <Stack spacing={"20px"} >
                <Box>
                  <Typography style={{ fontSize: '24px' }} >Wellcome to,</Typography>
                  <Typography color={"var(--cerulean)"} style={{ fontSize: '40px', fontWeight: 'bold' }} >Computer Programming Python.</Typography>
                </Box>
                <StudentInfoCard user={user} />
              </Stack>
            </Grid>
            <Grid md={4} sx={{ display: { xs: 'none', md: 'block' } }} >
              <Stack justifyContent={"center"} alignItems={"center"} height={"100%"} >
                <img width={"240px"} height={"240px"} src={ComputerEng} alt="Computer Engineer" />
              </Stack>
            </Grid>
          </Grid>
        </Box>
        {/* <Assignments /> */}
        <Stack direction="row" borderRadius="16px" overflow="hidden" bgcolor={"var(--biscay)"} >
          <Stack flex={1} justifyContent='center' alignItems='center' bgcolor="#133558" >
            <img src={happyCoding} alt="happy coding" />
          </Stack>
          <Stack flex={1} spacing="50px" justifyContent='center' alignItems='center' >
            <Stack justifyContent='center' alignItems='center'>
              <Typography variant="h5" >The heart concept is</Typography>
              <Typography variant="h3" color="var(--cerulean)" >&quot;Learning by doing&quot;</Typography>
            </Stack>
            <Button variant="contained" sx={{ paddingX: "25px", alignmentBaseline: "baseline", height: "40px" }} endIcon={<KeyboardDoubleArrowRightIcon />} >
              <Typography onClick={() => { navigate(ABS_STU_URL.STATIC.EXERCISE_LIST) }} >Let&apos;s start doing exercises !</Typography>
            </Button>
          </Stack>
        </Stack>
      </Stack>
    </Container>
  )
}

export default StuHome