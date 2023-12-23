import { useState } from "react";
import { Stack, Typography, Button } from "@mui/material"
import { buttonStyle } from "@/utils";
import StyledButton from "@/components/_shared/StyledButton";
import AssignmentTurnedInIcon from '@mui/icons-material/AssignmentTurnedIn';
import EventIcon from '@mui/icons-material/Event';
import EventAvailableIcon from '@mui/icons-material/EventAvailable';
import EventBusyIcon from '@mui/icons-material/EventBusy';

const menus = [
  { title: 'Upcoming', value: 'upcoming', icon: <EventIcon sx={{ color: "var(--cerulean)" }} /> },
  { title: 'Completed', value: 'completed', icon: <EventAvailableIcon sx={{ color: "var(--emerald)" }} /> },
  { title: 'Not Completed', value: 'not_completed', icon: <EventBusyIcon sx={{ color: "#F44336" }} /> },
]

const Assignments = () => {
  const [selectedMenu, setSelectedMenu] = useState('upcoming')
  const item_no = 0;

  const message = {
    'upcoming': 'You don\'t have any upcoming exercise.',
    'completed': 'You don\'t have any completed exercise.',
    'not_completed': 'You don\'t have any not completed exercise.',
  }

  return (
    <Stack spacing="10px" padding="20px" bgcolor={"var(--biscay)"} borderRadius="8px" >
      <Stack direction="row" spacing="10px" alignItems="center" >
        <AssignmentTurnedInIcon />
        <Typography variant="h6" >Assignments</Typography>
      </Stack>
      <Stack direction="row" spacing="10px">
        {menus.map((menu, index) => (
          <StyledButton
            key={index}
            isactive={selectedMenu === menu.value}
            onClick={() => setSelectedMenu(menu.value)}
            variant="outlined"
            startIcon={menu.icon}
            sx={{
              paddingX: "20px"
            }}
          >
            <Typography>{menu.title}</Typography>
          </StyledButton>
        )
        )}
      </Stack>

      <Stack>
        <table style={{ position: "sticky", left: "80px", zIndex: "10" }}>
          <thead>
            <tr>
              <th style={{ width: "250px" }} className="table-head-column" >
                <Button fullWidth sx={buttonStyle}>
                  <Typography>Chapter</Typography>
                </Button>
              </th>
              <th style={{ width: "150px" }} className="table-head-column" >
                <Button fullWidth sx={buttonStyle}>
                  <Typography>Allow submit</Typography>
                </Button>
              </th>
              <th style={{ width: "50px" }} className="table-head-column" >
                <Button fullWidth sx={buttonStyle}>
                  <Typography>Score</Typography>
                </Button>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
            </tr>
          </tbody>
        </table>
        {item_no === 0 &&
          <Stack justifyContent='center' marginTop='5px' alignItems='center' bgcolor={'rgba(255, 255, 255, 0.20)'} borderRadius="8px" height={200}  >
            <Typography>{message[selectedMenu]}</Typography>
          </Stack>
        }
      </Stack>
    </Stack>
  )
}

export default Assignments