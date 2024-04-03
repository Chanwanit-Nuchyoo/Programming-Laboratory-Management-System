import { Box, Button, Stack } from "@mui/material";
import { Link, useParams } from "react-router-dom";
import folderIcon from '@/assets/images/foldericon.svg';
import { useState, useEffect } from "react";
import { getStudentListInGroupWithLabScore } from "@/utils/api";
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import { useQuery } from "@tanstack/react-query";
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import AddCircleIcon from "@mui/icons-material/AddCircle";

// components
import MyBreadCrumbs from "@/components/_shared/MyBreadCrumbs";
import Header from "@/components/_shared/Header";
import StudentListTable from "@/components/StudentList/StudentListTable";



const StudentList = () => {
  const [labInfo, setLabInfo] = useState([]);
  const [students, setStudents] = useState([]);
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const { groupId } = useParams();

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
    <Box paddingX={10} >
      <Stack spacing={"20px"}>
        <MyBreadCrumbs
          items={[
            { label: "My Groups", href: "/ins" },
            { label: `Group ${studentList.group_no}`, href: `/ins/group/${groupId}/` },
            { label: "Student List", href: "#" },
          ]}
        />

        <Header logoSrc={folderIcon} title={`Group ${studentList.group_no}`} />

        <Stack direction="row" spacing="10px" sx={{ position: "sticky", top: 0, left: 0 }} >
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
          <Link to={ABS_INS_URL.DYNAMIC.ADD_MIDTERM_SCORE(groupId)} >
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
          </Link>
        </Stack>
        <Stack spacing={"10px"} sx={{ overflowX: "auto", position: "relative" }} >
          <StudentListTable isPending={isPending} labInfo={labInfo} data={students} />
        </Stack>
      </Stack>
    </Box >
  );
};

export default StudentList;