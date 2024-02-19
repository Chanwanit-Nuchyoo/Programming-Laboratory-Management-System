import { Box, InputAdornment, Stack, TextField, Button } from "@mui/material"
//import logo from '@/assets/images/logo2.png'
import logologin from '@/assets/images/logologin.svg'
import userIcon from '@/assets/images/usericon.svg'
import lockpadIcon from '@/assets/images/lockpadicon.svg'
import axios from "axios";
import { useNavigate } from "react-router";
import { useAtom } from 'jotai';
import { userAtom } from '@/store/store';
import { useEffect } from "react";
import { PREFIX } from "@/utils/constants/routeConst";
import { useForm, Controller } from "react-hook-form"

const SignIn = () => {
  const navigate = useNavigate()
  const [user, setUser] = useAtom(userAtom);
  const { control, handleSubmit, formState: { errors } } = useForm({
    defaultValues: {
      username: "",
      password: "",
    },
  })

  useEffect(() => {
    if (user) {
      navigate(PREFIX[user.role])
    }
  }, [navigate, user])

  const onSubmit = async (data) => {
    try {
      const response = await axios.post(import.meta.env.VITE_BACKEND_BASE_URL + "/index.php/auth_rest/login", {
        ...data
      }, { withCredentials: true });

      // Set userAtom with the user data returned from the server
      if (response.data.status) {
        setUser(response.data.payload);
      }
    } catch (error) {
      console.log(error)
      // Set error message in the errors object of react-hook-form
      alert(error.response.data.message)
      setUser(null);
    }
  }
  // hi
  return (
    <Stack direction="row">

      <Box sx={{
        display: "flex", padding: "0px 120px", flexDirection: "column", justifyContent: "center", alignItems: "flex-start", gap: "50px",
        alignSelf: "stretch", height: "100vh", borderRadius: "0px 50px 50px 0px", bgcolor: "var(--biscay)"
      }}>
        <Box>
          <img src={logologin} alt="logologin" />
        </Box>
        <Box sx={{ display: "flex", flexDirection: "column", gap: "10px", color: "var(--cerulean)", fontSize: "60px", fontFamily: "Anton" }}>
          COMPUTER<br />PROGRAMMING LAB<br />PYTHON
        </Box>
      </Box>

      <Box sx={{ display: "grid", placeItems: "center", width: "56%", height: "100vh" }}>
        <form onSubmit={handleSubmit(onSubmit)}>
          <Stack width={460} padding="30px" spacing={"40px"} >
            <Box sx={{ className: "flex-start" }} >
              <h2>Wellcome Back !</h2>
            </Box>
            <Stack width={"100%"} spacing={"30px"} >
              <Controller
                name="username"
                control={control}
                rules={{ required: 'Username is required.' }}
                render={({ field }) => (
                  <TextField
                    {...field}
                    size="small"
                    label={"Username"}
                    type="text"
                    error={!!errors.username}
                    helperText={errors.username ? errors.username.message : ""}
                    sx={{ height: "48px" }} // Add fixed height to prevent shifting
                    InputProps={{
                      startAdornment: (
                        <InputAdornment position="start" sx={{ color: "white" }} >
                          <img src={userIcon} width="25" height="25" />
                        </InputAdornment>
                      )
                    }}
                  />
                )}
              />
              <Controller
                name="password"
                control={control}
                rules={{ required: 'Password is required.' }}
                render={({ field }) => (
                  <TextField
                    {...field}
                    className="passwordField"
                    variant="outlined"
                    //color="primary"
                    size="small"
                    label={"Password"}
                    type="password"
                    error={!!errors.password}
                    helperText={errors.password ? errors.password.message : ""}
                    sx={{ height: "48px" }} // Add fixed height to prevent shifting
                    InputProps={{
                      startAdornment: (
                        <InputAdornment position="start" sx={{ color: "white" }} >
                          <img src={lockpadIcon} width="25" height="25" />
                        </InputAdornment>
                      ),
                    }}
                  />
                )}
              />
            </Stack>
            <Box className="flex-center">
              <Button type="submit" variant="contained" color="primary"
                sx={{ height: '40px', width: '400px', fontSize: '16px', borderRadius: '24px' }}>Sign in</Button>
            </Box>
          </Stack>
        </form>
      </Box>

    </Stack>
  )
}

export default SignIn