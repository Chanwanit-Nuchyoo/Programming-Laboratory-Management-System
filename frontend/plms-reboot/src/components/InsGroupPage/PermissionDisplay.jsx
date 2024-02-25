import { useState } from 'react';
import { Box, IconButton, Modal, Stack } from '@mui/material'
import { checkIsAccessible } from "@/utils";
import AccessAlarmIcon from '@mui/icons-material/AccessAlarm';
import ToggleSwitch from '@/components/InsGroupPage/ToggleSwitch';
import PermissionText from '@/components/_shared/PermissionText';
import AllowTypeForm from '@/components/InsGroupPage/AllowTypeForm';
import useCurrentTime from '@/hooks/useCurrentTime';
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { setChapterPermission } from "@/utils/api";
import useChapterPermissionMutation from '@/hooks/useChapterPermissionMutation';
import moment from 'moment';


const PermissionDisplay = ({ prefix, permissions, groupId, chapterId, lab }) => {
  const currentTime = useCurrentTime();
  const queryClient = useQueryClient();
  const [isModalOpen, setIsModalOpen] = useState(false);

  const isAccessible = !!checkIsAccessible(permissions.allow_access_type, currentTime, moment(permissions.access_time_start), moment(permissions.access_time_end));
  const isSubmitAble = !!checkIsAccessible(permissions.allow_submit_type, currentTime, moment(permissions.submit_time_start), moment(permissions.submit_time_end));

  const isChecked = prefix === 'access' ? isAccessible : isSubmitAble;

  const { mutate } = useChapterPermissionMutation(groupId, setIsModalOpen);

  const handleToggleSwitch = () => {
    let sync = !isAccessible;

    if (prefix === 'access') {
      sync = false;
    }

    let form = {
      class_id: groupId,
      chapter_id: chapterId,
      prefix: prefix,
      [`allow_${prefix}_type`]: isChecked ? "deny" : "always",
      [`${prefix}_time_start`]: null,
      [`${prefix}_time_end`]: null,
      sync: sync
    };

    mutate(form);
  }

  return (
    <Stack direction={"row"} spacing={"20px"} justifyContent="flex-start" alignItems="center" paddingX="16px">
      <ToggleSwitch
        isChecked={isChecked}
        onToggle={() => handleToggleSwitch()}
      />
      <Stack alignItems="flex-start" >
        <PermissionText prefix={prefix} type={permissions[`allow_${prefix}_type`]} lab={lab} isInsPage={true} />
      </Stack>
      <Box display="flex" flexGrow={1} justifyContent="flex-end" alignItems="center">
        <IconButton onClick={() => setIsModalOpen(true)}>
          <AccessAlarmIcon color="primary" />
        </IconButton>
        <Modal
          open={isModalOpen}
          onClose={() => setIsModalOpen(false)}
        >
          <Box>
            <AllowTypeForm lab={lab} groupId={groupId} chapterId={chapterId} prefix={prefix} title={`Allow ${prefix} exercise`} open={setIsModalOpen} isAccessible={isAccessible} />
          </Box>
        </Modal>
      </Box>
    </Stack>
  )
}

export default PermissionDisplay