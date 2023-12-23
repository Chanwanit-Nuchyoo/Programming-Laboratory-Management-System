/* eslint-disable react-refresh/only-export-components */
import React from 'react';
import ReactDOM from 'react-dom/client';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import { themeOptions } from './mui-theme-option';
import { CssBaseline } from '@mui/material';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { AdapterMoment } from '@mui/x-date-pickers/AdapterMoment';
import { Provider } from 'jotai';
import RouterComponent from './RouterComponent';
import { QueryClientProvider, QueryClient } from '@tanstack/react-query';
import './index.css';

const customTheme = createTheme(themeOptions);
const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      retry: 1,
    },
  },
});

const App = () => {
  return (
    <Provider>
      <ThemeProvider theme={customTheme}>
        <LocalizationProvider dateAdapter={AdapterMoment}>
          <CssBaseline />
          <QueryClientProvider client={queryClient} >
            <RouterComponent />
          </QueryClientProvider>
        </LocalizationProvider>
      </ThemeProvider>
    </Provider>
  );
};

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode >,
);