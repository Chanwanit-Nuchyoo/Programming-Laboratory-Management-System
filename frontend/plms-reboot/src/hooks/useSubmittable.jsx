import { useState, useEffect } from 'react';
import { useQuery } from "@tanstack/react-query";
import { getChapterPermission } from '@/utils/api';
import { serverTimeOffsetAtom } from "@/store/store";
import { useAtom } from 'jotai';
import moment from 'moment';

// Helper function to calculate time difference using moment.js
const calculateTimeDiff = (startTime, endTime) => {
  const diff = endTime.diff(startTime, 'seconds');
  return diff >= 0 ? diff : null;
};

export default function useSubmittable(groupId, chapterId) {
  const [submitPermissionStatus, setSubmitPermissionStatus] = useState('loading');
  const [accessPermissionStatus, setAccessPermissionStatus] = useState('loading');
  const [secondsLeftBeforeSubmittable, setSecondsLeftBeforeSubmittable] = useState(null);
  const [secondsLeftBeforeUnsubmittable, setSecondsLeftBeforeUnsubmittable] = useState(null);
  const [secondsLeftBeforeAccessible, setSecondsLeftBeforeAccessible] = useState(null);
  const [secondsLeftBeforeInaccessible, setSecondsLeftBeforeInaccessible] = useState(null);
  const [serverTimeOffset] = useAtom(serverTimeOffsetAtom);

  const chapterPermissionQuery = useQuery({
    queryKey: ['chapter-permission', groupId, chapterId],
    queryFn: () => getChapterPermission(groupId, chapterId),
    onError: (error) => {
      console.error('Error fetching chapter permission:', error);
      setSubmitPermissionStatus('error');
      setAccessPermissionStatus('error');
    },
  });

  useEffect(() => {
    const updatePermissions = async () => {
      const { data, isPending, error } = chapterPermissionQuery;
      const currentTime = moment().add(serverTimeOffset, 'milliseconds');

      if (error) {
        return; // Handle error here, if desired
      }

      if (isPending) {
        setAccessPermissionStatus('loading');
        setSubmitPermissionStatus('loading');
        return;
      }

      const { allow_submit_type, submit_time_start, submit_time_end, allow_access_type, access_time_start, access_time_end } = data || {};

      // Update submittable status
      if (allow_submit_type === "deny") {
        setSubmitPermissionStatus("unsubmittable");
      } else if (['timer', 'datetime'].includes(allow_submit_type)) {
        setSecondsLeftBeforeSubmittable(calculateTimeDiff(currentTime, moment(submit_time_start)));
        setSecondsLeftBeforeUnsubmittable(calculateTimeDiff(currentTime, moment(submit_time_end)));
      } else if (allow_submit_type === "timer-paused") {
        setSubmitPermissionStatus("timer-paused");
        setSecondsLeftBeforeUnsubmittable(calculateTimeDiff(moment(submit_time_start), moment(submit_time_end)));
      } else {
        setSubmitPermissionStatus("submittable");
      }

      // Update access status
      if (allow_access_type === "deny") {
        setAccessPermissionStatus("inaccessible");
      } else if (['timer', 'datetime'].includes(allow_access_type)) {
        setSecondsLeftBeforeAccessible(calculateTimeDiff(currentTime, moment(access_time_start)));
        setSecondsLeftBeforeInaccessible(calculateTimeDiff(currentTime, moment(access_time_end)));
      } else if (allow_access_type === "timer-paused") {
        setAccessPermissionStatus("timer-paused");
        setSecondsLeftBeforeInaccessible(calculateTimeDiff(moment(access_time_start), moment(access_time_end)));
      } else {
        setAccessPermissionStatus("accessible");
      }
    };

    // Only set up the interval if the query is not pending
    if (!chapterPermissionQuery.isPending) {
      updatePermissions(); // Call immediately

      // Set up an interval to update the time left every second
      const intervalId = setInterval(updatePermissions, 1000);

      // Cleanup function
      return () => {
        clearInterval(intervalId);
      };
    }
  }, [chapterPermissionQuery]);

  useEffect(() => {
    if (!chapterPermissionQuery.isPending) {
      if (['timer', 'datetime'].includes(chapterPermissionQuery.data.allow_access_type)) {
        if (secondsLeftBeforeAccessible > 0) {
          setAccessPermissionStatus('notStarted');
        } else if (secondsLeftBeforeInaccessible > 0) {
          setAccessPermissionStatus('accessible');
        } else {
          setAccessPermissionStatus('ended');
        }
      }
    } else {
      setAccessPermissionStatus('loading');
    }
  }, [secondsLeftBeforeAccessible, secondsLeftBeforeInaccessible])

  useEffect(() => {
    if (!chapterPermissionQuery.isPending) {
      if (['timer', 'datetime'].includes(chapterPermissionQuery.data.allow_submit_type)) {
        if (secondsLeftBeforeSubmittable > 0) {
          setSubmitPermissionStatus('notStarted');
        } else if (secondsLeftBeforeUnsubmittable > 0) {
          setSubmitPermissionStatus('submittable');
        } else {
          setSubmitPermissionStatus('ended');
        }
      }
    } else {
      setSubmitPermissionStatus('loading');
    }
  }, [secondsLeftBeforeSubmittable, secondsLeftBeforeUnsubmittable])

  return {
    chapterPermissionQuery,
    submitPermissionStatus,
    accessPermissionStatus,
    secondsLeftBeforeSubmittable,
    secondsLeftBeforeUnsubmittable,
    secondsLeftBeforeAccessible,
    secondsLeftBeforeInaccessible,
  };
}