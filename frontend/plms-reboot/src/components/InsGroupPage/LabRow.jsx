/* eslint-disable react/prop-types */
import { useState } from 'react';
import { Stack, Switch, Typography, Modal, Link as MuiLink, Box } from "@mui/material"
import { Link } from 'react-router-dom';
import { ABS_INS_URL } from '@/utils/constants/routeConst';
import AllowTypeForm from '@/components/InsGroupPage/AllowTypeForm';
import PermissionText from '@/components/_shared/PermissionText';
import useCurrentTime from '@/hooks/useCurrentTime'
import { checkIsAccessible } from '@/utils';
import moment from 'moment';
const LabRow = ({ lab, groupId, groupNo }) => {
  const [isAccessModalOpen, setIsAccessModalOpen] = useState(false);
  const [isSubmitModalOpen, setIsSubmitModalOpen] = useState(false);
  const [isAccessSwitchOn, setIsAccessSwitchOn] = useState(false);
  const [isSubmitSwitchOn, setIsSubmitSwitchOn] = useState(false);
  const currentTime = useCurrentTime();

  return (
    <Stack direction={"row"} padding="10px" bgcolor="var(--biscay)" borderRadius="8px" >
      <Stack flex={1} justifyContent="center" >
        <MuiLink to={ABS_INS_URL.DYNAMIC.CHAPTER(groupId, lab.chapter_id)} component={Link} color={'inherit'} underline='none' sx={{ ":hover": { color: "var(--blueRibbon)" } }} >
          <Typography>{lab.chapter_id}. {lab.chapter_name} ({lab.no_items})</Typography>
        </MuiLink>
      </Stack>
      <Stack width={100} justifyContent="center" alignItems="center" >
        <Typography>{lab.chapter_fullmark}</Typography>
      </Stack>
      <Stack width={300} direction={"row"} spacing={"20px"} justifyContent="flex-start" alignItems="center" paddingX="30px" >
        <Switch
          color="success"
          checked={!!checkIsAccessible(lab.allow_access_type, currentTime, moment(lab.access_time_start), moment(lab.access_time_end))}
          onClick={() => setIsAccessModalOpen(true)}
        />
        <Modal
          open={isAccessModalOpen}
          onClose={() => setIsAccessModalOpen(false)}
        >
          <Box>
            <AllowTypeForm lab={lab} groupId={groupId} chapterId={lab.chapter_id} prefix="access" title="Allow access exercise" open={setIsAccessModalOpen} />
          </Box>
        </Modal>
        <Stack>
          <PermissionText prefix='access' type={lab.allow_access_type} lab={lab} isInsPage={true} />
        </Stack>
      </Stack>
      <Stack width={300} direction={"row"} spacing={"20px"} justifyContent="flex-start" alignItems="center" paddingX="30px">
        <Switch
          color="success"
          checked={!!checkIsAccessible(lab.allow_submit_type, currentTime, moment(lab.submit_time_start), moment(lab.submit_time_end))}
          onClick={() => setIsSubmitModalOpen(true)}
        />
        <Modal
          open={isSubmitModalOpen}
          onClose={() => setIsSubmitModalOpen(false)}
        >
          <Box>
            <AllowTypeForm lab={lab} groupId={groupId} chapterId={lab.chapter_id} prefix='submit' title="Allow submit exercise" open={setIsSubmitModalOpen} />
          </Box>
        </Modal>
        <Stack >
          <PermissionText prefix='submit' type={lab.allow_submit_type} lab={lab} isInsPage={true} />
        </Stack>
      </Stack>
    </Stack>
  )
}

export default LabRow;
