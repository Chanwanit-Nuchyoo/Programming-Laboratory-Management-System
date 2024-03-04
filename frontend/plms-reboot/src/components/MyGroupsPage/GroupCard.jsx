import { Stack, Typography, Box, Button, Avatar } from "@mui/material"
import PropTypes from 'prop-types';
import { dayColor } from "@/utils/constants/common";
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import { Link } from "react-router-dom";
import folderIcon from '@/assets/images/foldericon.svg';
import EditIcon from '@mui/icons-material/Edit';

const GroupCard = ({ id, groupNo, schedule, year, semester, department }) => {
  const day = schedule.split(",")[0];

  return (
    <div style={{
      flex: '0 0 calc(100% / 3 - 10px)',  
      maxWidth: 'calc(33.3333%)' 
    }}>
      <Stack spacing={3} sx={{
        bgcolor: "var(--biscay)",
        height: "fit-content",
        //minHeight: "270px",
        borderRadius: "16px",
        padding: "30px",
        transition: "all ease-in-out 0.2s"
      }}>
        
        <div style={{ display: 'flex', alignItems: 'center', gap: '10px'}}>
            <div style={{ display: 'flex', flexDirection: 'row' }}>
                <Avatar alt="Folder Icon" src={folderIcon} sx={{ width: 32, height: 32, marginRight: '8px' }} />
                <Typography fontSize="24px" color="white" style={{ marginBottom: '0', paddingBottom: '0' }}>Group {groupNo}</Typography>
            </div>
            <Link to={ABS_INS_URL.DYNAMIC.EDITGROUP(id)}>
                <EditIcon/>
            </Link>
        </div>

        <Box sx={{
          padding: "6px 20px",
          bgcolor: dayColor[day],
          borderRadius: "24px",
          width: "fit-content",
          color: "#0f1729",
          
        }}>{schedule}</Box>

        <Stack spacing={1}>
          <Stack direction="row" sx={{ width: "100%", justifyContent: "start", flexWrap: "wrap", gap: "1rem"}} >
            <TypographyStack label="Year" value={year} />
            <TypographyStack label="Semester" value={semester} />
          </Stack>
          <TypographyStack label="Department" value={department} />
        </Stack>

        <Stack direction="row" sx={{ width: "100%", justifyContent: "start", flexWrap: "wrap", gap: "1rem"}}>
          <Link to={ABS_INS_URL.DYNAMIC.GROUP(id)}>
            <Button variant="contained" 
            sx={{ borderRadius: "24px", padding: "6px 26px", textTransform: 'none', fontSize: "16px", minWidth: "120px"}}>Exercise</Button>
          </Link>

          <Link to={ABS_INS_URL.DYNAMIC.STUDENT_LIST(id)}>
            <Button variant="contained" 
            sx={{ borderRadius: "24px", padding: "6px 26px", textTransform: 'none', fontSize: "16px", minWidth: "120px" }}>Student </Button>
          </Link>
        </Stack>
      </Stack>
      </div>
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