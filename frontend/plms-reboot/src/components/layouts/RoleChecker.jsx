import { useState } from 'react'
import { useAtom } from "jotai";
import { userAtom } from "@/store/store";
import { Stack, Typography, Button, Modal } from "@mui/material";
import { modalStyle } from '@/utils';
import { useNavigate } from 'react-router-dom';
import { ABS_INS_URL, ABS_STU_URL } from '@/utils/constants/routeConst';

const RoleChecker = ({ role, children }) => {
  const [user,] = useAtom(userAtom);
  const navigate = useNavigate();
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleGoBackHome = () => {
    navigate(user.role === "supervisor" ? ABS_INS_URL.STATIC.MY_GROUPS : ABS_STU_URL.STATIC.HOME);
  }

  if (user.role !== role) {
    return (
      <Stack minHeight="100vh" justifyContent="center" alignItems="center" sx={{ borderRadius: "8px" }} >
        <Typography variant={"h4"} color="error" sx={{ textAlign: "center", fontWeight: "bold", marginTop: "20px" }} >You are not allowed to access this page</Typography>
        <Button variant="contained" sx={{ marginTop: "20px", fontSize: "20px" }} onClick={handleGoBackHome} >Go back</Button>
      </Stack>
    )
  } else {
    return <>{user && children}</>
  }
}

export default RoleChecker