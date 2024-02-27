/* eslint-disable react/prop-types */
import { Stack, Box, Typography, Button, FormControlLabel, Checkbox } from "@mui/material";
import { useForm, Controller, FormProvider } from "react-hook-form";
import { serverTimeOffsetAtom } from "@/store/store";
import { useAtom } from "jotai";
import { modalStyle } from '@/utils';
import checked from '@/assets/images/allowsubmit.svg';
import DateTimeFields from "@/components/InsGroupPage/DateTimeFields";
import useChapterPermissionMutation from '@/hooks/useChapterPermissionMutation';
import AllowTypeOptions from "@/components/InsGroupPage/AllowTypeOptions";
import TimerType from "@/components/InsGroupPage/TimerType";
import moment from 'moment';

const buttonProps = {
  size: 'medium',
  sx: { paddingX: "10px" },
  variant: 'contained',
};

const buttonStyle = {
  width: '180px',
  height: '40px',
  fontSize: '16px',
  borderRadius: '24px',
  border: 'solid 2px'
}

const AllowTypeForm = ({ lab, groupId, chapterId, prefix, title, open }) => {
  const [serverTimeOffset, setServerTimeOffset] = useAtom(serverTimeOffsetAtom);

  const handleClose = (buttonType) => {
    if (buttonType === 'cancel') {
      reset();
      open(false);
    } else if (buttonType === 'done') {
      open(false);
    }
  };

  const { mutate } = useChapterPermissionMutation(groupId, open);

  const allowTypeForm = useForm({
    defaultValues: {
      'class_id': groupId,
      'chapter_id': chapterId,
      [`allow_${prefix}_type`]: lab[`allow_${prefix}_type`],
      sync: false,
    }
  });

  const { watch, handleSubmit, control, getValues, reset, formState } = allowTypeForm;

  const watchAllowType = watch(`allow_${prefix}_type`);

  const formatDate = (date) => date.format('YYYY-MM-DD HH:mm:ss');

  const onSubmit = (data) => {
    const form = {
      class_id: data.class_id,
      chapter_id: data.chapter_id,
      prefix: prefix,
      [`allow_${prefix}_type`]: data[`allow_${prefix}_type`],
      [`${prefix}_time_start`]: null,
      [`${prefix}_time_end`]: null,
      sync: data.sync,
    };

    const currentTime = moment().add(serverTimeOffset, 'milliseconds');

    if (data[`allow_${prefix}_type`] === 'timer') {
      form[`${prefix}_time_start`] = formatDate(currentTime);
      form[`${prefix}_time_end`] = formatDate(currentTime.add(moment.duration(getValues("hours"), "hours")).add(moment.duration(getValues("minutes"), "minutes")).add(moment.duration(getValues("seconds"), "seconds")));
    } else if (data[`allow_${prefix}_type`] === 'datetime') {
      form[`${prefix}_time_start`] = formatDate(data[`${prefix}_time_start`]);
      form[`${prefix}_time_end`] = formatDate(data[`${prefix}_time_end`]);
    }
    mutate(form);
  };

  const addTime = (data) => {
    const form = {
      class_id: data.class_id,
      chapter_id: data.chapter_id,
      prefix: prefix,
      [`allow_${prefix}_type`]: data[`allow_${prefix}_type`],
      [`${prefix}_time_start`]: null,
      [`${prefix}_time_end`]: null,
      sync: data.sync,
    };

    const currentTime = moment().add(serverTimeOffset, 'milliseconds');

    if (data[`allow_${prefix}_type`] === 'timer') {
      if (lab[`${prefix}_time_start`] && lab[`${prefix}_time_end`]) {
        const startTime = moment(lab[`${prefix}_time_start`])
        const endTime = moment(lab[`${prefix}_time_end`]);
        const isBetween = (currentTime.isBetween(startTime, endTime));

        if (!isBetween) {
          form[`${prefix}_time_start`] = formatDate(currentTime);
          form[`${prefix}_time_end`] = formatDate(currentTime.add(moment.duration(getValues("hours"), "hours")).add(moment.duration(getValues("minutes"), "minutes")).add(moment.duration(getValues("seconds"), "seconds")));
        } else {
          form[`${prefix}_time_start`] = formatDate(startTime);
          form[`${prefix}_time_end`] = formatDate(endTime.add(moment.duration(getValues("hours"), "hours")).add(moment.duration(getValues("minutes"), "minutes")).add(moment.duration(getValues("seconds"), "seconds")));
        }
      } else {
        form[`${prefix}_time_start`] = formatDate(currentTime);
        form[`${prefix}_time_end`] = formatDate(currentTime.add(moment.duration(getValues("hours"), "hours")).add(moment.duration(getValues("minutes"), "minutes")).add(moment.duration(getValues("seconds"), "seconds")));
      }
    }
    mutate(form);
  }

  return (
    <form>
      <FormProvider {...allowTypeForm} >
        <Stack spacing={"15px"} sx={modalStyle}>
          <Stack direction="row" spacing={"10px"} alignItems="center"  >
            <Box style={{ margin: 0 }}>
              <img src={checked} style={{ width: "36px", height: "36px", objectFit: "cover" }} alt="checked" />
            </Box>
            <Typography sx={{ color: '#0CA6E9', fontSize: '20px', fontWeight: 'bold' }}>{title}</Typography>
          </Stack>
          <Controller
            name={`allow_${prefix}_type`}
            control={control}
            defaultValue={"always"}
            render={({ field }) => <AllowTypeOptions field={field} />}
          />
          {watchAllowType === "timer" && (
            <TimerType prefix={prefix} onSubmit={addTime} lab={lab} />
          )}
          {watchAllowType === "datetime" && (
            <DateTimeFields prefix={prefix} control={control} />
          )}
          <Stack direction="row" justifyContent="space-between" spacing={"5px"}>
            <Controller
              control={control}
              name="sync"
              render={({ field }) => (
                <FormControlLabel label={<Typography variant="caption2">Sync Acceses & Submit</Typography>} control={<Checkbox checked={field.value} onChange={field.onChange} />} />
              )}
            />
            <Stack direction="row" spacing="5px" >
              <Button onClick={() => handleClose('cancel')} variant="contained" sx={{ width: "100px", height: "40px", fontSize: "16px", textTransform: 'none', bgcolor: "var(--raven)", ":hover": { bgcolor: "#444" } }}>Cancel</Button>
              <Button
                type="submit"
                onClick={handleSubmit(onSubmit)}
                variant="contained"
                disabled={!formState.isDirty}
                sx={{ width: "100px", height: "40px", fontSize: "16px", textTransform: 'none', }}>Done</Button>
            </Stack>
          </Stack>
        </Stack>
      </FormProvider>
    </form>
  );
};

export default AllowTypeForm;