import React from 'react';
import { Button, Box, TextField, Stack } from "@mui/material";
import { Controller, useForm ,FormProvider} from "react-hook-form";
import { FormControl, InputLabel, Select, MenuItem } from "@mui/material";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { getAllDepartment } from "@/utils/api";
import { editGroup } from "@/utils/api";
import { useAtom } from "jotai";
import { userAtom } from "@/store/store";
import { TimePicker } from '@mui/x-date-pickers/TimePicker';
import moment from 'moment';
import { useNavigate } from 'react-router-dom';
import { ABS_INS_URL } from "@/utils/constants/routeConst";

const AddGroupForm = ({form}) => {
  if (form) {
    if (form.time_start) {
      form.time_start = moment(form.time_start, 'HH:mm:ss');
    }
    if (form.time_end) {
      form.time_end = moment(form.time_end, 'HH:mm:ss');
    }
  }
  const navigate = useNavigate();
  const { control, handleSubmit, formState: { errors } ,reset} = useForm({
    defaultValues: form
  });
  const [user] = useAtom(userAtom);
  const queryClient = useQueryClient();
  const boxStyle = {
    padding: "20px",
    border: "1px solid var(--raven)",
    borderRadius: "8px",
    flex: "1",
  };

  const { data: departments, isLoading: isDepLoading } = useQuery({
    queryKey: ['departments'],
    queryFn: getAllDepartment,
  })

  const {mutate :editGroupMutation} = useMutation({
    mutationFn:editGroup,
    onSuccess: () =>{
      queryClient.invalidateQueries('groupdata');
      navigate(ABS_INS_URL.STATIC.MY_GROUPS);
      reset();
    },
    onError: (err) => {
        alert(err.response.data.message)
        reset();
      }
  })

  const renderTextField = (name, label, type = "text", rules = {}, disabled = false) => (
    <Controller
      name={name}
      control={control}
      rules={rules}
      render={({ field }) => (
        <TextField
          InputLabelProps={type === 'time' ? { shrink: true } : {}}
          label={label}
          value={field.value || ''}
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

  const renderSelectField = (name, label, options, rules = {}, disabled = false, id,labelId) => (
    <Controller
      name={name}
      control={control}
      rules={rules}
      render={({ field }) => (
        <FormControl sx={{ flex: 1 }}>
          <InputLabel id ={labelId} >{label}</InputLabel>
          <Select
            labelId = {labelId}
            id ={id}
            value={field.value || ''}
            onChange={field.onChange}
            disabled={disabled}
            error={!!errors[name]}
          >
            {options.map((option, index) => (
              <MenuItem key={index} value={option}>
                {option}
              </MenuItem>
            ))}
          </Select>
        </FormControl>
      )}
    />
  );
  const renderDepartmentSelectField = (name, label, options, rules = {}, disabled = false, id, labelId) => (
    <Controller
      name={name}
      control={control}
      rules={rules}
      render={({ field }) => (
        <FormControl sx={{ flex: 1 }}>
          <InputLabel id={labelId}>{label}</InputLabel>
          <Select
            labelId={labelId}
            id={id}
            value={field.value || ''}
            onChange={field.onChange}
            disabled={disabled}
            error={!!errors[name]}
          >
            {options.map((option, index) => (
              <MenuItem key={index} value={option.dept_id}>
                {option.dept_name}
              </MenuItem>
            ))}
          </Select>
        </FormControl>
      )}
    />
  );

  const renderTimePicker = (name, label, rules = {}, disabled = false) => (
    <Controller
      name={name}
      control={control}
      rules={rules}
      render={({ field }) => (
        <TimePicker sx={{ flex: 1 }}
          label={label}
          value={field.value || null}
          onChange={(newValue) => {
            field.onChange(newValue);
          }}
          disabled={disabled}
          error={!!errors[name]}
          renderInput={(params) => <TextField {...params} />}
        />
      )}
    />
  );

  const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

  const onSubmit = (data) => {
    data.lecturer = user.id;
    data.time_start = data.time_start.format('HH:mm:ss');
    data.time_end = data.time_end.format('HH:mm:ss');
    editGroupMutation(data);
  };
  return (
      <Box sx={boxStyle}>
        <form autoComplete="off" onSubmit={handleSubmit(onSubmit)}>
        <Stack direction={'row'} spacing="10px" sx={{ mb: 2 }}>
          {renderTextField(`group_name`, "Group Name*", "text", { required: 'Group name is required' }, false)}
        </Stack>
        <Stack direction={'row'} spacing="10px" sx={{ mb: 2 }}>
        {renderTextField(`group_id`, "GroupId*", "text", { required: 'groupId is required'}, true)}
        {renderTextField(`group_no`, "Group No*", "text", { required: 'Group No is required', pattern: { value: /^[0-9]*$/, message: 'Only numbers are allowed' } }, false)}
        </Stack>
        <Stack direction={'row'} spacing="10px" sx={{ mb: 2 }}>
        {isDepLoading ? (<p>Loading...</p>) : (
          renderDepartmentSelectField(`department`, "Department", departments, { required: 'Department is required' }, false, "department", "department-label")
        )}
          {renderSelectField(`day_of_week`, "Day of Week*", daysOfWeek, { required: 'Day of Week is required' }, false,
          "dayofweek","dayofweek-label")}
        </Stack>
        <Stack direction={'row'} spacing="10px" sx={{ mb: 2 }}>
          {renderTimePicker(`time_start`, "TimeStart*", { required: 'time_start is required' }, false)}
          {renderTimePicker(`time_end`, "TimeEnd", { required: 'time_end is required' }, false)}
        </Stack>
        <Stack direction={'row'} spacing="10px" sx={{ mb: 2 }}>
          {renderTextField(`year`, "Year*", "text", { required: 'Year is required', pattern: { value: /^[0-9]{4}$/, message: 'Year must be exactly 4 digits' } }, false)}
          {renderSelectField(`semester`, "Semester", [1, 2, 3], { required: 'Semester is required' }, false,
          "semester","semester-label")}
        </Stack>  
            <Button type="submit" variant="contained" color="primary">
            Submit
            </Button>
        </form>
      </Box>
  );
};

export default AddGroupForm;