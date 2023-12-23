import { useMemo } from 'react';
import { Container, Stack } from '@mui/material';
import Header from '@/components/_shared/Header';
/* import Testcases from '@/components/AddExercisePage/Testcases'; */
import folderIcon from '@/assets/images/foldericon.png';
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import ExerciseInfoForm from '@/components/_shared/ExerciseInfoForm';
import { useParams } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { getBreadCrumbs } from '@/utils/api';


const AddExercise = () => {
  const { groupId, chapterId, level } = useParams();

  const breadCrumbsId = useMemo(() => {
    return {
      'group_id': groupId,
      'chapter_id': chapterId,
    }
  }, [chapterId, groupId])

  const { data: bc, isLoading: isBcLoading } = useQuery({
    queryKey: ['add-exercise-info', breadCrumbsId],
    queryFn: () => getBreadCrumbs(breadCrumbsId)
  })

  return (
    <Container>
      <Stack spacing={2}>
        <MyBreadCrumbs items={[
          { label: 'My Groups', href: '/ins' },
          { label: isBcLoading ? "Group ..." : `Group ${bc?.group_no}`, href: `/ins/group/${groupId}` },
          { label: isBcLoading ? "..." : `Chapter ${chapterId} : ${bc?.chapter_name}`, href: `/ins/group/${groupId}/chapter/${chapterId}` },
          { label: "Add Exercise", href: '#' },
        ]} />

        <Header logoSrc={folderIcon} title={`Chapter ${chapterId} : ${bc?.chapter_name}`} />
        <ExerciseInfoForm onAddExercisePage={true} lv={level} editable />
        {/* <Testcases editable /> */}
      </Stack>
    </Container>
  );
};

export default AddExercise;