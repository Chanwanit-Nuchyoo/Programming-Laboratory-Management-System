import { Box, Button, Stack, Typography } from "@mui/material";
import { Link, useParams } from "react-router-dom";
import folderIcon from '@/assets/images/foldericon.svg';
import { useState, useEffect } from "react";
import { getStudentListInGroupWithLabScore } from "@/utils/api";
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import { useQuery } from "@tanstack/react-query";
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import { userAtom } from "@/store/store";
import { useAtom } from "jotai";
import useOnlineStudentsList from "@/hooks/useOnlineStudentsList";
import AddCircleIcon from "@mui/icons-material/AddCircle";

// components
import MyBreadCrumbs from "@/components/_shared/MyBreadCrumbs";
import Header from "@/components/_shared/Header";
import StudentListTable from "@/components/StudentList/StudentListTable";

const StudentList = () => {
  const { groupId } = useParams();
  const [user] = useAtom(userAtom);
  const [labInfo, setLabInfo] = useState([]);
  const [students, setStudents] = useState(null);
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const onlineStudentsList = useOnlineStudentsList(groupId);
  const isAdmin = user?.username === "kanut";

  const { data: studentList = [], isPending } = useQuery({
    queryKey: ["studentList", groupId],
    queryFn: ({ queryKey }) => getStudentListInGroupWithLabScore(queryKey[1]),
  });

  useEffect(() => {
    if (!isPending && studentList) {
      setLabInfo(studentList.lab_info);
      setStudents(studentList.student_list);
    }
  }, [isPending, studentList]);

  useEffect(() => {
    setSelected('my_groups');
  }, []);

  return (
    <Box paddingX={5} >
      <Stack spacing={"20px"}>
        <MyBreadCrumbs
          items={[
            { label: "My Groups", href: "/ins" },
            { label: `Group ${studentList.group_no}`, href: `/ins/group/${groupId}/` },
            { label: "Student List", href: "#" },
          ]}
        />

        <Header logoSrc={folderIcon} title={`Group ${studentList.group_no}`} />

        <Stack direction="row" spacing="10px" >
          <Link to={ABS_INS_URL.DYNAMIC.ADD_STUDENT(groupId)} >
            <Button
              variant="contained"
              color="primary"
              sx={{
                height: '40px',
                width: '200px',
                fontSize: '16px',
                textTransform: 'none',
              }}
              startIcon={<AddCircleIcon />}
            >
              Add Student
            </Button>
          </Link>
          {isAdmin && <Link to={isAdmin ? ABS_INS_URL.DYNAMIC.ADD_MIDTERM_SCORE(groupId) : ""} >
            <Button
              variant="contained"
              color="primary"
              sx={{
                height: '40px',
                width: '250px',
                fontSize: '16px',
                textTransform: 'none',
              }}
              startIcon={<AddCircleIcon />}
            >
              Upload Midterm Score
            </Button>
          </Link>}
        </Stack>
        <Stack spacing="10px">
          <Stack spacing="10px" width="400px">
            <Stack direction="row" spacing="20px" alignItems="center" >
              <Stack direction="row" alignItems="center" spacing="5px" >
                <Box width="20px" height="20px" bgcolor="#63c54f" borderRadius="50%" />
                <Typography variant="h6" >Online: {onlineStudentsList.length}</Typography>
              </Stack>
              <Stack direction="row" alignItems="center" spacing="5px" >
                <Box width="20px" height="20px" bgcolor="#e84736" borderRadius="50%" />
                <Typography variant="h6" >Offline: {!isPending && students ? students.length - onlineStudentsList.length : ""}</Typography>
              </Stack>
              <Stack direction="row" alignItems="center" spacing="5px" >
                <Typography variant="h6" >Total: {!isPending && students ? students.length : ""}</Typography>
              </Stack>
            </Stack>
          </Stack>
          <Stack spacing={"10px"} sx={{ overflowX: "auto", position: "relative" }} >
            <StudentListTable isPending={isPending} labInfo={labInfo} data={students || []} onlineStudentsList={onlineStudentsList} />
          </Stack>
        </Stack>
      </Stack>
    </Box >
  );
};

export default StudentList;