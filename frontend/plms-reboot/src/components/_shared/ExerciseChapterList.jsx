/* eslint-disable react/prop-types */
import { Box, Stack, Typography, Skeleton } from "@mui/material"
import { useEffect, useState, useRef, useMemo } from "react"
import { useAtom } from "jotai"
import { serverTimeOffsetAtom, userAtom } from "@/store/store"
import { useParams } from "react-router-dom"
import { useQueryClient } from "@tanstack/react-query"
import ChapterListTableHead from "@/components/ExerciseChapterList/ChapterListTableHead"
import ChapterListTableBody from "@/components/ExerciseChapterList/ChapterListTableBody"
import useEventSource from "@/hooks/useEventSource"
import moment from "moment"
import { set } from "react-hook-form"

const ExerciseChapterList = ({ cacheKey, refetch, isLoading, data, examChapters, insPage = false }) => {
  const [examFlag, setExamFlag] = useState(null);
  const [user] = useAtom(userAtom);
  const [serverTimeOffset, setServerTimeOffset] = useAtom(serverTimeOffsetAtom);
  const queryClient = useQueryClient();

  const groupId = insPage ? useParams().groupId : user.stu_group;

  const examChapterIdList = useMemo(() => {
    return examChapters?.map((chapter) => chapter.chapter_id);
  }, [examChapters]);

  useEventSource(
    `${import.meta.env.VITE_REALTIME_BASE_URL}/subscribe/chapter-permission/${groupId}`,
    (event) => {
      const updatedChapter = JSON.parse(event.data);

      if (examChapterIdList?.includes(parseInt(updatedChapter.chapter_id))) {
        if (checkExamFlag(updatedChapter)) {
          setExamFlag(true);
        }
      }

      const snapShot = queryClient.getQueryData(cacheKey);
      if (snapShot) {
        const updatedData = snapShot.map((chapter) => {
          if (chapter.chapter_id === parseInt(updatedChapter.chapter_id)) {
            updatedChapter.chapter_id = parseInt(updatedChapter.chapter_id);
            return { ...chapter, ...updatedChapter };
          }
          return chapter;
        });
        queryClient.setQueryData(cacheKey, updatedData);
      } else {
        refetch();
      }
    }
  );

  const calculateTotalScore = () => {
    let totalScore = 0
    data.forEach(chapter => {
      chapter.items.forEach(item => {
        totalScore += parseInt(item.stu_lab.marking)
      })
    })
    return totalScore
  }

  const checkExamFlag = (chapter) => {
    if (["always", "timer-paused"].includes(chapter.allow_access_type)) {
      return true;
    } else if (chapter.allow_access_type === "deny") {
      return false;
    } else {
      const now = moment().add(serverTimeOffset, "milliseconds");
      const start = moment(chapter.access_time_start);
      const end = moment(chapter.access_time_end);
      return now.isBetween(start, end);
    }
  };

  useEffect(() => {
    let intervalId = null;

    if (!insPage && examChapters && examChapters.length > 0) {
      intervalId = setInterval(() => {
        const flag = examChapters.some((chapter) => checkExamFlag(chapter));
        setExamFlag(flag);
      }, 1000);
    } else {
      setExamFlag(null);
    }

    return () => {
      if (intervalId) {
        clearInterval(intervalId);
      }
    };
  }, [examChapters]);

  return (
    <Stack spacing={"5px"} >
      <ChapterListTableHead />
      {/* Table Body */}
      {isLoading && !examChapters &&
        <>
          <Skeleton variant="rectangular" height={95} />
          <Skeleton variant="rectangular" height={95} />
          <Skeleton variant="rectangular" height={95} />
          <Skeleton variant="rectangular" height={95} />
          <Skeleton variant="rectangular" height={95} />
          <Skeleton variant="rectangular" height={95} />
          <Skeleton variant="rectangular" height={95} />
        </>
      }

      {!isLoading && data && data.map((chapter, index) => (
        <ChapterListTableBody key={index} chapter={chapter} insPage={insPage} examFlag={examFlag} />
      ))}

      {!isLoading && data &&
        <Stack direction={"row"} spacing="5px">
          <Stack padding={"20px"} justifyContent="center" flex={1} sx={{
            borderRadius: "8px",
            bgcolor: "var(--mirage)",
          }} >
            <Typography variant="h6" >TotalScore</Typography>
          </Stack>
          <Box alignItems={"center"} width={95} className={`outlined ${'row-info-box'}`} >
            <Typography>{calculateTotalScore()}/{data.reduce((acc, object) => acc + parseInt(object?.chapter_fullmark), 0)}</Typography>
          </Box>
        </Stack>
      }
    </Stack>
  )
}

export default ExerciseChapterList