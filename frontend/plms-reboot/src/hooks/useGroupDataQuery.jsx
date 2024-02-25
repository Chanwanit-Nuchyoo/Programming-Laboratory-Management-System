import { useQuery } from '@tanstack/react-query';
import { getGroupDataById } from '@/utils/api';

const useGroupDataQuery = (groupId) => {
  return useQuery({
    queryKey: ['groupData', groupId],
    queryFn: () => getGroupDataById(groupId)
  });
}

export default useGroupDataQuery;