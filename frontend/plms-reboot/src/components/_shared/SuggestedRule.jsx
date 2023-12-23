/* eslint-disable react/prop-types */
import { Stack, TextField, FormControl, IconButton } from "@mui/material"
import { Controller } from 'react-hook-form'
import AddCircleTwoToneIcon from '@mui/icons-material/AddCircleTwoTone';

const SuggestedRule = ({ editable, index, control, name, append, getValues }) => {

  const handleAddToUserDefined = () => {
    const value = getValues(`${name}.${index}`);

    const newRule = {
      active: true,
      keyword: value.keyword,
      type: "eq",
      limit: value.limit,
    }

    return newRule
  }

  return (
    <Stack direction={'row'} spacing={1} sx={{ paddingLeft: "20px" }} >
      <Stack direction={"row"} spacing={1}>
        <Controller
          name={`${name}.${index}.keyword`}
          control={control}
          render={({ field: { value } }) => (
            <TextField disabled type="text" size="small" value={value} sx={{
              width: "250px",
              "& .MuiInputBase-input.Mui-disabled": {
                WebkitTextFillColor: "#000000",
              },
            }} />
          )}
        />
        <Controller
          name={`${name}.${index}.limit`}
          control={control}
          render={({ field: { value } }) => (
            <FormControl>
              <Stack spacing={1} >
                <Stack direction={"row"} spacing={1} >
                  <TextField
                    disabled
                    type="text"
                    size="small"
                    value={value}
                    sx={{ width: "55px" }}
                  />
                </Stack>
              </Stack>
            </FormControl>
          )}
        />
      </Stack>
      {editable && <IconButton onClick={() => { append(handleAddToUserDefined()) }}>
        <AddCircleTwoToneIcon color="success" />
      </IconButton>}
    </Stack>
  )
}

export default SuggestedRule