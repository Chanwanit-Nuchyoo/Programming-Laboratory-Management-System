import { useState } from "react";
import { Container, Stack, Skeleton, Typography, Button, FormControl, InputLabel, Select, MenuItem } from "@mui/material";
import slideShow from '@/assets/images/slideshowicon.svg';
import { useSetAtom, useAtom } from "jotai";
import { sidebarSelectedAtom, userAtom } from "@/store/store";
import { useQuery } from "@tanstack/react-query";
import { useEffect } from "react";
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import { Link } from "react-router-dom";
// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import Header from '@/components/_shared/Header';
import GroupCard from "@/components/MyGroupsPage/GroupCard";
import { getGroupListById } from "@/utils/api";

function MyGroups() {
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const [yearOptions, setYearOptions] = useState([]);
  const [user] = useAtom(userAtom);
  const [selectedYear, setSelectedYear] = useState(localStorage.getItem(`${user.id}:year`) || "");
  const [filteredGroups, setFilteredGroups] = useState([]);

  const groupListQuery = useQuery({
    queryKey: ['groupList', import.meta.env.VITE_YEAR],
    queryFn: getGroupListById,
  });

  const handleSelectYear = (value) => {
    localStorage.setItem(`${user.id}:year`, value);
    setSelectedYear(value);
  }

  useEffect(() => {
    setSelected('my_groups');
  }, []);

  useEffect(() => {
    if (!groupListQuery.isLoading && groupListQuery.data) {
      if (Array.isArray(groupListQuery.data) && groupListQuery.data.length > 0) {
        const yearOptions = groupListQuery.data.map((group) => group.year)
        const uniqueYearOptions = [...new Set(yearOptions)];
        setYearOptions(Array.from(uniqueYearOptions).sort());
      }
    }
  }, [groupListQuery.isLoading, groupListQuery.data])

  useEffect(() => {
    if (!groupListQuery.isLoading && groupListQuery.data) {
      if (Array.isArray(groupListQuery.data) && groupListQuery.data.length > 0) {
        if (selectedYear) {
          const filtered = groupListQuery.data.filter((group) => group.year === selectedYear);
          setFilteredGroups(filtered);
        } else {
          setFilteredGroups(groupListQuery.data);
        }
      }
    }
  }, [selectedYear, groupListQuery.isLoading, groupListQuery.data])

  const items = [{ label: 'My Groups', href: '/ins' }];

  return (
    <Container>
      <Stack spacing="20px">
        <MyBreadCrumbs items={items} />
        <div style={{ display: 'flex', gap: "10px", alignItems: "center" }}>
          <Header logoSrc={slideShow} title="My Groups" />
          <Link to={ABS_INS_URL.STATIC.ADDGROUP}>
            <Button variant="contained" type="button">Add Group</Button>
          </Link>
        </div>

        <Stack sx={{ width: '100%', marginBottom: '20px' }} direction="row" spacing={2}>
          <FormControl size="small" sx={{ width: "110px" }}>
            <InputLabel id="select-label" shrink={selectedYear !== ""}>
              Year
            </InputLabel>
            <Select
              labelId="select-label"
              value={yearOptions.length > 0 ? selectedYear : ""}
              onChange={(event) => handleSelectYear(event.target.value)}
            >
              <MenuItem value="">
                <em>None</em>
              </MenuItem>
              {yearOptions.map((year) => (
                <MenuItem key={year} value={year}>
                  {year}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </Stack>

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
              {Array.isArray(filteredGroups) && filteredGroups.length > 0 ?
                filteredGroups.map((group) => (
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