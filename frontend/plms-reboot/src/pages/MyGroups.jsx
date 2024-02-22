import { Container, Stack, Skeleton, Box, Typography } from "@mui/material";
import slideShow from '@/assets/images/slideshowicon.svg';
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import { useQuery } from "@tanstack/react-query";
import { useEffect } from "react";

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import Header from '@/components/_shared/Header';
import GroupCard from "@/components/MyGroupsPage/GroupCard";
import { getGroupListById } from "@/utils/api";

function MyGroups() {
  const setSelected = useSetAtom(sidebarSelectedAtom);

  const groupListQuery = useQuery({
    queryKey: ['groupList', import.meta.env.VITE_YEAR],
    queryFn: getGroupListById,
  });

  useEffect(() => {
    setSelected('my_groups');
  }, [setSelected]);

  const items = [{ label: 'My Groups', href: '/ins' }];

  return (
    <Container>
      <Stack spacing="20px">
        <MyBreadCrumbs items={items} />
        <Header logoSrc={slideShow} title="My Groups" />
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: "10px", width: '100%', flexDirection: "row", justifyContent: "flex-start" }}>


          {groupListQuery.isLoading &&
            <>
              <div style={{ flex: '0 0 calc(100% / 3)', marginBottom: '20px' }}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </div>
              <div style={{ flex: '0 0 calc(100% / 3)', marginBottom: '20px' }}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </div>
              <div style={{ flex: '0 0 calc(100% / 3)', marginBottom: '20px' }}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </div>
              <div style={{ flex: '0 0 calc(100% / 3)', marginBottom: '20px' }}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </div>
              <div style={{ flex: '0 0 calc(100% / 3)', marginBottom: '20px' }}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </div>
              <div style={{ flex: '0 0 calc(100% / 3)', marginBottom: '20px' }}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </div>
            </>
          }

          {!groupListQuery.isLoading && !groupListQuery.isError && groupListQuery.data &&
            <>
              {Array.isArray(groupListQuery.data) && groupListQuery.data.length > 0 ?
                groupListQuery.data.map((group) => (
                  <GroupCard
                    key={group.group_id}
                    id={group.group_id}
                    groupNo={group.group_no}
                    schedule={`${group.day_of_week}, ${group.time_start} - ${group.time_end}`}
                    year={group.year}
                    semester={group.semester}
                    department={group.department}
                  />
                ))
                :
                <Stack justifyContent="center" width="100%" direction="row" padding="20px" bgcolor="var(--mirage)" borderRadius="8px" >
                  <Typography>No groups found.</Typography>
                </Stack>
              }
            </>
          }

          {!groupListQuery.isLoading && groupListQuery.isError && <>
            <div>
              {error.message}
            </div>
          </>}
        </div>
      </Stack>
    </Container>
  );
}

export default MyGroups;