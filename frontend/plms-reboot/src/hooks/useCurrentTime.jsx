// a hook that return the current time (moment object) and update every second
import { useEffect, useState } from "react";
import moment from "moment";
export default function useCurrentTime() {
  const [currentTime, setCurrentTime] = useState(moment());

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentTime(moment());
    }, 1000);

    return () => clearInterval(interval);
  }, []);

  return currentTime;
}