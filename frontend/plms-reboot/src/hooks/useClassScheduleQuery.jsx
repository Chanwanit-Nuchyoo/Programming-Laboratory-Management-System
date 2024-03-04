import { useQuery } from '@tanstack/react-query';
import { getClassSchedule } from '@/utils/api';

const useClassScheduleQuery = (groupId) => {
  return useQuery({
    queryKey: ['groupData', groupId],
    queryFn: () => getClassSchedule(groupId)
  });
}

export default useClassScheduleQuery;