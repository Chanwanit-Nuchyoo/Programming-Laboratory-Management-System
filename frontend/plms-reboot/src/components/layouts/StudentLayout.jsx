import { Outlet } from "react-router-dom";
import { Box } from "@mui/system";
import ServerTimeDisplay from "@/components/_shared/ServerTimeDisplay";
import Sidebar from "@/components/_shared/Sidebar";
import UserAvatar from "@/components/_shared/UserAvatar"

const RootLayout = () => {
  return (
    <>
      <Sidebar />
      <Box marginLeft={10} paddingX={4} paddingY={2} minHeight={"100vh"} position={"relative"} >
        <ServerTimeDisplay />
        <UserAvatar />
        <Box paddingTop={"10px"} >
          <Outlet />
        </Box>
      </Box>
      <footer></footer>
    </>
  )
}

export default RootLayout