export const initSuggestWorker = (ref, dispatch) => {
  if (ref.current) return;

  ref.current = new Worker('/workers/pyodideWorker.js');
  ref.current.onmessage = ({ data }) => {
    if (data.status === 'initialized') {
      dispatch({ type: 'SET_PYODIDE_READY', payload: true });
      console.log(data.message);
    } else if (data.status === "success") {
      dispatch({ type: 'UPDATE_KW_CON_LIST', payload: data.data });
    } else {
      alert(data.message)
    }
  };
};