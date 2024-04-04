import { Box, Container, Stack, Skeleton, CircularProgress, Typography, Button } from "@mui/material"
import folderIcon from '@/assets/images/foldericon.svg';
import { useParams } from "react-router-dom"
import { useMemo, useEffect } from "react";
import useOnlineStudentsList from "@/hooks/useOnlineStudentsList";
import useGroupDataQuery from "@/hooks/useGroupDataQuery";
import useGroupChapterPermissionQuery from "@/hooks/useGroupChapterPermissionQuery";
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import { userAtom } from "@/store/store";
import { useAtom } from "jotai";
import { useNavigate } from "react-router-dom";
import { ABS_INS_URL } from "@/utils/constants/routeConst"

import Header from "@/components/_shared/Header"
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import LeftBox from "@/components/InsGroupPage/LeftBox";
import MiddleBox from "@/components/InsGroupPage/MiddleBox";
import RightBox from "@/components/InsGroupPage/RightBox";
import GroupLabsTable from "@/components/InsGroupPage/GroupLabsTable";

const InsGroup = () => {
  const navigate = useNavigate();
  const { groupId } = useParams();
  const [user,] = useAtom(userAtom);
  const onlineStudentsList = useOnlineStudentsList(groupId);
  const setSelected = useSetAtom(sidebarSelectedAtom);

  useEffect(() => {
    setSelected('my_groups');
  }, []);

  const { data: groupData, isLoading: isClassLoading, isFetching, ...groupQuery } = useGroupDataQuery(groupId);

  const { data: labData, isLoading: isLabChapterLoading, ...labQuery } = useGroupChapterPermissionQuery(groupId);

  const labDataArray = useMemo(() => {
    return Object.keys(labData || {}).map(key => labData[key]);
  }, [labData]);

  useEffect(() => {
    console.log('groupData', groupData);

    if (!isClassLoading && !isFetching && groupData) {
      const groupStaffs = new Set((groupData.lab_staff || []).map(staff => staff.staff_id));

      if (!groupStaffs.has(user.id) && user.id !== groupData.lecturer) {
        navigate(ABS_INS_URL.STATIC.MY_GROUPS);
      }
    }
  }, [isClassLoading, isFetching, groupData]);

  if (isClassLoading || isLabChapterLoading) {
    return (
      <Box position={"absolute"} top="50%" left="50%" sx={{ transform: "translate(-50%,-50%)" }} >
        <CircularProgress size={100} />
      </Box>
    )
  }

  if (groupQuery.isError || labQuery.isError) {
    let message = "An error occurred while fetching data. Please try again later."

    if (groupQuery.error && groupQuery.error.response && groupQuery.error.response.data && groupQuery.error.response.data.message) {
      message = groupQuery.error.response.data.message;
    }

    return (
      <Stack spacing="10px" justifyContent="center" alignItems="center" position={"absolute"} top="50%" left="50%" sx={{ transform: "translate(-50%,-50%)" }} >
        <Typography variant="h4" >{message}</Typography>
        <Box>
          <Button variant="contained" color="error" onClick={() => { navigate(ABS_INS_URL.STATIC.MY_GROUPS); }} >
            Go back
          </Button>
        </Box>
      </Stack >
    )
  }

  if (!isClassLoading && !isLabChapterLoading) {
    return (
      <Box>
        <Container>
          <Stack spacing={"20px"} >
            <MyBreadCrumbs items={[
              { label: 'My Groups', href: '/ins' },
              { label: `Group ${groupData?.group_no}`, href: '#' },
            ]} />

            <Header logoSrc={folderIcon} title={`Group ${!isClassLoading ? groupData?.group_no : "..."}`} />

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '10px', width: '100%', heigh: '100%' }}>
              <LeftBox isClassLoading={isClassLoading} groupData={groupData} />
              <MiddleBox isClassLoading={isClassLoading} groupData={groupData} onlineStudentsList={onlineStudentsList} />
              <RightBox groupData={groupData} />
            </div>

            <Stack spacing={"10px"}>
              {!isLabChapterLoading && labDataArray && <GroupLabsTable data={labDataArray} />}

              {isLabChapterLoading && <>
                <Skeleton variant="rounded" height={62} />
                <Skeleton variant="rounded" height={62} />
                <Skeleton variant="rounded" height={62} />
                <Skeleton variant="rounded" height={62} />
                <Skeleton variant="rounded" height={62} />
              </>}

            </Stack>

          </Stack>
        </Container>
      </Box>
    )
  }
}

export default InsGroup