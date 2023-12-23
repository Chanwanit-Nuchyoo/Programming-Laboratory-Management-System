/* eslint-disable react/prop-types */
import { FormControl, InputLabel, MenuItem, Select, TextField } from "@mui/material";
import { Controller, useFormContext } from "react-hook-form";
import Section from "@/components/EditProfilePage/Section";

const MyTextField = ({ name, rules, label, type = "text", ...props }) => {
  const { control, formState: { errors } } = useFormContext();

  return (
    <Controller
      name={name}
      control={control}
      rules={rules}
      render={({ field }) => (
        <TextField
          variant="outlined"
          size="small"
          label={label}
          type={type}
          value={field.value}
          onChange={field.onChange}
          error={!!errors[name]}
          helperText={errors[name] ? errors[name].message : ""}
          {...props}
        />
      )}
    />
  );
}

const ContactForm = ({ isDepLoading, departments }) => {
  const { control } = useFormContext();

  return (
    <Section title="Contact">
      <Controller
        name={`department`}
        control={control}
        render={({ field }) => (
          <FormControl fullWidth>
            <InputLabel size="small" id="department-label">Department</InputLabel>
            <Select
              labelId="department-label"
              id="department"
              label="Department"
              size="small"
              onChange={field.onChange}
              value={field.value}
              MenuProps={{
                PaperProps: {
                  style: {
                    maxHeight: '500px',  // Set the max height
                    overflow: 'auto'    // Set overflow to auto
                  },
                },
              }}
            >
              <MenuItem value="" disabled sx={{ display: "none" }} ></MenuItem>
              {!isDepLoading && departments && departments.map((dep, index) =>
                <MenuItem key={index} value={dep.dept_name}>{dep.dept_name}</MenuItem>)
              }
            </Select>
          </FormControl>
        )}
      />
      <MyTextField
        name="email"
        control={control}
        rules={{
          pattern: {
            value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i,
            message: 'Invalid email address'
          }
        }}
        label="Email"
      />
      <MyTextField
        name="tel"
        control={control}
        rules={{
          validate: value =>
            value === "" || /^[0-9]{10}$/.test(value) || 'Invalid phone number, must be 10 digits'
        }}
        label="Phone Number"
        inputProps={{ inputMode: 'numeric', pattern: '[0-9]*' }}
        onKeyPress={(event) => {
          if (!/[0-9]/.test(event.key)) {
            event.preventDefault();
          }
        }}
      />
    </Section>
  )
}

export default ContactForm