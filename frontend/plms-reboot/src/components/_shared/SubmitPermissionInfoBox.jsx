import React from 'react';
import { useEffect, useState } from 'react';
import { Stack, Typography, Box } from '@mui/material';
import { styled } from '@mui/system';
import { secondsToDhms } from '@/utils';

const stackContainer = {
  position: "absolute",
  zIndex: 100,
  top: 12,
  left: "50%",
  transform: "translateX(-50%)",
  minWidth: "400px",
  height: "110px",
  justifyContent: "center",
  alignItems: "center",
  padding: "10px 20px",
  borderRadius: "8px",
}

const timerContainer = {
  flexDirection: "row",
  justifyContent: "center",
  gap: "10px",
}

// style a Box component
const NumberBox = styled(Box)`
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 20px;
  font-weight: bold;
  width: 60px;
  height: 45px;
  text-align: center;
  border-radius: 5px;
`

const ColonBox = styled(NumberBox)`
  width: 20px;
  padding: 0;
`

const CountDownTimer = ({ timeLeft }) => {
  return (
    <Stack sx={timerContainer} >
      <Stack alignItems="center">
        <NumberBox>{timeLeft.d}</NumberBox>
        <Typography variant="caption">days</Typography>
      </Stack>
      <ColonBox>:</ColonBox>
      <Stack alignItems="center">
        <NumberBox>{timeLeft.h}</NumberBox>
        <Typography variant="caption">hours</Typography>
      </Stack>
      <ColonBox>:</ColonBox>
      <Stack alignItems="center">
        <NumberBox sx={{ color: timeLeft.m < 10 && "#e74c3c" }} >{timeLeft.m}</NumberBox>
        <Typography variant="caption">mins</Typography>
      </Stack>
      <ColonBox>:</ColonBox>
      <Stack alignItems="center">
        <NumberBox sx={{ color: timeLeft.m < 10 && "#e74c3c" }} >{timeLeft.s}</NumberBox>
        <Typography variant="caption">secs</Typography>
      </Stack>
    </Stack >
  )
}

const SubmitPermissionInfoBox = ({
  chapterPermissionQuery,
  submitPermissionStatus,
  secondsLeftBeforeSubmittable,
  secondsLeftBeforeUnsubmittable,
}) => {
  const [timeLeft, setTimeLeft] = useState({ d: 0, h: 0, m: 0, s: 0 });

  useEffect(() => {
    let secondsToConvert = null;

    if (submitPermissionStatus === 'notStarted') {
      secondsToConvert = secondsLeftBeforeSubmittable;
    } else if (submitPermissionStatus === 'submittable') {
      secondsToConvert = secondsLeftBeforeUnsubmittable;
    } else if (submitPermissionStatus === 'timer-paused') {
      secondsToConvert = secondsLeftBeforeUnsubmittable;
    }

    if (secondsToConvert !== null) {
      setTimeLeft(secondsToDhms(secondsToConvert));
    }
  }, [submitPermissionStatus, secondsLeftBeforeSubmittable, secondsLeftBeforeUnsubmittable]);

  if (chapterPermissionQuery.isLoading || submitPermissionStatus === "loading") {
    return null;
  }

  const { data: { allow_submit_type } } = chapterPermissionQuery;

  const bgcolor = (submitPermissionStatus === "unsubmittable" || submitPermissionStatus === "ended") ? "#e74c3c" : "var(--chathamBlue)";

  return (
    <Stack sx={stackContainer}>
      <Stack sx={{ width: "100%", padding: "10px", bgcolor: bgcolor, borderRadius: "8px" }} >
        <Stack direction="row" justifyContent="center" >
          <Stack alignItems="center">
            {allow_submit_type === "always" && <Typography>This chapter has no submission time limit.</Typography>}
            {(allow_submit_type === "timer" || allow_submit_type === "datetime" || allow_submit_type === "timer-paused") && (
              <>
                {submitPermissionStatus === "loading" && <Typography>Loading...</Typography>}
                {submitPermissionStatus === "notStarted" && <>
                  <Typography>About to be submittable in</Typography>
                  <CountDownTimer timeLeft={timeLeft || { d: 0, h: 0, m: 0, s: 0 }} />
                </>}
                {submitPermissionStatus === "submittable" && <>
                  <Typography>This chapter is submittable for</Typography>
                  <CountDownTimer timeLeft={timeLeft} />
                </>}
                {submitPermissionStatus === "timer-paused" && <>
                  <Typography>This chapter submision time limit is paused</Typography>
                  <CountDownTimer timeLeft={timeLeft} />
                </>}
                {submitPermissionStatus === "ended" && <Typography>Submission time has ended.</Typography>}
              </>
            )}

            {(allow_submit_type === "deny" || submitPermissionStatus === "unsubmittable") && <Typography>Submission is not allowed by instructor.</Typography>}
          </Stack>
        </Stack>
      </Stack>
    </Stack >
  )
}

export default SubmitPermissionInfoBox