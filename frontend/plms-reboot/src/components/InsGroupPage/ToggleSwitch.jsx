// ToggleSwitch.js
import React from 'react';

const ToggleSwitch = ({ isChecked, onToggle, disabled }) => {
  return (
    <div
      onClick={!disabled ? onToggle : undefined}
      style={{
        width: '50px',
        height: '26px',
        borderRadius: '15px',
        backgroundColor: isChecked ? '#4cd964' : '#ccc',
        display: 'flex',
        alignItems: 'center',
        justifyContent: isChecked ? 'flex-end' : 'flex-start',
        padding: '4px',
        transition: 'background-color 0.3s',
        pointerEvents: disabled ? 'none' : undefined,
        opacity: disabled ? 0.5 : 1
      }}
    >
      <div
        style={{
          width: '20px',
          height: '20px',
          borderRadius: '50%',
          backgroundColor: 'white',
          transition: 'transform 0.3s',
          transform: isChecked ? 'translateX(0px)' : 'translateX(0)',
          pointerEvents: 'none'
        }}
      ></div>
    </div>
  );
};

export default ToggleSwitch;
