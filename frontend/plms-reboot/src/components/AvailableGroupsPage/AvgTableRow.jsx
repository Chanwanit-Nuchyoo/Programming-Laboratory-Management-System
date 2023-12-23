import { Grid, Typography } from "@mui/material";
import PropTypes from 'prop-types';

import TimeSchedule from "@/components/_shared/TimeSchedule";

const AvgTableRow = ({
  groupId,
  groupNo,
  year,
  semester,
  classDate,
  students,
  instructor
}) => {
  return (
    <Grid container sx={{ minHeight: "26px", padding: "15px 0px", background: "var(--biscay)", borderRadius: "8px", cursor: "pointer", ":hover": { bgcolor: "var(--hover)" } }}>
      <Grid item lg={1.5} className="flex-center" sx={{ padding: "0px 2.5px" }} >
        <Typography>{groupId}</Typography>
      </Grid>
      <Grid item md={1.5} className="flex-center" sx={{ padding: "0px 2.5px" }} >
        <Typography>{groupNo}</Typography>
      </Grid>
      <Grid item md={1.5} className="flex-center" sx={{ padding: "0px 2.5px" }} >
        <Typography>{year}</Typography>
      </Grid>
      <Grid item md={1.5} className="flex-center" sx={{ padding: "0px 2.5px" }} >
        <Typography>{semester}</Typography>
      </Grid>
      <Grid item md={3} className="flex-center" sx={{ padding: "0px 2.5px" }} >
        <TimeSchedule classDate={classDate} />
      </Grid>
      <Grid item md={1} className="flex-center" sx={{ padding: "0px 2.5px" }} >
        <Typography>
          {students}
        </Typography>
      </Grid>
      <Grid item md={2} className="flex-start" sx={{ padding: "0px 2.5px" }} >
        <Typography sx={{ textAlign: 'center', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{instructor}</Typography>
      </Grid>
    </Grid>
  )
};

AvgTableRow.propTypes = {
  groupId: PropTypes.string.isRequired,
  groupNo: PropTypes.string.isRequired,
  year: PropTypes.string.isRequired,
  semester: PropTypes.string.isRequired,
  classDate: PropTypes.string.isRequired,
  students: PropTypes.number.isRequired,
  instructor: PropTypes.string.isRequired,
};

export default AvgTableRow;
