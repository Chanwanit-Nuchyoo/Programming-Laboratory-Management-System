/* eslint-disable react/prop-types */
import { Stack, TextField, FormControl, IconButton, Checkbox, Box, Select, MenuItem, InputLabel } from "@mui/material"
import RemoveCircleTwoToneIcon from '@mui/icons-material/RemoveCircleTwoTone';
import { Controller } from "react-hook-form";

const UserDefinedRule = ({ editable, index, control, name, remove, getValues }) => {

  const singleLimitFields = ["me", "le", "eq"];

  return (
    <Stack direction={"row"}>
      <Stack direction={"row"} spacing={1}>
        <Controller
          name={`${name}.${index}.active`}
          control={control}
          render={({ field: { value, onChange } }) => (
            <Checkbox
              inputProps={{ "aria-label": "checkbox" }}
              checked={value}
              onChange={onChange}
              sx={{
                '&.Mui-disabled': {
                  color: "var(--raven)",
                },
                height: "40px"
              }}
            // disabled={() => { }}
            />
          )}
        />

        <Controller
          name={`${name}.${index}.keyword`}
          control={control}
          render={({ field: { value, onChange } }) => (
            <TextField disabled={!editable} type="text" size="small" label="keyword" sx={{ width: "140px" }} value={value} onChange={onChange} />
          )}
        />

        <Controller
          name={`${name}.${index}.type`}
          control={control}
          render={({ field: { value, onChange } }) => (
            <Box width={"200px"} sx={{ textAlign: "center" }}>
              <FormControl size="small" fullWidth>
                <InputLabel id="con-type">Type</InputLabel>
                <Select
                  labelId="con-type"
                  label="Type"
                  value={value}
                  sx={{ textAlign: "left" }}
                  onChange={onChange}
                  disabled={!editable}
                >
                  <MenuItem value={"eq"} sx={{ ":hover": { bgcolor: "var(--hover)" } }} >= Equal</MenuItem>
                  <MenuItem value={"me"} sx={{ ":hover": { bgcolor: "var(--hover)" } }} >≥ More than or equal</MenuItem>
                  <MenuItem value={"le"} sx={{ ":hover": { bgcolor: "var(--hover)" } }} >≤ Less than or equal</MenuItem>
                  <MenuItem value={"na"} sx={{ ":hover": { bgcolor: "var(--hover)" } }} >✕ Not appear</MenuItem>
                </Select>
              </FormControl>
            </Box>
          )}
        />

        <Controller
          name={`${name}.${index}.limit`}
          control={control}
          render={({ field: { value, onChange } }) => {
            const type = getValues(`${name}.${index}.type`)

            return (
              <FormControl>
                <Stack spacing={1} >
                  <Stack direction={"row"} spacing={1} >
                    {singleLimitFields.includes(type) && (
                      <TextField
                        disabled={!editable}
                        type="number"
                        size="small"
                        label="Limit"
                        value={value || ""}
                        onChange={onChange}
                        sx={{ width: "65px" }}
                      />
                    )}
                  </Stack>
                </Stack>
              </FormControl>
            )
          }}
        />
        {editable && <IconButton size="small" onClick={editable ? () => { remove(index) } : () => { }} >
          <RemoveCircleTwoToneIcon color="secondary" />
        </IconButton>}
      </Stack>
    </Stack>
  )
}

export default UserDefinedRule