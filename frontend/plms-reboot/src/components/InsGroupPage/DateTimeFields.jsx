/* eslint-disable react/prop-types */
import { Stack, Paper, Typography, Box } from '@mui/material'
/* import { DateTimeField } from '@mui/x-date-pickers' */
import { Controller } from 'react-hook-form'
import { DateTimePicker } from '@mui/x-date-pickers/DateTimePicker';
import { serverTimeOffsetAtom } from "@/store/store";
import { useAtom } from "jotai";
import useCurrentTime from "@/hooks/useCurrentTime";
import moment from 'moment';

const DateTimeFields = ({ prefix, control }) => {
  const [serverTimeOffset, setServerTimeOffset] = useAtom(serverTimeOffsetAtom);
  const currentTime = useCurrentTime();

  return (
    <Paper sx={{
      display: 'flex',
      flexDirection: 'column',
      padding: '20px',
      gap: '20px',
      justifyContent: "center",
      marginTop: "20px",
    }} >
      <Stack direction="row" justifyContent="center" alignItems="center" >
        <Box width="320px" padding="10px 10px 10px 12px" bgcolor="black" borderRadius="8px" whiteSpace="nowrap" >
          <Typography >Server Time: {currentTime.format('Do-MMM-YYYY HH:mm:ss')}</Typography>
        </Box>
      </Stack>
      <Stack direction="row" spacing={"10px"} alignItems="center">
        <Controller
          name={`${prefix}_time_start`}
          control={control}
          defaultValue={moment().add(serverTimeOffset, 'milliseconds').startOf('minute')}
          render={({ field }) => (
            <DateTimePicker
              label="Start date"
              size='small'
              format="YYYY-MM-DD HH:mm"
              value={field.value}
              onChange={field.onChange}
            />
          )}
        />

        <Controller
          name={`${prefix}_time_end`}
          control={control}
          defaultValue={moment().add(serverTimeOffset, 'milliseconds').startOf('minute')}
          render={({ field }) => (
            <DateTimePicker
              label="End date"
              size='small'
              format="YYYY-MM-DD HH:mm"
              value={field.value}
              onChange={field.onChange}
            />
          )}
        />
      </Stack>
    </Paper>


  )
}

export default DateTimeFields