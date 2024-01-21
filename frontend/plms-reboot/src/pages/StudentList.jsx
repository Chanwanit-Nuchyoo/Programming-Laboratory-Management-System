import { Box, Button, Stack } from "@mui/material";
import { Link, useParams } from "react-router-dom";
import folderIcon from '@/assets/images/foldericon.svg';
import { useState, useEffect } from "react";
import AddCircleIcon from "@mui/icons-material/AddCircle";
import { getStudentListInGroupWithLabScore } from "@/utils/api";
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import { useQuery } from "@tanstack/react-query";

// components
import MyBreadCrumbs from "@/components/_shared/MyBreadCrumbs";
import Header from "@/components/_shared/Header";
import StudentListTableHead from "@/components/StudentList/StudentListTableHead";
import StudentListTableBody from "@/components/StudentList/StudentListTableBody";


 
const StudentList = () => {
  const [labInfo, setLabInfo] = useState([]);
  const [students, setStudents] = useState([]);

  const { groupId } = useParams();

  const { data: studentList = [], isLoading } = useQuery({
    queryKey: ["studentList", groupId],
    queryFn: ({ queryKey }) => getStudentListInGroupWithLabScore(queryKey[1]),
  });

  useEffect(() => {
    if (!isLoading && studentList) {
      setLabInfo(studentList.lab_info);
      setStudents(studentList.student_list);
    }
  }, [isLoading, studentList]);

  return (
    <Box>
      <Stack spacing={"20px"}>
        <MyBreadCrumbs
          items={[
            { label: "My Groups", href: "/ins" },
            { label: `Group ${studentList.group_no}`, href: `/ins/group/${groupId}/` },
            { label: "Student List", href: "#" },
          ]}
        />

        <Header logoSrc={folderIcon} title={`Group ${studentList.group_no}`} />

        <Stack spacing={"10px"} width="calc(100vw-256px)" sx={{ overflowX: "auto", position: "relative" }} >
          <Box>
            <Link to={ABS_INS_URL.DYNAMIC.ADD_STUDENT(groupId)} >
              <Button
                variant="contained"
                color="primary"
                sx={{
                  height:'40px', 
                  width: '200px', 
                  fontSize: '16px',
                  textTransform: 'none',
                }}
                startIcon={<AddCircleIcon />}
              >
                Add Student
              </Button>
            </Link>
          </Box>

          <StudentListTableHead isLoading={isLoading} labInfo={labInfo} />

          <StudentListTableBody isLoading={isLoading} labInfo={labInfo} students={students} />

        </Stack>
      </Stack>
    </Box >
  );
};

export default StudentList;