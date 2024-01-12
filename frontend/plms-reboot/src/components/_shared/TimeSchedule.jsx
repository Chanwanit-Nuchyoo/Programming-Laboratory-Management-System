import { dayColor } from "@/utils/constants/common"
import { Typography } from "@mui/material"
import PropTypes from 'prop-types';

const TimeSchedule = ({ classDate }) => {
  return (
    <Typography sx={{ borderRadius: "24px", bgcolor: dayColor[classDate.split(",")[0]] || "var(--raven)", color: "#0f1729", width: "fit-content", padding: "6px 20px", fontSize: "16px" }} >
      {classDate}
    </Typography>
  )
}

TimeSchedule.propTypes = {
  classDate: PropTypes.string.isRequired
}

export default TimeSchedule