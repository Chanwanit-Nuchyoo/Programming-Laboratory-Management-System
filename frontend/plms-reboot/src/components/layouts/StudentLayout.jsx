import { Outlet } from "react-router-dom";
import Sidebar from "@/components/_shared/Sidebar";
import UserAvatar from "@/components/_shared/UserAvatar"
import { Box } from "@mui/system";

const RootLayout = () => {
  return (
    <>
      <Sidebar />
      <Box marginLeft={10} paddingX={4} paddingY={2} minHeight={"100vh"} position={"relative"} >
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