import { useEffect } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useAtom } from 'jotai';
import { userAtom } from '@/store/store';
import { COMMON_URL } from "@/utils/constants/routeConst";
import PropTypes from 'prop-types';

const ONE_MINUTE = 60000; // 1 minute in milliseconds

// This component is used to check if the user is logged in or not
const ProtectedRoute = ({ children }) => {
  const [user, setUser] = useAtom(userAtom);
  const navigate = useNavigate();

  useEffect(() => {
    const performLoginCheck = async () => {
      try {
        const response = await axios.get(import.meta.env.VITE_BACKEND_BASE_URL + "/index.php/auth_rest/logged_in_check", { withCredentials: true });
        if (response.data.status) {
          /* setUser(response.data.payload);
          localStorage.setItem('user', JSON.stringify(response.data.payload)); */
        } else {
          setUser(null);
          /* localStorage.removeItem('user'); */
          navigate(COMMON_URL.STATIC.SIGNIN);
        }
      } catch (error) {
        console.error("Failed to perform login check:", error);
        setUser(null);
        /* localStorage.removeItem('user'); */
        navigate(COMMON_URL.STATIC.SIGNIN);
      }
    };

    // Initial login check
    performLoginCheck();

    // Periodically check isLoggedIn every 1 minute
    const intervalId = setInterval(performLoginCheck, 1 * ONE_MINUTE);

    // Clean up the interval when the component is unmounted
    return () => clearInterval(intervalId);
  }, []);

  return <>
    {user && children}
  </>;
};

// PropTypes validation
ProtectedRoute.propTypes = {
  children: PropTypes.node.isRequired,
};

export default ProtectedRoute;
