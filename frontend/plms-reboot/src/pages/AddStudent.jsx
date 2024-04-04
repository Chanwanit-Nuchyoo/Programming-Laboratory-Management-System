import { Box, Button, Stack, TextField } from "@mui/material"
import blueFolder from "@/assets/images/bluefoldericon.svg"
import { useParams } from 'react-router-dom';
import { addStudent } from '@/utils/api';
import { useMutation, useQuery } from '@tanstack/react-query';
import { getBreadCrumbs } from '@/utils/api';
import { ABS_INS_URL } from "@/utils/constants/routeConst"
import { useState, useMemo, useEffect } from 'react';
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import { useNavigate } from "react-router-dom";
// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from "@/components/_shared/Header"

const placeholder = `Copy from Excel and paste here

1 6xxxxxxx Name Surname
2 6xxxxxxx Name Surname
3 6xxxxxxx Name Surname
...
          `

const AddStudent = () => {
  const { groupId } = useParams();
  const [student_data, setStudentData] = useState('');
  const setSelected = useSetAtom(sidebarSelectedAtom);
  const navigate = useNavigate();

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

  const { mutate: AddStudentMutation } = useMutation({
    mutationFn: addStudent,
    onSuccess: () => {
      navigate(ABS_INS_URL.DYNAMIC.STUDENT_LIST(groupId));
    },
    onError: (error) => {
      if (error.response.data.message) {
        alert(error.response.data.message)
      } else {
        alert("Failed to add student")
      }
    }
  });

  return (
    <Box >
      <Stack spacing={"20px"}>
        <MyBreadCrumbs items={[

          { label: 'My Groups', href: '/ins' },
          { label: `Group ${!isBcLoading ? bc.group_no : "..."} `, href: ABS_INS_URL.DYNAMIC.GROUP(groupId) },
          { label: 'Student List', href: ABS_INS_URL.DYNAMIC.STUDENT_LIST(groupId) },
          { label: 'Add Student', href: '#' }
        ]} />

        <Header logoSrc={blueFolder} title={`Group ${!isBcLoading ? bc.group_no : "..."}`} />

        <Box >
          <TextField color="primary" variant="outlined" fullWidth multiline rows={20} placeholder={placeholder}
            value={student_data}
            onChange={(e) => setStudentData(e.target.value)} />
        </Box>

        <Stack direction="row" justifyContent={"flex-end"} >
          <Button variant="contained" color="primary"
            sx={{
              height: '40px',
              width: '120px',
              fontSize: '16px',
              textTransform: 'none'
            }}
            onClick={() => {
              AddStudentMutation({ student_data, group_id: groupId });
              setStudentData('');
              // history.push(ABS_INS_URL.STATIC.MY_GROUPS);
            }}>Submit</Button>
        </Stack>

      </Stack>
    </Box>
  )
}

export default AddStudent