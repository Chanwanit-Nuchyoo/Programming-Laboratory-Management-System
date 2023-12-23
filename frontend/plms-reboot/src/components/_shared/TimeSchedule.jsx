import { dayColor } from "@/utils/constants/common"
import { Typography } from "@mui/material"
import PropTypes from 'prop-types';

const TimeSchedule = ({ classDate }) => {
  return (
    <Typography sx={{ borderRadius: "30px", bgcolor: dayColor[classDate.split(",")[0]] || "var(--raven)", color: "black", width: "fit-content", paddingX: "25px" }} >
      {classDate}
    </Typography>
  )
}

TimeSchedule.propTypes = {
  classDate: PropTypes.string.isRequired
}

export default TimeSchedule