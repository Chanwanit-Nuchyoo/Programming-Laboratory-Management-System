/* eslint-disable react/prop-types */
import { Avatar, Box, FormControl, FormControlLabel, FormLabel, Grid, IconButton, Radio, RadioGroup, Stack, TextField, Typography } from "@mui/material";
import { Controller, useFormContext } from "react-hook-form";
import Section from "@/components/EditProfilePage/Section";
import { styled } from "@mui/system"
import { DatePicker } from "@mui/x-date-pickers";
import EditIcon from '@mui/icons-material/Edit';

const StyledDatePicker = styled(DatePicker)({
  '& svg, & path': {
    color: 'white',
    fill: 'white',
  }
});

const PersonalInfoForm = ({ formData }) => {
  const { control, formState: { errors } } = useFormContext();

  const handlePreview = value => typeof value === "string" ? `${import.meta.env.VITE_BASE_URL}/${value}` : URL.createObjectURL(value);

  const renderTextField = (name, label, type = "text", rules = {}, disabled = false) => (
    <Controller
      name={name}
      control={control}
      rules={rules}
      render={({ field }) => (
        <TextField
          size="small"
          label={label}
          value={field.value}
          onChange={field.onChange}
          disabled={disabled}
          type={type}
          sx={{ flex: 1 }}
          error={!!errors[name]}
          helperText={errors[name] ? errors[name].message : ""}
        />
      )}
    />
  );

  return (
    <Grid item xs={12} md={6}>
      <Section height="100%">
        <Stack className="flex-center">
          <Box position='relative'>
            <Controller
              name={`avatar`}
              control={control}
              render={({ field: { value, onChange, ...field } }) => (
                <>
                  <Avatar alt={formData.firstname} src={handlePreview(value)} sx={{ width: "150px", height: "150px" }} />
                  <input {...field} value={value?.fileName} onChange={e => onChange(e.target.files[0])} type="file" id="avatar" style={{ display: 'none' }} />
                  <label htmlFor="avatar">
                    <IconButton component="span" sx={{ position: 'absolute', bottom: 0, right: 0, backgroundColor: 'var(--cerulean)', color: 'white', '&:hover': { backgroundColor: 'var(--cerulean)' } }}>
                      <EditIcon />
                    </IconButton>
                  </label>
                </>
              )}
            />
          </Box>
        </Stack>
        <Typography variant="h5">Personal Information</Typography>
        <Stack direction={'row'} spacing="10px">
          {renderTextField(`firstname`, "First Name*", "text", { required: 'First name is required' }, true)}
          {renderTextField(`lastName`, "Last Name*", "text", { required: 'Last name is required' }, true)}
        </Stack>
        <Stack direction={'row'} spacing="10px">
          {renderTextField(`nickname`, "Nickname")}
          <Controller
            name={`dob`}
            control={control}
            render={({ field }) => (
              <StyledDatePicker
                label="Date of Birth"
                slotProps={{ textField: { size: 'small' } }}
                sx={{ flex: 1 }}
                value={field.value}
                format="YYYY/MM/DD"
                onChange={field.onChange}
              />
            )}
          />
        </Stack>
        <Controller
          name={`gender`}
          control={control}
          defaultValue=""
          render={({ field }) => (
            <FormControl>
              <FormLabel id="gender-label">Gender</FormLabel>
              <RadioGroup row aria-labelledby="gender-label" name="gender" value={field.value} onChange={field.onChange}>
                <FormControlLabel value="male" control={<Radio />} label="Male" />
                <FormControlLabel value="female" control={<Radio />} label="Female" />
                <FormControlLabel value="other" control={<Radio />} label="Other" />
              </RadioGroup>
            </FormControl>
          )}
        />
      </Section>
    </Grid>
  )
}

export default PersonalInfoForm