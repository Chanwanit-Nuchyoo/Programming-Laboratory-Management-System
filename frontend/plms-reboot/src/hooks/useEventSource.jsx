import { useEffect } from 'react';

const useEventSource = (url, onMessage) => {
  useEffect(() => {
    const eventSource = new EventSource(url);

    eventSource.onmessage = onMessage

    return () => {
      eventSource.close();
    };
  }, []);
};

export default useEventSource;