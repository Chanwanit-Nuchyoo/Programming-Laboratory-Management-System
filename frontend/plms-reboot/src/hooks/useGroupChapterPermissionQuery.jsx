import { useQuery } from '@tanstack/react-query';
import { getGroupChapterPermission } from '@/utils/api';

const useGroupChapterPermissionQuery = (groupId) => {
  return useQuery({
    queryKey: ['labData', groupId],
    queryFn: () => getGroupChapterPermission(groupId)
  });
}

export default useGroupChapterPermissionQuery;