/* eslint-disable react/prop-types */
import { Stack, TextField, Typography } from "@mui/material"
import { Controller } from "react-hook-form"
const TimerFields = ({ control }) => {
  return (
    <Stack direction="row" spacing={"10px"} alignItems="center">
      <Controller
        name={`hours`}
        control={control}
        defaultValue="00"
        render={({ field }) => (
          <TextField
            value={field.value || ''}
            size='small'
            label="HH"
            onChange={field.onChange}
            inputProps={{ maxLength: 2 }}
            sx={{ width: '50px' }}
          />
        )}
      />
      <Typography variant="h6">:</Typography>
      <Controller
        name="minutes"
        control={control}
        defaultValue="00"
        render={({ field }) => (
          <TextField
            value={field.value}
            size='small'
            label="MM"
            onChange={field.onChange}
            inputProps={{ maxLength: 2 }}
            sx={{ width: '50px' }}
          />
        )}
      />
      <Typography variant="h6">:</Typography>
      <Controller
        name="seconds"
        control={control}
        defaultValue="00"
        render={({ field }) => (
          <TextField
            value={field.value}
            size='small'
            label="SS"
            onChange={field.onChange}
            inputProps={{ maxLength: 2 }}
            sx={{ width: '50px' }}
          />
        )}
      />
    </Stack>
  )
}

export default TimerFields