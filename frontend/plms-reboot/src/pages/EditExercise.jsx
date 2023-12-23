import { useMemo } from 'react';
import { defaultCon } from '@/store/store';
import { Box, Container, Stack } from '@mui/material';
import ExerciseInfoForm from '@/components/_shared/ExerciseInfoForm';
import Header from '@/components/_shared/Header';
import Testcases from '@/components/AddExercisePage/Testcases';
import folderIcon from '@/assets/images/foldericon.png';
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import { useParams } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { getBreadCrumbs, getExerciseFormData } from '@/utils/api';

const EditExercise = () => {
  // Params
  const { groupId, level, chapterId, exerciseId } = useParams();

  const breadCrumbsId = useMemo(() => {
    return {
      'group_id': groupId,
      'chapter_id': chapterId,
      'exercise_id': exerciseId,
    }
  }, [chapterId, exerciseId, groupId])

  // Query breadCrumbs data
  const { data: bc, isLoading: isBcLoading } = useQuery({
    queryKey: ['breadcrumbs', breadCrumbsId],
    queryFn: () => getBreadCrumbs(breadCrumbsId)
  });

  // Query the form data
  const { data: form, isLoading: isFormLoading } = useQuery({
    queryKey: ['edit-exercise-form', exerciseId],
    queryFn: () => getExerciseFormData(exerciseId)
  });

  // Query the testcases data
  // const { data: testcases, isLoading: isTestcasesLoading } = useQuery({
  //   queryKey: ['edit-exercise-testcase', exerciseId],
  //   queryFn: () => getExerciseFormData(exerciseId)
  // });

  const formData = isFormLoading ? {
    lab_name: '',
    lab_content: '',
    sourcecode_content: '# Source code\n',
    keyword_constraints: {
      suggested_constraints: defaultCon,
      user_defined_constraints: defaultCon
    }
  } : {
    lab_name: form.lab_name,
    lab_content: form.lab_content,
    sourcecode_content: form.sourcecode_content,
    keyword_constraints: {
      suggested_constraints: form["keyword_constraints"]["suggested_constraints"],
      user_defined_constraints: form["keyword_constraints"]["user_defined_constraints"]
    },
  }

  let testcaseData = []

  // Render
  return (
    <Box>
      <Container>
        <Stack spacing={2}>
          <MyBreadCrumbs items={[
            { label: 'My Groups', href: '/ins' },
            { label: isBcLoading ? "..." : `Group ${bc?.group_no}`, href: `/ins/group/${groupId}` },
            { label: isBcLoading ? "..." : `Chapter ${chapterId} : ${bc?.chapter_name}`, href: isBcLoading ? "#" : `/ins/group/${groupId}/chapter/${chapterId}` },
            { label: isBcLoading ? "..." : bc?.lab_name, href: '#' },
          ]} />

          <Header logoSrc={folderIcon} title={`Chapter ${chapterId} : ${bc?.chapter_name}`} />
          <ExerciseInfoForm lv={level} editable={true} formData={formData} />
          <Testcases testcaseData={testcaseData} hasSourceCode={!!formData.sourcecode_content} />
        </Stack>
      </Container>
    </Box >
  );
};

export default EditExercise;