export const themeOptions = {
  typography: {
    fontFamily: [
      'BeVietnamPro',
    ].join(',')
  },
  palette: {
    mode: "dark",
    primary: {
      main: '#0Ca6e9',
      dark: '#0e5076',
      light: '#00c1ff',
      contrastText: '#ffffff',
    },
    secondary: {
      main: '#f50057',
      light: '#f73378',
      dark: '#ab003c',
    },
    error: {
      main: '#f44336',
      light: '#e57373',
      dark: '#d32f2f',
    },
    success: {
      main: '#4EC753',
      light: '#81c784',
      dark: '#4EC753',
    },
    divider: 'rgba(255,255,255,0.2)',
    background: {
      default: '#0f1729',
      paper: '#1d283a',
    },
    text: {
      primary: '#ffffff',
    },
  },
  props: {
    MuiButton: {
      size: 'small',
    },
    MuiButtonGroup: {
      size: 'small',
    },
    MuiCheckbox: {
      size: 'small',
    },
    MuiFab: {
      size: 'small',
    },
    MuiFormControl: {
      margin: 'dense',
      size: 'small',
    },
    MuiFormHelperText: {
      margin: 'dense',
    },
    MuiIconButton: {
      size: 'small',
    },
    MuiInputBase: {
      margin: 'dense',
    },
    MuiInputLabel: {
      margin: 'dense',
    },
    MuiRadio: {
      size: 'small',
    },
    MuiSwitch: {
      size: 'small',
    },
    MuiTextField: {
      margin: 'dense',
      size: 'small',
    },
  },
  shape: {
    borderRadius: 8,
  },
  components: {
    "MuiInputBase": {
      "styleOverrides": {
        root: {
          "&.Mui-disabled": {
            backgroundColor: 'rgba(255,255,255,0.1)',
          }
        }
      }
    },
    "MuiButton": {
      "styleOverrides": {
        root: {
          "textTransform": "none",
        }
      }
    },
  }
};