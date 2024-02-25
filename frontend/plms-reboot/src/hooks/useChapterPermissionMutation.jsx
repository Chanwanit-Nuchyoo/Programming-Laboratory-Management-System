import { setChapterPermission } from "@/utils/api";
import { useMutation, useQueryClient } from "@tanstack/react-query";

export default function useChapterPermissionMutation(groupId, setIsModalOpen) {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: setChapterPermission,
    onSuccess: () => {
      queryClient.invalidateQueries(['labData', groupId]);
      setIsModalOpen(false);
    },
    /* onMutate: async (variables) => {
      const snapshot = queryClient.getQueryData(['labData', groupId]);
      const newData = { ...snapshot };
      const item = newData[variables.chapter_id];
      item.access_time_end = variables.access_time_end;
      item.access_time_start = variables.access_time_start;

      if (item) {
        newData[variables.chapter_id] = {
          ...item,
          ...(variables.prefix === 'access' ? { allow_access_type: variables.allow_access_type } : { allow_submit_type: variables.allow_submit_type }),
        };
      }

      queryClient.setQueryData(['labData', groupId], newData);
      return { snapshot };
    },
    onError: (error, variables, context) => {
      queryClient.setQueryData(['labData', groupId], () => context?.snapshot);
    },
    onSettled: () => {
      queryClient.invalidateQueries(['labData', groupId]);
    } */
  });


  /* I don't know if i would need this part in the future so i put it here */

  //     /* onMutate: async (variables) => {
  //       const snapshot = queryClient.getQueryData(['labData', groupId]);

  //       // Create a copy of the object and update the item with the matching chapter_id
  //       const newData = { ...snapshot };
  //       const item = newData[variables.chapter_id];
  //       item[`${variables.prefix}_time_end`] = variables[`${variables.prefix}_time_end`];
  //       item[`${variables.prefix}_time_start`] = variables[`${variables.prefix}_time_start`];

  //       if (item) {
  //         newData[variables.chapter_id] = {
  //           ...item,
  //           ...(variables.prefix === 'access' ? { allow_access_type: variables.allow_access_type } : { allow_submit_type: variables.allow_submit_type }),
  //         };
  //       }

  //       // Optimistically update the query data
  //       queryClient.setQueryData(['labData', groupId], newData);

  //       // Return a context object with the snapshot for backup plan
  //       return { snapshot };
  //     },
  //     onError: (error, variables, context) => {
  //       console.log(error);
  //       queryClient.setQueryData(['labData', groupId], () =>context?.snapshot);
  //     },
  //     onSettled: () => {
  //       queryClient.invalidateQueries(['labData', groupId]);
  //     } */
};