import { Box, Button, Stack } from "@mui/material"
import blueFolder from "@/assets/images/bluefoldericon.svg"
import { useParams } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { getBreadCrumbs } from '@/utils/api';
import { ABS_INS_URL } from "@/utils/constants/routeConst"
import { useState, useMemo, useEffect, useRef } from 'react';
import { useSetAtom } from "jotai";
import useEventSource from "@/hooks/useEventSource";
import { sidebarSelectedAtom } from "@/store/store";

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from "@/components/_shared/Header"
import Logtable from "@/components/LogPage/Logtable"
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';

const LogPage = () => {
  const { groupId } = useParams();
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const [logData, setLogData] = useState([]);
  const stackRef = useRef();
  const scrollToBottomRef = useRef(true);
  const scrollToBottom = () => {
    if (stackRef.current) {
      stackRef.current.scrollTop = stackRef.current.scrollHeight;
    }
  };

  useEffect(() => {
    setSelected('my_groups');
    scrollToBottom();
  }, []);

  useEffect(() => {
    if (scrollToBottomRef.current && logData.length > 0) {
      scrollToBottomRef.current = false;
      scrollToBottom();
    }
  }, [logData]);

  useEventSource(
    `${import.meta.env.VITE_REALTIME_BASE_URL}/subscribe/class-logs/${groupId}`,
    (event) => {
      let data = JSON.parse(event.data);

      if (Array.isArray(data)) {
        data = data.map(log => {
          let page_name = log.page_name;
          if (page_name === 'exercise_submit') {
            log.action = JSON.parse(log.action);
          }
          return log;
        });

        setLogData(data);
      } else {
        if (data.page_name === 'exercise_submit') {
          data.action = JSON.parse(data.action);
        }

        // check if scroll is at the bottom of stack or not
        if (stackRef.current.scrollHeight - stackRef.current.scrollTop === stackRef.current.clientHeight) {
          scrollToBottomRef.current = true;
        }

        setLogData((prevData) => [...prevData, data]);
      }
    }
  );

  const breadCrumbsId = useMemo(() => {
    return {
      'group_id': groupId,
    }
  }, [groupId])

  const { data: bc, isLoading: isBcLoading } = useQuery({
    queryKey: ['add-student-info', breadCrumbsId],
    queryFn: () => getBreadCrumbs(breadCrumbsId)
  })

  return (
    <Box paddingX={10}>
      <Stack spacing={"20px"}>
        <MyBreadCrumbs items={[
          { label: 'My Groups', href: '/ins' },
          { label: `Group ${!isBcLoading ? bc.group_no : "..."} `, href: ABS_INS_URL.DYNAMIC.GROUP(groupId) },
          { label: 'Log Activity', href: '#' }
        ]} />

        <Header logoSrc={blueFolder} title={`Group ${!isBcLoading ? bc.group_no : "..."} Log Activity`} />

        <Box position="relative">
          <Stack ref={stackRef} sx={{ position: "relative", height: "800px", overflowY: "scroll", borderRadius: "8px", overflowX: "hidden" }}>
            <Logtable queryData={logData} />
          </Stack>
          <Button
            variant="contained"
            sx={{
              position: "absolute",
              right: "20px",
              bottom: "10px",
              zIndex: 10,
              bgcolor: "var(--ebony)",
              borderRadius: "100px",
              opacity: 0.5,
            }} onClick={scrollToBottom}
          >
            <KeyboardArrowDownIcon />
          </Button>
        </Box>
      </Stack>
    </Box>
  )
}

export default LogPage