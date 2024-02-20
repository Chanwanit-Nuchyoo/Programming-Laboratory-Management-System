/* eslint-disable react/prop-types */
import useCurrentTime from '@/hooks/useCurrentTime';
import { Box, Stack, Typography } from '@mui/material';
import { styled } from '@mui/material/styles';
import PauseCircleOutlineIcon from '@mui/icons-material/PauseCircleOutline';
import PlayCircleFilledWhiteOutlinedIcon from '@mui/icons-material/PlayCircleFilledWhiteOutlined';
import { setChapterPermission } from "@/utils/api";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import moment from 'moment';

const StyledBox = styled(Box)(({ theme }) => ({
  display: "flex",
  justifyContent: "center",
  alignItems: "center",
  padding: "5px",
  borderRadius: "8px",
  width: "35px",
  height: "35px",
  backgroundColor: theme.palette.primary.main,
}));

const PermissionText = ({ prefix, type, lab, isInsPage }) => {
  const currentTime = useCurrentTime();
  const queryClient = useQueryClient();

  const { mutate } = useMutation({
    mutationFn: setChapterPermission,
    onSuccess: () => {
      queryClient.invalidateQueries(['labData', lab.class_id]);
    },
    onError: (error) => {
      console.log(error);
    }
  })

  const handlePaused = () => {
    mutate({
      class_id: lab.class_id,
      chapter_id: lab.chapter_id,
      prefix: prefix,
      [`allow_${prefix}_type`]: 'timer-paused',
      [`${prefix}_time_start`]: moment().format('YYYY-MM-DD HH:mm:ss'),
    })
  }

  const handleResume = () => {
    const timeStart = moment(lab[`${prefix}_time_start`]);
    const timeEnd = moment(lab[`${prefix}_time_end`]);
    mutate({
      class_id: lab.class_id,
      chapter_id: lab.chapter_id,
      prefix: prefix,
      [`allow_${prefix}_type`]: 'timer',
      [`${prefix}_time_start`]: moment().format('YYYY-MM-DD HH:mm:ss'),
      [`${prefix}_time_end`]: moment().add(timeEnd.diff(timeStart)).format('YYYY-MM-DD HH:mm:ss'),
    })
  }

  if (type === 'always') {
    return <Typography >Always</Typography>
  } else if (type === 'deny') {
    return <Typography sx={{ color: "red" }} >Deny</Typography>
  } else if (type === 'timer') {
    const timeEnd = moment(lab[`${prefix}_time_end`]);
    const timeLeft = moment.duration(timeEnd.diff(currentTime));
    const isEnded = currentTime.isAfter(timeEnd);
    return (
      <>
        {!isEnded ?
          <Stack direction="row" spacing={0.5} alignItems='center' >
            <StyledBox>
              <Typography >{String(timeLeft.hours()).length < 2 ? `0${String(timeLeft.hours())}` : String(timeLeft.hours())}</Typography>
            </StyledBox>
            <Typography >:</Typography>
            <StyledBox>
              <Typography >{String(timeLeft.minutes()).length < 2 ? `0${String(timeLeft.minutes())}` : String(timeLeft.minutes())}</Typography>
            </StyledBox>
            <Typography >:</Typography>
            <StyledBox>
              <Typography >{String(timeLeft.seconds()).length < 2 ? `0${String(timeLeft.seconds())}` : String(timeLeft.seconds())}</Typography>
            </StyledBox>
            {isInsPage &&
              <>{type === 'timer-paused' ? <PlayCircleFilledWhiteOutlinedIcon onClick={handleResume} /> : <PauseCircleOutlineIcon onClick={handlePaused} />}</>
            }
          </Stack>
          :
          <Typography sx={{ color: "red" }} >Deny</Typography>
        }
      </>
    )
  }
  else if (type === 'timer-paused') {
    const timeEnd = moment(lab[`${prefix}_time_end`]);
    const timeStart = moment(lab[`${prefix}_time_start`]);
    const timeLeft = moment.duration(timeEnd.diff(timeStart));

    return (
      <Stack direction="row" spacing={0.5} alignItems='center' >
        <StyledBox>
          <Typography >{String(timeLeft.hours()).length < 2 ? `0${String(timeLeft.hours())}` : String(timeLeft.hours())}</Typography>
        </StyledBox>
        <Typography >:</Typography>
        <StyledBox>
          <Typography >{String(timeLeft.minutes()).length < 2 ? `0${String(timeLeft.minutes())}` : String(timeLeft.minutes())}</Typography>
        </StyledBox>
        <Typography >:</Typography>
        <StyledBox>
          <Typography >{String(timeLeft.seconds()).length < 2 ? `0${String(timeLeft.seconds())}` : String(timeLeft.seconds())}</Typography>
        </StyledBox>
        {isInsPage &&
          <>{type === 'timer-paused' ? <PlayCircleFilledWhiteOutlinedIcon onClick={handleResume} /> : <PauseCircleOutlineIcon onClick={handlePaused} />}</>
        }
      </Stack>
    )

  } else if (type === 'datetime') {
    const timeStart = moment(lab[`${prefix}_time_start`]);
    const timeEnd = moment(lab[`${prefix}_time_end`]);
    const isStarted = currentTime.isAfter(timeStart);
    const isEnded = currentTime.isAfter(timeEnd);

    if (!isStarted) {
      return (<>
        <Typography fontSize={"12px"}>Start date</Typography>
        <Typography>{timeStart.format("YYYY-MM-DD HH:mm:ss")}</Typography>
      </>)
    } else if (isStarted && !isEnded) {
      return (<>
        <Typography fontSize={"12px"} >End date</Typography>
        <Typography>{timeEnd.format("YYYY-MM-DD HH:mm:ss")}</Typography>
      </>)
    } else {
      return <Typography sx={{ color: "red" }}>Deny</Typography>
    }
  }
}

export default PermissionText