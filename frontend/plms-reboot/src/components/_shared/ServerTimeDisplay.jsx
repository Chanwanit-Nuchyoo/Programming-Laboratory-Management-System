import { Box } from "@mui/system";
import useCurrentTime from "@/hooks/useCurrentTime";

const ServerTimeDisplay = () => {
  const currentTime = useCurrentTime();
  return (
    <Box position="fixed" width="320px" bottom={0} right="0px" padding="5px 10px" bgcolor="black" borderRadius="8px 0px 0px 0px" style={{ whiteSpace: 'nowrap' }}>
      Server Time: {currentTime.format('Do-MMM-YYYY HH:mm:ss')}
    </Box>
  )
}

export default ServerTimeDisplay