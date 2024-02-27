// a hook that return the current time (moment object) and update every second
import { useEffect, useState } from "react";
import { serverTimeOffsetAtom } from "@/store/store";
import { useAtom } from "jotai";
import moment from "moment";

export default function useCurrentTime() {
  const [serverTimeOffset, setServerTimeOffset] = useAtom(serverTimeOffsetAtom);
  const [currentTime, setCurrentTime] = useState(moment().add(serverTimeOffset, 'milliseconds'));

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentTime(moment().add(serverTimeOffset, 'milliseconds'));
    }, 1000);

    return () => clearInterval(interval);
  }, []);

  return currentTime;
}