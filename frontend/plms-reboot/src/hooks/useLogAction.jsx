import { useMutation } from "@tanstack/react-query";
import { logAction } from "@/utils/api";

const useLogAction = (onSuccess) => {
  const logActionMutation = useMutation({
    mutationFn: logAction,
    onSuccess: () => {
      onSuccess && onSuccess();
    },
    onError: () => {
      onError && onError();
    }
  });
  return logActionMutation;
}

export default useLogAction;