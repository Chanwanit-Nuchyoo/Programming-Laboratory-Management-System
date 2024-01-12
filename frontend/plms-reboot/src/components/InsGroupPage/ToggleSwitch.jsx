// ToggleSwitch.js
import React from 'react';

const ToggleSwitch = ({ isChecked, onToggle }) => {
  return (
    <div
      onClick={onToggle}
      style={{
        width: '50px',
        height: '26px',
        borderRadius: '15px',
        backgroundColor: isChecked ? '#4cd964' : '#ccc',
        display: 'flex',
        alignItems: 'center',
        justifyContent: isChecked ? 'flex-end' : 'flex-start',
        padding: '4px',
        transition: 'background-color 0.3s'
      }}
    >
      <div
        style={{
          width: '20px',
          height: '20px',
          borderRadius: '50%',
          backgroundColor: 'white',
          transition: 'transform 0.3s',
          transform: isChecked ? 'translateX(0px)' : 'translateX(0)'
        }}
      ></div>
    </div>
  );
};

export default ToggleSwitch;
