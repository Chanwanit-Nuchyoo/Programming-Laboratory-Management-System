import { useEffect, useState } from 'react';

const usePyodide = (initialWorkerPath) => {
  const [isPyodideReady, setIsPyodideReady] = useState(false);
  const [pyodideWorker, setPyodideWorker] = useState(null);

  useEffect(() => {
    const worker = new Worker(initialWorkerPath);
    worker.onmessage = ({ data }) => {
      if (data.status === 'initialized') {
        setIsPyodideReady(true);
      } else if (data.status === 'success') {
        // Handle success logic if needed
      } else {
        alert(data.message);
      }
    };

    setPyodideWorker(worker);

    return () => {
      if (worker) {
        worker.terminate();
      }
    };
  }, [initialWorkerPath]);

  const handleKeywordAnalyzer = (pythonCode) => {
    if (!isPyodideReady) {
      console.warn('Pyodide is not ready yet.');
      alert('Pyodide is not ready yet.');
      return;
    }

    pyodideWorker.postMessage({ pythonCode });
  };

  return { isPyodideReady, handleKeywordAnalyzer };
};

export default usePyodide;
