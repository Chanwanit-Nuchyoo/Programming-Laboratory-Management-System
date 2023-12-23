/* eslint-disable react/prop-types */
import { Stack, Typography, TextField, FormControlLabel, Switch, Button, Grid } from "@mui/material"
import { Controller } from "react-hook-form";
import TerminalBlock from "@/components/_shared/TerminalBlock";
import InputTerminalBlock from "@/components/_shared/InputTerminalBlock";

const Testcase = ({ index, control, editable }) => {
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
          <Typography>Testcase {index + 1} :</Typography>
          <Controller
            name={`testcases.${index}.testcase_note`}
            control={control}
            render={({ field }) => (
              <TextField size="small" type="text" disabled={!editable} value={field.value} onChange={field.onChange} label="Testcase name" />
            )}
          />

          <Controller
            name={`testcases.${index}.show_to_student`}
            control={control}
            render={({ field }) => (
              <FormControlLabel
                value="show-to-student"
                control={
                  <Switch
                    disabled={!editable}
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
            name={`testcases.${index}.active`}
            control={control}
            render={({ field }) => (
              <FormControlLabel
                value="use-for-marking"
                control={
                  <Switch
                    disabled={!editable}
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
          <Button variant='contained' size='midium' sx={{
            paddingX: "25px",
            borderRadius: "8px",
            bgcolor: "var(--cerulean )",
            textTransform: "none",
            flexShrink: "0",
          }} >Run</Button>}
      </Stack>
      <Grid container spacing={"5px"} >
        <Grid item xs={12} md={6} >
          <Controller
            name={`testcases.${index}.testcase_content`}
            control={control}
            render={({ field }) => (
              <InputTerminalBlock disabled={!editable} value={field.value} onChange={field.onChange} />
            )}
          />
        </Grid>
        <Grid item className="hide-cursor" xs={12} md={6}>
          <Controller
            name={`testcases.${index}.testcase_output`}
            control={control}
            render={({ field }) => (
              <TerminalBlock text={field.value} />
            )}
          />
        </Grid>
      </Grid>
    </Stack >
  )
}

export default Testcase