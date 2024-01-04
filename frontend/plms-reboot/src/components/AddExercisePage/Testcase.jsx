/* eslint-disable react/prop-types */
import { useEffect, useMemo, useState } from 'react';
import { Stack, Typography, TextField, FormControlLabel, IconButton, Grid, Button } from "@mui/material"
import RemoveCircleTwoToneIcon from '@mui/icons-material/RemoveCircleTwoTone';
import IosStyleSwitch from "@/components/_shared/IosStyleSwitch";
import { Controller } from "react-hook-form";
import TerminalBlock from "@/components/_shared/TerminalBlock";
import InputTerminalBlock from "@/components/_shared/InputTerminalBlock";
import { useFormContext, useFieldArray } from "react-hook-form";

const Testcase = ({ originalTestcase, realIndex, remove, editable, submitFn }) => {
  const { watch, control, handleSubmit } = useFormContext();
  const { append: appendRemovedList } = useFieldArray({ control, name: "removedList" });
  // Watch the specific fields
  const watchedTestcaseContent = watch(`testcase_list.${realIndex}.testcase_content`);
  const watchedTestcaseNote = watch(`testcase_list.${realIndex}.testcase_note`);
  const watchedShowToStudent = watch(`testcase_list.${realIndex}.show_to_student`);
  const watchedActive = watch(`testcase_list.${realIndex}.active`);
  const watchedError = watch(`testcase_list.${realIndex}.testcase_error`);
  const watchedTestcase = watch(`testcase_list.${realIndex}`);

  const [isDirty, setIsDirty] = useState(false);

  const handleRemove = (testcase_id) => {
    if (testcase_id) {
      appendRemovedList(testcase_id);
    }
    remove(realIndex);
  };

  useEffect(() => {
    if (!!originalTestcase) {
      const isChanged = originalTestcase.testcase_content !== watchedTestcaseContent ||
        originalTestcase.testcase_note !== watchedTestcaseNote ||
        originalTestcase.show_to_student !== watchedShowToStudent ||
        originalTestcase.active !== watchedActive;
      setIsDirty(isChanged);
    } else {
      setIsDirty(watchedTestcaseContent);
    }
  }, [watchedTestcaseContent, watchedTestcaseNote, watchedShowToStudent, watchedActive])

  return (
    <Stack>
      <Stack direction={"row"} spacing={"10px"} alignItems={"center"} justifyContent={"space-between"}
        sx={{
          bgcolor: "rgba(25, 44, 91, 0.50)",
          width: "100%",
          padding: "5px 10px",
          borderRadius: "8px 8px 0px 0px",
          flexWrap: "wrap"
        }}
      >
        <Stack direction={"row"} spacing={"10px"} alignItems={"center"} >
          <Typography>Testcase {realIndex + 1} :</Typography>
          <Controller
            name={`testcase_list.${realIndex}.testcase_note`}
            control={control}
            render={({ field }) => (
              <TextField size="small" type="text" disabled={!editable} value={field.value} onChange={field.onChange} label="Testcase name" />
            )}
          />

          <Controller
            name={`testcase_list.${realIndex}.show_to_student`}
            control={control}
            render={({ field }) => (
              <FormControlLabel
                value="show-to-student"
                control={
                  <IosStyleSwitch
                    disabled={!editable || !!watchedTestcase.testcase_error}
                    color="success"
                    checked={field.value === "yes"}
                    onChange={e => field.onChange(e.target.checked ? "yes" : "no")}
                  />
                }
                label="Show to student :"
                labelPlacement="start"
              />
            )}
          />

          <Controller
            name={`testcase_list.${realIndex}.active`}
            control={control}
            render={({ field }) => (
              <FormControlLabel
                value="use-for-marking"
                control={
                  <IosStyleSwitch
                    disabled={!editable || !!watchedTestcase.testcase_error}
                    color="success"
                    checked={field.value === "yes"}
                    onChange={e => field.onChange(e.target.checked ? "yes" : "no")}
                  />
                }
                label="Use for marking :"
                labelPlacement="start"
              />
            )}
          />
        </Stack>
        {editable &&
          <Stack direction='row' spacing="10px">
            <Button onClick={handleSubmit((data) => submitFn(data, realIndex))} variant="contained" type="submit" disabled={watchedError ? false : !isDirty} >Run</Button>
            <IconButton size="small" onClick={() => handleRemove(watchedTestcase.testcase_id)} >
              <RemoveCircleTwoToneIcon color="secondary" />
            </IconButton>
          </Stack>
        }
      </Stack>
      <Grid container spacing={"5px"} >
        <Grid item xs={12} md={6} >
          <Controller
            name={`testcase_list.${realIndex}.testcase_content`}
            control={control}
            render={({ field }) => (
              <InputTerminalBlock disabled={!editable} value={field.value} onChange={field.onChange} />
            )}
          />
        </Grid>
        <Grid item className="hide-cursor" xs={12} md={6}>
          {watchedTestcase.testcase_output ?
            <TerminalBlock text={watchedTestcase.testcase_output} />
            :
            <TerminalBlock text={watchedTestcase.testcase_error} error />
          }
        </Grid>
      </Grid>
    </Stack >
  )
}

export default Testcase;