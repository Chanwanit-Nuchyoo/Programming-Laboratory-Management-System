/* eslint-disable no-unused-vars */
import { Typography, Button, Menu, MenuItem, FormControlLabel, FormGroup, Checkbox, Link } from "@mui/material"
import Grid from '@mui/material/Unstable_Grid2';
import UnfoldMoreIcon from '@mui/icons-material/UnfoldMore';
import {
  usePopupState,
  bindTrigger,
  bindMenu,
} from 'material-ui-popup-state/hooks'
import { SemesterOptions, ClassDateOptions } from '@/utils'
import { dayColor } from "@/utils/constants/common";
import { useState, useCallback } from "react";
import PropTypes from 'prop-types'

const menuStyle = {
  border: "1px solid rgba(255, 255, 255, 0.10)",
  background: "rgba(0, 0, 0, 0.30)",
  backdropFilter: "blur(35px)",
}

const AvgTableHead = ({
  selectedSemester,
  selectedClassDate,
  selectedInstructor,
  setSelectedSemester,
  setSelectedClassDate,
  setSelectedInstructor,
  instructorOptions
}) => {
  const [semesterOptions,] = useState(SemesterOptions);
  const [classDateOptions,] = useState(ClassDateOptions);
  const semesterPopupState = usePopupState({ variant: 'popover', popupId: 'semesterMenu' })
  const classDatePopupState = usePopupState({ variant: 'popover', popupId: 'classDateMenu' })
  const instructorPopupState = usePopupState({ variant: 'popover', popupId: 'instructorMenu' })

  const toggleCheckbox = useCallback((setState, value) => {
    setState((prevState) => {
      const newState = new Set(prevState);
      if (newState.has(value)) {
        newState.delete(value);
      } else {
        newState.add(value);
      }
      return newState;
    });
  }, []);

  return (
    <Grid container sx={{
      display: { xs: "none", md: "flex" },
      position: "sticky",
      top: "0px",
      bgcolor: "var(--ebony)"
    }} >
      <Grid lg={1.5} className="flex-center table-head-column" sx={{ padding: "0px 2.5px" }} >
        <Button fullWidth variant="outlined" sx={{ color: "white" }} >Group ID</Button>
      </Grid>
      <Grid md={1.5} className="flex-center table-head-column" sx={{ padding: "0px 2.5px" }} >
        <Button fullWidth variant="outlined" sx={{ color: "white" }}  >Group</Button>
      </Grid>
      <Grid md={1.5} className="flex-center table-head-column" sx={{ padding: "0px 2.5px" }} >
        <Button fullWidth variant="outlined" sx={{ color: "white" }}  >Year</Button>
      </Grid>
      <Grid md={1.5} className="flex-center table-head-column" sx={{ padding: "0px 2.5px" }} >
        <Button fullWidth variant="outlined" sx={{ color: "white" }}  {...bindTrigger(semesterPopupState)} endIcon={<UnfoldMoreIcon />} >Semester</Button>
        <Menu {...bindMenu(semesterPopupState)} slotProps={{ paper: { style: menuStyle } }} >
          <FormGroup padding={"10px"} sx={{ width: "100%" }} >
            <MenuItem>
              <Link variant="contained" color="primary" onClick={() => { setSelectedSemester(new Set()) }} >Uncheck All</Link>
            </MenuItem>
            {[...semesterOptions].map((semester) => (
              <MenuItem key={semester}>
                <FormControlLabel
                  sx={{ width: "100%" }}
                  control={
                    <Checkbox
                      checked={selectedSemester.has(semester)}
                      onChange={() => toggleCheckbox(setSelectedSemester, semester)}
                    />
                  }
                  label={semester}
                />
              </MenuItem>
            ))}
          </FormGroup>
        </Menu>
      </Grid>
      <Grid md={3} className="flex-center table-head-column" sx={{ padding: "0px 2.5px" }} >
        <Button fullWidth variant="outlined" sx={{ color: "white" }}  {...bindTrigger(classDatePopupState)} endIcon={<UnfoldMoreIcon />} >Class date</Button>
        <Menu {...bindMenu(classDatePopupState)} slotProps={{ paper: { style: menuStyle } }} >
          <FormGroup sx={{ width: "100%" }}>
            <MenuItem>
              <Link variant="contained" color="primary" onClick={() => { setSelectedClassDate(new Set()) }} >Uncheck All</Link>
            </MenuItem>
            {[...classDateOptions].map(classDate =>
              <MenuItem key={classDate}>
                <FormControlLabel
                  sx={{ width: "100%" }}
                  control={<Checkbox />}
                  checked={selectedClassDate.has(classDate)}
                  onChange={() => toggleCheckbox(setSelectedClassDate, classDate)}
                  label={(
                    <Typography sx={{
                      borderRadius: "30px",
                      bgcolor: dayColor[classDate],
                      color: "black",
                      width: "100px",
                      display: 'flex',
                      justifyContent: "center",
                      alignItems: "center"
                    }}
                    >
                      {classDate}
                    </Typography>)}
                />
              </MenuItem>
            )}
          </FormGroup>
        </Menu>
      </Grid>
      <Grid md={1} className="flex-center table-head-column" sx={{ padding: "0px 2.5px" }} >
        <Button fullWidth variant="outlined" sx={{ color: "white" }}  >Students</Button>
      </Grid>
      <Grid md={2} className="flex-center table-head-column" sx={{ padding: "0px 2.5px" }} >
        <Button fullWidth variant="contained" {...bindTrigger(instructorPopupState)} endIcon={<UnfoldMoreIcon />} >Instructor</Button>
        <Menu {...bindMenu(instructorPopupState)} slotProps={{ paper: { style: menuStyle } }} >
          <FormGroup sx={{ width: "100%" }}>
            <MenuItem>
              <Link variant="contained" color="primary" onClick={() => { setSelectedInstructor(new Set()) }} >Uncheck All</Link>
            </MenuItem>
            {[...instructorOptions].map(i =>
              <MenuItem key={i}>
                <FormControlLabel
                  sx={{ width: "100%" }}
                  control={<Checkbox />}
                  label={i}
                  checked={selectedInstructor.has(i)}
                  onChange={() => toggleCheckbox(setSelectedInstructor, i)}
                />
              </MenuItem>)}
          </FormGroup>
        </Menu>
      </Grid>
    </Grid>
  )
}

AvgTableHead.propTypes = {
  selectedSemester: PropTypes.instanceOf(Set).isRequired,
  selectedClassDate: PropTypes.instanceOf(Set).isRequired,
  selectedInstructor: PropTypes.instanceOf(Set).isRequired,
  instructorOptions: PropTypes.instanceOf(Set).isRequired,
  setSelectedSemester: PropTypes.func.isRequired,
  setSelectedClassDate: PropTypes.func.isRequired,
  setSelectedInstructor: PropTypes.func.isRequired,

}

export default AvgTableHead