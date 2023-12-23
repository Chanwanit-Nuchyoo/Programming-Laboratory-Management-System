export const getClassNames = (classes, ...classNames) => classNames.map(className => classes[className]).join(' ')
export const buttonStyle = { height: "100%", color: "white" };

export const SemesterOptions = new Set(["1", "2"])
export const ClassDateOptions = new Set(["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"])

export const modalStyle = {
  position: 'absolute',
  top: '50%',
  left: '50%',
  transform: 'translate(-50%, -50%)',
  minWidth: "600px",
  width: "fit-content",
  bgcolor: '#152343',
  borderRadius: "8px",
  boxShadow: 24,
  p: 4,
};

export const checkIsAccessible = (type, currentTime, startTime, endTime) => {
  if (type === "always" || type === "timer-paused") {
    return true
  } else if (type === "timer" || type === "datetime") {
    if (currentTime.isBetween(startTime, endTime)) {
      return true
    } else {
      return false
    }
  }
}