import { useAtom } from "jotai"
import { userAtom } from "../store/store"
import { Navigate } from "react-router-dom"

const FirstPage = () => {
  const [user,] = useAtom(userAtom);

  if (!user) {
    return <Navigate to="/signin" />
  } else {
    switch (user.role) {
      case 'supervisor':
        return <Navigate to="/ins" />
      case 'ta':
        return <Navigate to="/ins" />
      /* case 'student':
        return <Navigate to="/stu" /> */
    }
  }
}

export default FirstPage