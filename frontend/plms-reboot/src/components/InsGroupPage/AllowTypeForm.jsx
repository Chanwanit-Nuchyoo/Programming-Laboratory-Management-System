/* eslint-disable react/prop-types */
import { Stack, Box, Typography, FormControl, RadioGroup, FormControlLabel, Radio, Paper, Button } from "@mui/material";
import { useForm, Controller } from "react-hook-form";
import checked from '@/assets/images/allowsubmit.svg';
import { modalStyle } from '@/utils';
import TimerFields from "@/components/InsGroupPage/TimerFields";
import DateTimeFields from "@/components/InsGroupPage/DateTimeFields";
import { setChapterPermission } from "@/utils/api";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import moment from 'moment';

const AllowTypeForm = ({ lab, groupId, chapterId, prefix, title, open }) => {
  const queryClient = useQueryClient();

  const handleClose = (buttonType) => {
    if (buttonType === 'cancel') {
      reset();
      open(false); 
    } else if (buttonType === 'done') {
      open(false);
    }
  };

  const { mutate } = useMutation({
    mutationFn: setChapterPermission,
    onSuccess: () => {
      queryClient.invalidateQueries(['labData', groupId]);
      const ee = queryClient.getQueryData(['labData', groupId]);
      //console.log(ee)
      handleClose('done');
    },
    // Adding optimistic update
    onMutate: async (variables) => {
      const snapshot = queryClient.getQueryData(['labData', groupId]);
    
      // Create a copy of the object and update the item with the matching chapter_id
      const newData = { ...snapshot };
      const item = newData[variables.chapter_id];
    
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
    }
  })

  const { watch, handleSubmit, control, setValue, reset } = useForm({
    defaultValues: {
      'class_id': groupId,
      'chapter_id': chapterId,
      [`allow_${prefix}_type`]: lab[`allow_${prefix}_type`],
    }
  });
  const watchAllowType = watch(`allow_${prefix}_type`);

  const onSubmit = (data) => {
    let form = {
      class_id: data.class_id,
      chapter_id: data.chapter_id,
      prefix: prefix,
      [`allow_${prefix}_type`]: data[`allow_${prefix}_type`],
      [`${prefix}_time_start`]: null,
      [`${prefix}_time_end`]: null,
    };

    if (data[`allow_${prefix}_type`] === 'timer') {
      form[`${prefix}_time_start`] = moment().format('YYYY-MM-DD HH:mm:ss');
      form[`${prefix}_time_end`] = moment().add(data.hours, 'hours').add(data.minutes, 'minutes').add(data.seconds, 'seconds').format('YYYY-MM-DD HH:mm:ss');
    } else if (data[`allow_${prefix}_type`] === 'datetime') {
      form[`${prefix}_time_start`] = data[`${prefix}_time_start`].format('YYYY-MM-DD HH:mm:ss');
      form[`${prefix}_time_end`] = data[`${prefix}_time_end`].format('YYYY-MM-DD HH:mm:ss');
    }
    mutate(form);
  };

 

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <Stack spacing={"15px"} sx={modalStyle}>
        <Stack direction="row" spacing={"10px"} alignItems="center"  >
          <Box style={{ margin: 0 }}>
            <img src={checked} style={{ width: "36px", height: "36px", objectFit: "cover" }} alt="checked" />
          </Box>
          <Typography sx={{color: '#0CA6E9', fontSize: '20px', fontWeight: 'bold'}}>{title}</Typography>
        </Stack>
        <Controller
          name={`allow_${prefix}_type`}
          control={control}
          defaultValue={"always"}
          render={({ field }) => (
            <FormControl>
              <RadioGroup
                aria-label="type of allow access"
                value={field.value}
                onChange={field.onChange}
                name="access allow type"
                sx={{
                  '& > :not(style)': {
                    marginBottom: 0,
                    marginTop: 0
                  }
                }}
              >
                <FormControlLabel value="always" control={<Radio />} label="Always" />
                <FormControlLabel value="timer" control={<Radio />} label="Set timer" />
                <FormControlLabel value="datetime" control={<Radio />} label="Set date and time" />
                <FormControlLabel value="deny" control={<Radio />} label="Deny" />
              </RadioGroup>
            </FormControl>
          )}
        />
        {watchAllowType === "timer" && (
          <Paper sx={{
            display: 'flex',
            padding: '20px',
            justifyContent: "center",
            marginTop: "10px",
          }} >
            <TimerFields control={control} setValue={setValue} />
          </Paper>
        )}
        {watchAllowType === "datetime" && (
          <Paper sx={{
            display: 'flex',
            padding: '20px',
            justifyContent: "center",
            marginTop: "10px",
          }} >
            <DateTimeFields prefix={prefix} control={control} />
          </Paper>
        )}
        <Stack direction="row" justifyContent="flex-end" spacing={"5px"}>
          <Button onClick={() => handleClose('cancel')} variant="contained" sx={{ width: "100px", height: "40px", fontSize: "16px", textTransform: 'none', bgcolor: "var(--raven)", ":hover": { bgcolor: "#444" } }}>Cancel</Button>
          <Button type="submit" variant="contained" sx={{ width: "100px", height: "40px", fontSize: "16px", textTransform: 'none', }}>Done</Button>
        </Stack>
      </Stack>
    </form>
  );
};

export default AllowTypeForm;