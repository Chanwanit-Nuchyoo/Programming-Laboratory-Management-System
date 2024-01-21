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
  bgcolor: 'rgba(25,44,91,0.7)',
  backdropFilter: 'blur(25px)',
  borderRadius: "16px",
  border: '1px solid rgba(255, 255, 255, 0.20)',
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