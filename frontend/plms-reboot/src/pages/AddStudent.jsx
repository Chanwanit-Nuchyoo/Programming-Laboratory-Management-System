import { Box, Button, Stack, TextField } from "@mui/material"
import blueFolder from "@/assets/images/bluefoldericon.svg"
import { useParams } from 'react-router-dom';
import { addStudent } from '@/utils/api';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import React, { useState } from 'react';
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

  const { data: groupData, isLoading: isClassLoading } = useQuery({
    queryKey: ['groupData', groupId],
    queryFn: async () => {
      const res = await axios.get(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getGroupDataById?group_id=${groupId}`, { withCredentials: true })
      return res.data.payload.class_schedule;
    }
  });

  const { mutate: AddStudentMutation } = useMutation({
    mutationFn: addStudent,
    onSuccess: () => {
      queryClient.invalidateQueries(['groupData', groupId]);
    },
  });

  return (
    <Box >
      <Stack spacing={"20px"}>
        <MyBreadCrumbs items={[

          { label: 'My Groups', href: '/ins' },
          { label: `Group ${groupData?.group_no} `, href: '#' },
        ]} />

        <Header logoSrc={blueFolder} title={`Group ${!isClassLoading ? groupData?.group_no : "..."}`} />

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
            }}>Submit</Button>
        </Stack>

      </Stack>
    </Box>
  )
}

export default AddStudent