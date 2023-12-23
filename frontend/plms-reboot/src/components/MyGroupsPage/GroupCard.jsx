import { Stack, Typography, Box, Button, Grid } from "@mui/material"
import PropTypes from 'prop-types';
import { dayColor } from "@/utils/constants/common";
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import { Link } from "react-router-dom";

const GroupCard = ({ id, groupNo, schedule, year, semester, department }) => {
  const day = schedule.split(",")[0];

  return (
    <Grid item xs={12} md={4}>
      <Stack spacing={3} sx={{
        bgcolor: "var(--biscay)",
        height: "fit-content",
        minHeight: "270px",
        borderRadius: "8px",
        padding: "30px 20px",
        transition: "all ease-in-out 0.2s"
      }}>
        <Typography variant="h4" color="primary">Group {groupNo}</Typography>
        <Box sx={{
          padding: "2px 25px",
          bgcolor: dayColor[day],
          borderRadius: "20px",
          width: "fit-content",
          color: "black"
        }}>{schedule}</Box>

        <Stack spacing={1}>
          <Stack direction="row" spacing="10px" alignItems="baseline" >
            <TypographyStack label="Year" value={year} />
            <TypographyStack label="Semester" value={semester} />
          </Stack>
          <TypographyStack label="Department" value={department} />
        </Stack>

        <Stack direction="row" spacing={2} sx={{ width: "100%" }}>
          <Link to={ABS_INS_URL.DYNAMIC.GROUP(id)}>
            <Button variant="contained" sx={{ borderRadius: "30px", padding: "7px 25px" }}>Exercise</Button>
          </Link>

          <Link to={ABS_INS_URL.DYNAMIC.STUDENT_LIST(id)}>
            <Button variant="contained" sx={{ borderRadius: "30px", padding: "7px 25px" }}>Student</Button>
          </Link>
        </Stack>
      </Stack>
    </Grid>
  );
};

const TypographyStack = ({ label, value }) => (
  <Stack direction="row" spacing={1}>
    <Typography color="primary">{label}:</Typography>
    <Typography>{value}</Typography>
  </Stack>
);

GroupCard.propTypes = {
  id: PropTypes.string.isRequired,
  groupNo: PropTypes.string.isRequired,
  schedule: PropTypes.string.isRequired,
  year: PropTypes.string.isRequired,
  semester: PropTypes.string.isRequired,
  department: PropTypes.string.isRequired,
};

TypographyStack.propTypes = {
  label: PropTypes.string.isRequired,
  value: PropTypes.string.isRequired,
};

export default GroupCard;