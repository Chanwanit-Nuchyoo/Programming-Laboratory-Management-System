import { Box, Container, Stack, Skeleton } from "@mui/material"
import folderIcon from '@/assets/images/foldericon.svg';
import { useParams } from "react-router-dom"
import { useMemo, useEffect } from "react";
import useOnlineStudentsList from "@/hooks/useOnlineStudentsList";
import useGroupDataQuery from "@/hooks/useGroupDataQuery";
import useGroupChapterPermissionQuery from "@/hooks/useGroupChapterPermissionQuery";
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";

import Header from "@/components/_shared/Header"
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import LeftBox from "@/components/InsGroupPage/LeftBox";
import MiddleBox from "@/components/InsGroupPage/MiddleBox";
import RightBox from "@/components/InsGroupPage/RightBox";
import GroupLabsTable from "@/components/InsGroupPage/GroupLabsTable";

const InsGroup = () => {
  const { groupId } = useParams();
  const onlineStudentsList = useOnlineStudentsList(groupId);
  const setSelected = useSetAtom(sidebarSelectedAtom);

  useEffect(() => {
    setSelected('my_groups');
  }, []);

  const { data: groupData, isLoading: isClassLoading } = useGroupDataQuery(groupId);

  const { data: labData, isLoading: isLabChapterLoading } = useGroupChapterPermissionQuery(groupId);

  const labDataArray = useMemo(() => {
    return Object.keys(labData || {}).map(key => labData[key]);
  }, [labData]);

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

export default InsGroup