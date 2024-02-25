import { Button, Checkbox, FormControlLabel, Paper, Stack, Typography, Divider } from '@mui/material'
import { useFormContext, Controller } from 'react-hook-form'
import PermissionText from '@/components/_shared/PermissionText';
import TimerFields from "@/components/InsGroupPage/TimerFields";

const TimerType = ({ prefix, type, lab, onSubmit }) => {
  const { handleSubmit, setValue, control } = useFormContext();

  return (
    <Paper sx={{
      display: 'flex',
      padding: '20px',
      justifyContent: "center",
      marginTop: "10px",
      flexDirection: "column",
      gap: "20px",
      alignItems: "center"
    }} >
      <Stack width="100%" spacing="20px" >
        {/* <Stack direction="row" width="100%" alignItems="center" justifyContent="space-around" >
          <Stack spacing="10px">
            <Stack direction="row" spacing="10px" >
              <Typography variant='caption2' width="120px">Allow access</Typography>
              <PermissionText prefix='access' type='timer' lab={lab} />
            </Stack>
            <Stack direction="row" spacing="10px" >
              <Typography variant='caption2' width="120px">Allow submit</Typography>
              <PermissionText prefix='submit' type='timer' lab={lab} />
            </Stack>
          </Stack>
          <Stack spacing="10px" >
            <Button variant={"outlined"} onClick={() => {
              setValue('minutes', 30)
              handleSubmit((data) => onSubmit(data))();
            }}
            >Pause both</Button>
          </Stack>
        </Stack>
      <Divider /> 
      <Stack direction="row" >
      </Stack>
      */}
        <Stack direction="row" width="100%" justifyContent="space-around" >
          <Stack spacing="20px" alignItems="center" justifyContent="center" >
            <TimerFields control={control} setValue={setValue} />
          </Stack>
          <Stack spacing="10px">
            <Button variant={"outlined"} onClick={() => {
              setValue('minutes', 5)
              handleSubmit((data) => onSubmit(data))();
            }}
            >Add 5 mins</Button>
            <Button variant={"outlined"} onClick={() => {
              setValue('minutes', 30)
              handleSubmit((data) => onSubmit(data))();
            }}
            >Add 30 mins</Button>
            <Button variant={"outlined"} onClick={() => {
              setValue('hours', 3)
              handleSubmit((data) => onSubmit(data))();
            }}
            >Add 3 hours</Button>
          </Stack>
        </Stack>
        {/* 
        <Divider />
        <Stack direction="row" alignItems="center" justifyContent="center" width="100%" >
          <Controller
            control={control}
            name="sync"
            render={({ field }) => (
              <FormControlLabel label={<Typography variant="caption2">Apply both access & submit</Typography>} control={<Checkbox checked={field.value} onChange={field.onChange} />} />
            )}
          />
        </Stack> 
        */}
      </Stack>
    </Paper>
  )
}

export default TimerType