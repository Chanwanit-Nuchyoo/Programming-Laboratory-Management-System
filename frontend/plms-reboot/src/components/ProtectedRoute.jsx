import { useEffect, createContext, useContext } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useAtom } from 'jotai';
import { userAtom, serverTimeOffsetAtom } from '@/store/store';
import { COMMON_URL } from "@/utils/constants/routeConst";
import moment from "moment";
import PropTypes from 'prop-types';
import { set } from "react-hook-form";

const ONE_MINUTE = 60000; // 1 minute in milliseconds

// This component is used to check if the user is logged in or not
// Create a context
const LoginCheckContext = createContext();

const ProtectedRoute = ({ children }) => {
  const [user, setUser] = useAtom(userAtom);
  const [serverTimeOffset, setServerTimeOffset] = useAtom(serverTimeOffsetAtom);
  const navigate = useNavigate();

  const performLoginCheck = async () => {
    try {
      const clientTime = moment().valueOf();
      const response = await axios.get(import.meta.env.VITE_BACKEND_BASE_URL + "/index.php/auth_rest/logged_in_check", { withCredentials: true });
      if (response.data.status) {
        const offset = moment(response.data.server_time, 'YYYY-MM-DD HH:mm:ss').valueOf() - clientTime;
        setUser(response.data.payload);
        setServerTimeOffset(offset);
        localStorage.setItem('user', JSON.stringify(response.data.payload));
      } else {
        setUser(null);
        setServerTimeOffset(null);
        localStorage.removeItem('user');
        navigate(COMMON_URL.STATIC.SIGNIN);
      }
    } catch (error) {
      console.error("Failed to perform login check:", error);
      setUser(null);
      setServerTimeOffset(null);
      localStorage.removeItem('user');
      navigate(COMMON_URL.STATIC.SIGNIN);
    }
  };

  useEffect(() => {
    // Initial login check
    performLoginCheck();

    // Periodically check isLoggedIn every 1 minute
    const intervalId = setInterval(performLoginCheck, 1 * ONE_MINUTE);

    // Clean up the interval when the component is unmounted
    return () => clearInterval(intervalId);
  }, []);

  return (
    <LoginCheckContext.Provider value={performLoginCheck}>
      {user && children}
    </LoginCheckContext.Provider>
  );
};

// Create a hook to use the context
export const useLoginCheck = () => useContext(LoginCheckContext);

// PropTypes validation
ProtectedRoute.propTypes = {
  children: PropTypes.node.isRequired,
};

export default ProtectedRoute;