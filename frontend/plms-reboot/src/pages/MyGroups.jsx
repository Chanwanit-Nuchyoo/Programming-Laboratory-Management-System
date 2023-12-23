import { Container, Stack, Grid, Skeleton } from "@mui/material";
import slideShow from '@/assets/images/slideshowicon.svg';
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import { useQuery } from "@tanstack/react-query";
import { useEffect } from "react";

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import Header from '@/components/_shared/Header';
import GroupCard from "@/components/MyGroupsPage/GroupCard";
import { getGroupListById } from "../utils/api";

function MyGroups() {
  const setSelected = useSetAtom(sidebarSelectedAtom);

  const { data: groupList = [], isLoading } = useQuery({
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
        <Grid container spacing="10px" sx={{ width: "100%" }}>
          {isLoading &&
            <>
              <Grid item xs={12} md={4}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </Grid>
              <Grid item xs={12} md={4}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </Grid>
              <Grid item xs={12} md={4}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </Grid>
              <Grid item xs={12} md={4}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </Grid>
              <Grid item xs={12} md={4}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </Grid>
              <Grid item xs={12} md={4}>
                <Skeleton variant="rounded" animation="wave" width={"100%"} height={296.35} />
              </Grid>
            </>
          }

          {!isLoading && groupList.map((group) => (
            <GroupCard
              key={group.group_id}
              id={group.group_id}
              groupNo={group.group_no}
              schedule={`${group.day_of_week}, ${group.time_start} - ${group.time_end}`}
              year={group.year}
              semester={group.semester}
              department={group.department}
            />
          ))}
        </Grid>
      </Stack>
    </Container>
  );
}

export default MyGroups;