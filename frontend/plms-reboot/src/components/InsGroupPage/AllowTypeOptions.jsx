import { FormControl, FormControlLabel, Radio, RadioGroup } from '@mui/material'

const AllowTypeOptions = ({ field }) => {
  return (
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
  )
}

export default AllowTypeOptions