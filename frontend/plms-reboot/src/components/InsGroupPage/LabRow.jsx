/* eslint-disable react/prop-types */
import { useState } from 'react';
import { Stack, Typography, Modal, Link as MuiLink, Box } from "@mui/material"
import { Link } from 'react-router-dom';
import { ABS_INS_URL } from '@/utils/constants/routeConst';
import AllowTypeForm from '@/components/InsGroupPage/AllowTypeForm';
import PermissionText from '@/components/_shared/PermissionText';
import useCurrentTime from '@/hooks/useCurrentTime'
import { checkIsAccessible } from '@/utils';
import moment from 'moment';
import ToggleSwitch from '@/components/InsGroupPage/ToggleSwitch';
import AccessAlarmIcon from '@mui/icons-material/AccessAlarm';
import IconButton from '@mui/material/IconButton';
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { setChapterPermission } from "@/utils/api";
import { useForm ,FormProvider} from "react-hook-form";

const LabRow = ({ lab, groupId, groupNo }) => {
  const [isAccessModalOpen, setIsAccessModalOpen] = useState(false);
  const [isSubmitModalOpen, setIsSubmitModalOpen] = useState(false);
  //const [isAccessSwitchOn, setIsAccessSwitchOn] = useState(false);
  //const [isSubmitSwitchOn, setIsSubmitSwitchOn] = useState(false);
  const queryClient = useQueryClient();
  const currentTime = useCurrentTime();

  const { mutate }  = useMutation({
    mutationFn:setChapterPermission,
    onSuccess: () => {
      queryClient.invalidateQueries(['labData', groupId]);
      const ee = queryClient.getQueryData(['labData', groupId]);
    },
    /* onMutate: async (variables) => {
      const snapshot = queryClient.getQueryData(['labData', groupId]);
    
      // Create a copy of the object and update the item with the matching chapter_id
      const newData = { ...snapshot };
      const item = newData[variables.chapter_id];
      item[`${variables.prefix}_time_end`] = variables[`${variables.prefix}_time_end`];
      item[`${variables.prefix}_time_start`] = variables[`${variables.prefix}_time_start`];
    
      if (item) {
        newData[variables.chapter_id] = {
          ...item,
          ...(variables.prefix === 'access' ? { allow_access_type: variables.allow_access_type } : { allow_submit_type: variables.allow_submit_type }),
        };
      }
    
      // Optimistically update the query data
      queryClient.setQueryData(['labData', groupId], newData);
    
      // Return a context object with the snapshot for backup plan
      return { snapshot };
    },
    onError: (error, variables, context) => {
      console.log(error);
      queryClient.setQueryData(['labData', groupId], () =>context?.snapshot);
    },
    onSettled: () => {
      queryClient.invalidateQueries(['labData', groupId]);
    } */
  })

  const handleToggleSwitch = (prefix, class_id, chapter_id)=> {
    let form = {
      class_id: class_id,
      chapter_id: chapter_id,
      prefix: prefix,
      [`allow_${prefix}_type`]: !!checkIsAccessible(lab[`allow_${prefix}_type`], currentTime, moment(lab[`${prefix}_time_start`]), moment(lab[`${prefix}_time_end`])) ? "deny": "always",
      [`${prefix}_time_start`]: null,
      [`${prefix}_time_end`]: null,
    };

    mutate(form);
  }
  return (
    <Stack direction={"row"} padding="10px" bgcolor="var(--biscay)" borderRadius="8px" >
      <Stack flex={1} justifyContent="center" >
        <MuiLink to={ABS_INS_URL.DYNAMIC.CHAPTER(groupId, lab.chapter_id)} component={Link} color={'inherit'} underline='none' sx={{ ":hover": { color: "var(--blueRibbon)" } }} >
          <Typography style={{ paddingLeft: '20px' }}>{lab.chapter_id}. {lab.chapter_name} ({lab.no_items})</Typography>
        </MuiLink>
      </Stack>
      <Stack width={100} justifyContent="center" alignItems="center" >
        <Typography>{lab.chapter_fullmark}</Typography>
      </Stack>
      
      <Stack width={335} direction={"row"} spacing={"20px"} justifyContent="flex-start" alignItems="center" paddingX="16px" >
        <ToggleSwitch
          isChecked={!!checkIsAccessible(lab.allow_access_type, currentTime, moment(lab.access_time_start), moment(lab.access_time_end))}
          onToggle={()=> handleToggleSwitch("access", lab.class_id, lab.chapter_id)}
        />
        <Stack>
          <PermissionText prefix='access' type={lab.allow_access_type} lab={lab} isInsPage={true} />
        </Stack>
        <Box display="flex" flexGrow={1} justifyContent="flex-end" alignItems="center">
        <IconButton onClick={() => setIsAccessModalOpen(true)}>
          <AccessAlarmIcon color="primary"/>
        </IconButton>
        <Modal
          open={isAccessModalOpen}
          onClose={() => setIsAccessModalOpen(false)}
        >
          <Box>
            <AllowTypeForm lab={lab} groupId={groupId} chapterId={lab.chapter_id} prefix="access" title="Allow access exercise" open={setIsAccessModalOpen} />
          </Box>
        </Modal>
        </Box>
        
      </Stack>
      
      <Stack width={335} direction={"row"} spacing={"20px"} justifyContent="flex-start" alignItems="center" paddingX="16px">
        <ToggleSwitch
          isChecked={!!checkIsAccessible(lab.allow_submit_type, currentTime, moment(lab.submit_time_start), moment(lab.submit_time_end))}
          onToggle={() => handleToggleSwitch("submit", lab.class_id, lab.chapter_id)}
        />
        <Stack >
          <PermissionText prefix='submit' type={lab.allow_submit_type} lab={lab} isInsPage={true} />
        </Stack>
        <Box display="flex" flexGrow={1} justifyContent="flex-end" alignItems="center">
        <IconButton onClick={() => setIsSubmitModalOpen(true)}>
          <AccessAlarmIcon color="primary"/>
        </IconButton>
        <Modal
          open={isSubmitModalOpen}
          onClose={() => setIsSubmitModalOpen(false)}
        >
          <Box>
            <AllowTypeForm lab={lab} groupId={groupId} chapterId={lab.chapter_id} prefix='submit' title="Allow submit exercise" open={setIsSubmitModalOpen} />
          </Box>
        </Modal>
        </Box>
      </Stack>
    </Stack>
  )
}

export default LabRow;
