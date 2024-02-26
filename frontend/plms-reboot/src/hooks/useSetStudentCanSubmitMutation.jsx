import { useMutation, useQueryClient } from '@tanstack/react-query';
import { setStudentCanSubmit } from '@/utils/api';

export default function useSetStudentCanSubmitMutation(groupId) {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: setStudentCanSubmit,
    onSuccess: () => {
      queryClient.invalidateQueries(["studentList", groupId])
    }
  })
}

