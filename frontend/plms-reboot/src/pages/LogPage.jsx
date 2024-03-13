import { Box, Button, Stack, TextField } from "@mui/material"
import blueFolder from "@/assets/images/bluefoldericon.svg"
import { useParams } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { getBreadCrumbs } from '@/utils/api';
import { ABS_INS_URL } from "@/utils/constants/routeConst"
import { useState, useMemo, useEffect } from 'react';
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import { redirect } from "react-router-dom";
// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from "@/components/_shared/Header"
import Logtable from "@/components/LogPage/Logtable"

const LogPage = () => {
  const { groupId } = useParams();
  const setSelected = useSetAtom(sidebarSelectedAtom);
  
  useEffect(() => {
    setSelected('my_groups');
  }, []);

  const breadCrumbsId = useMemo(() => {
    return {
      'group_id': groupId,
    }
  }, [groupId])

  const { data: bc, isLoading: isBcLoading } = useQuery({
    queryKey: ['add-student-info', breadCrumbsId],
    queryFn: () => getBreadCrumbs(breadCrumbsId)
  })

  const groupsQuery = [{
    "stu_id": 63010185,
    "remote_ip": "1.0.210.148" ,
    "remote_port": "53194" ,
    "pagename": "login",
    "agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36",
    "action": 
    `"job_ip" => 12345,"status" => "pending","submittion_id" => 1234,"attemp" => 2,"sourcecode_filename" => "dswasds"`,
  },
  {
    "stu_id": 63010185,
    "remote_ip": "1.0.210.148" ,
    "remote_port": "53194" ,
    "pagename": "login",
    "agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36",
    "action": 
    `"job_ip" => 12345,"status" => "pending","submittion_id" => 1234,"attemp" => 3,"sourcecode_filename" => "dswasds.py"`,
  }
]
// format string to json object
const formatToObject = (actionString) => {
  const entries = actionString.split(',').map(entry => {
    const [key, value] = entry.split('=>').map(str => str.trim());
    return [key.replace(/['"]/g, ''), eval(value)];
  });
  return Object.fromEntries(entries);
}
for (let i = 0; i < groupsQuery.length; i++) {
  groupsQuery[i].action = formatToObject(groupsQuery[i].action);
}

  return (
    <Box >
      <Stack spacing={"20px"}>
        <MyBreadCrumbs items={[

          { label: 'My Groups', href: '/ins' },
          { label: `Group ${!isBcLoading ? bc.group_no : "..."} `, href: ABS_INS_URL.DYNAMIC.GROUP(groupId) },
          { label: 'Log Activity', href: '#' }
        ]} />

        <Header logoSrc={blueFolder} title={`Group ${!isBcLoading ? bc.group_no : "..."} Log Activity`} />

        <Logtable queryData={groupsQuery}/>

      </Stack>
    </Box>
  )
}

export default LogPage
