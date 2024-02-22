import { useState, useEffect } from 'react';

const useOnlineStudentsList = (groupId) => {
  const [onlineStudentsList, setOnlineStudentsList] = useState([]);

  useEffect(() => {
    const eventSource = new EventSource(`${import.meta.env.VITE_REALTIME_BASE_URL}/subscribe/online-students/${groupId}`);
    eventSource.onmessage = (e) => {
      /* console.log(JSON.parse(e.data)); */
      setOnlineStudentsList(JSON.parse(e.data));
    }
    return () => {
      eventSource.close();
    }
  }, [groupId]); // groupId is a dependency now

  return onlineStudentsList;
};

export default useOnlineStudentsList;