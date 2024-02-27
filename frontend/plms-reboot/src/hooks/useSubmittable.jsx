import { useState, useEffect, useMemo, useCallback } from 'react';
import { getChapterPermission } from '@/utils/api';
import { useQuery } from "@tanstack/react-query"
import { serverTimeOffsetAtom } from "@/store/store";
import { useAtom } from 'jotai';
import moment from 'moment';

export default function useSubmittable(groupId, chapterId) {
  const [submitPermissionStatus, setSubmitPermissionStatus] = useState('loading');
  const [accessPermissionStatus, setAccessPermissionStatus] = useState('loading');
  const [secondsLeftBeforeSubmittable, setSecondsLeftBeforeStartSubmittable] = useState(null);
  const [secondsLeftBeforeUnsubmittable, setSecondsLeftBeforeUnsubmittable] = useState(null);
  const [secondsLeftBeforeAccessible, setSecondsLeftBeforeAccessible] = useState(null);
  const [secondsLeftBeforeInaccessible, setSecondsLeftBeforeInaccessible] = useState(null);

  const chapterPermissionQuery = useQuery({
    queryKey: ['chapter-permission', groupId, chapterId],
    queryFn: () => getChapterPermission(groupId, chapterId),
  })

  const { allow_submit_type, submit_time_start, submit_time_end, allow_access_type, access_time_start, access_time_end } = chapterPermissionQuery.data || {};

  const exerciseStartTime = useMemo(() => moment(submit_time_start), [submit_time_start]);
  const exerciseEndTime = useMemo(() => moment(submit_time_end), [submit_time_end]);
  const accessStartTime = useMemo(() => moment(access_time_start), [access_time_start]);
  const accessEndTime = useMemo(() => moment(access_time_end), [access_time_end]);

  const checkSubmittableStatus = useCallback(() => {
    const currentTime = moment().add(serverTimeOffset, 'milliseconds');

    if (currentTime.isBefore(exerciseStartTime)) {
      setSubmitPermissionStatus("notStarted");
    } else if (currentTime.isBetween(exerciseStartTime, exerciseEndTime)) {
      setSubmitPermissionStatus("submittable");
    } else {
      setSubmitPermissionStatus("ended");
    }

    setSecondsLeftBeforeStartSubmittable(exerciseStartTime.diff(currentTime, 'seconds') >= 0 ? exerciseStartTime.diff(currentTime, 'seconds') : null);
    setSecondsLeftBeforeUnsubmittable(exerciseEndTime.diff(currentTime, 'seconds') >= 0 ? exerciseEndTime.diff(currentTime, 'seconds') : null);
  }, [exerciseStartTime, exerciseEndTime]);

  const checkAccessStatus = useCallback(() => {
    const currentTime = moment().add(serverTimeOffset, 'milliseconds');

    if (currentTime.isBefore(accessStartTime)) {
      setAccessPermissionStatus("notStarted");
    } else if (currentTime.isBetween(accessStartTime, accessEndTime)) {
      setAccessPermissionStatus("accessible");
    } else {
      setAccessPermissionStatus("ended");
    }

    // Calculate time left before start and end times
    setSecondsLeftBeforeAccessible(accessStartTime.diff(currentTime, 'seconds') >= 0 ? accessStartTime.diff(currentTime, 'seconds') : null);
    setSecondsLeftBeforeInaccessible(accessEndTime.diff(currentTime, 'seconds') >= 0 ? accessEndTime.diff(currentTime, 'seconds') : null);
  }, [accessStartTime, accessEndTime]);

  useEffect(() => {
    let submittableCheckIntervalId;
    let accessCheckIntervalId;

    if (!chapterPermissionQuery.isPending && chapterPermissionQuery.data) {
      if (allow_submit_type === "deny") {
        setSubmitPermissionStatus("unsubmittable");
      } else if (['timer', 'datetime'].includes(allow_submit_type)) {
        submittableCheckIntervalId = setInterval(checkSubmittableStatus, 1000);
      } else if (allow_submit_type === "timer-paused") {
        setSubmitPermissionStatus("timer-paused");
        setSecondsLeftBeforeUnsubmittable(exerciseEndTime.diff(exerciseStartTime, 'seconds') >= 0 ? exerciseEndTime.diff(exerciseStartTime, 'seconds') : null);
      } else {
        setSubmitPermissionStatus("submittable");
      }

      if (allow_access_type === "deny") {
        setAccessPermissionStatus("inaccessible");
      } else if (['timer', 'datetime'].includes(allow_access_type)) {
        accessCheckIntervalId = setInterval(checkAccessStatus, 1000);
      } else if (allow_access_type === "timer-paused") {
        setAccessPermissionStatus("timer-paused");
        setSecondsLeftBeforeInaccessible(accessEndTime.diff(accessStartTime, 'seconds') >= 0 ? accessEndTime.diff(accessStartTime, 'seconds') : null);
      } else {
        setAccessPermissionStatus("accessible");
      }
    }

    // Cleanup function
    return () => {
      if (submittableCheckIntervalId) {
        clearInterval(submittableCheckIntervalId);
      }
      if (accessCheckIntervalId) {
        clearInterval(accessCheckIntervalId);
      }
    };
  }, [chapterPermissionQuery.isPending, chapterPermissionQuery.data, allow_submit_type, checkSubmittableStatus, allow_access_type, checkAccessStatus]);

  if (chapterPermissionQuery.isError) {
    return {
      chapterPermissionQuery,
      submitPermissionStatus: 'error',
      accessPermissionStatus: 'error',
      secondsLeftBeforeSubmittable: null,
      secondsLeftBeforeUnsubmittable: null,
      secondsLeftBeforeAccessible: null,
      secondsLeftBeforeInaccessible: null
    };
  }

  return {
    chapterPermissionQuery,
    submitPermissionStatus,
    accessPermissionStatus,
    secondsLeftBeforeSubmittable,
    secondsLeftBeforeUnsubmittable,
    secondsLeftBeforeAccessible,
    secondsLeftBeforeInaccessible
  };
}