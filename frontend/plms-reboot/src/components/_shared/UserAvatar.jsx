import avatarPlaceholder from "@/assets/images/avatarplaceholder.png";
import classes from "@/assets/css/UserAvatar.module.css";
import {
  usePopupState,
  bindTrigger,
  bindMenu,
} from 'material-ui-popup-state/hooks'
import { getClassNames } from "@/utils";
import { Avatar, Menu, Stack, Typography, MenuItem, ListItemIcon } from "@mui/material";
import { useAtom } from "jotai";
import { userAtom } from "@/store/store";
import { useMutation } from "@tanstack/react-query";
import AccountBoxIcon from '@mui/icons-material/AccountBox';
import LogoutIcon from '@mui/icons-material/Logout';
import { logout } from "@/utils/api";
import { useNavigate } from "react-router-dom";
import { COMMON_URL } from "@/utils/constants/routeConst";

const UserAvatar = () => {
  const [user, setUser] = useAtom(userAtom);
  const navigate = useNavigate();
  const userMenuState = usePopupState({ variant: 'popover', popupId: 'userMenu' })

  const logoutMutation = useMutation({
    mutationFn: logout,
    onSuccess: () => {
      setUser(null);
      navigate(COMMON_URL.STATIC.SIGNIN);
    }
  });

  const handleLogout = () => {
    userMenuState.close();
    logoutMutation.mutate();
  }

  const handleProfileClicked = () => {
    userMenuState.close();
    navigate(COMMON_URL.DYNAMIC.PROFILE(user.id));
  }

  return (
    <Stack direction={"row"} className={getClassNames(classes, "user-avatar-container")} >
      {user ? (
        <Stack spacing={"5px"} height={"100%"} className={getClassNames(classes, "text-container")}>
          <Typography className={getClassNames(classes, "role")} >{user.role.charAt(0).toUpperCase() + user.role.slice(1)}</Typography>
          <Typography className={getClassNames(classes, "username")}>{user.username}</Typography>
        </Stack>
      ) : (
        <Typography variant="body1" className={getClassNames(classes, "placeholder-text")}>
          Guest User
        </Typography>
      )}
      <Stack
        sx={{
          cursor: "pointer",
          "&:hover": {
            opacity: 0.8
          },
        }}
      >
        <Avatar {...bindTrigger(userMenuState)} className={getClassNames(classes, "avatar-image")} src={user ? `${import.meta.env.VITE_BASE_URL}/${user.avatar}` : avatarPlaceholder} alt={user ? user.name : "Guest User"} sx={{ width: 60, height: 60 }} />
        <Menu
          anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
          transformOrigin={{ vertical: 'top', horizontal: 'right' }}
          {...bindMenu(userMenuState)}
        >
          <MenuItem onClick={handleProfileClicked}>
            <ListItemIcon sx={{ marginRight: 0 }} >
              <AccountBoxIcon />
            </ListItemIcon>
            <Typography variant="inherit">Profile</Typography>
          </MenuItem>
          <MenuItem onClick={handleLogout}>
            <ListItemIcon sx={{ marginRight: 0 }} >
              <LogoutIcon />
            </ListItemIcon>
            <Typography variant="inherit">Logout</Typography>
          </MenuItem>
        </Menu>
      </Stack>
    </Stack>
  );
};

export default UserAvatar;
