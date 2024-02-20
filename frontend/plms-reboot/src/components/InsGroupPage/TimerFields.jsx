/* eslint-disable react/prop-types */
import { Stack, TextField, Typography } from "@mui/material"
import { Controller } from "react-hook-form";

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
            InputLabelProps={{sx:{ fontSize: "20px" }}}
            inputProps={{ maxLength: 2, style: { height: '40px', width: '50px', textAlign: 'center', fontSize: "20px" } }}
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
            onChange={(event) => {
              let value = event.target.value;
              if (Number(value) > 60) {
                value = 59;
              }
              field.onChange(value);
            }}
            InputLabelProps={{sx:{ fontSize: "20px" }}}
            inputProps={{ maxLength: 2, style: { height: '40px', width: '50px', textAlign: 'center' , fontSize: "20px"} }}
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
            onChange={(event) => {
              let value = event.target.value;
              if (Number(value) > 60) {
                value = 59;
              }
              field.onChange(value);
            }}
            inputProps={{ maxLength: 2, style: { height: '40px', width: '50px', textAlign: 'center', fontSize: "20px" } }}
            InputLabelProps={{sx:{ fontSize: "20px" }}}
          />
        )}
      />
    </Stack>
  )
}

export default TimerFields