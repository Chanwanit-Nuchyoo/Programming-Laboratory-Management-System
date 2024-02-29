/* eslint-disable react/prop-types */
import { Box, Stack, Typography, Skeleton } from "@mui/material"
import { useEffect, useState, useCallback, useMemo, memo } from "react"
import { useAtom } from "jotai"
import { serverTimeOffsetAtom, userAtom } from "@/store/store"
import { useParams } from "react-router-dom"
import ChapterListTableHead from "@/components/ExerciseChapterList/ChapterListTableHead"
import ChapterListTableBody from "@/components/ExerciseChapterList/ChapterListTableBody"
import useEventSource from "@/hooks/useEventSource"
import { checkExamFlag } from "@/utils"
import { useQueryClient } from "@tanstack/react-query"

const ExerciseChapterList = ({ cacheKey, refetch, isLoading, data, examChapters, insPage = false }) => {
  const [examFlag, setExamFlag] = useState(null);
  const [user] = useAtom(userAtom);
  const [serverTimeOffset, setServerTimeOffset] = useAtom(serverTimeOffsetAtom);
  const queryClient = useQueryClient();

  const groupId = insPage ? useParams().groupId : user.stu_group;

  useEventSource(
    `${import.meta.env.VITE_REALTIME_BASE_URL}/subscribe/chapter-permission/${groupId}`,
    (event) => {
      const updatedData = JSON.parse(event.data);
      const oldData = queryClient.getQueryData(cacheKey);
      setExamFlag(null);

      if (!oldData) {
        refetch();
      } else {
        updatedData.chapter_id = parseInt(updatedData.chapter_id);
        queryClient.setQueryData(cacheKey, oldData.map(chapter => {
          if (chapter.chapter_id === updatedData.chapter_id) {
            return { ...chapter, ...updatedData };
          }
          return chapter;
        }));
      }

    }
  );

  const calculateTotalScore = useCallback(() => {
    let totalScore = 0
    data.forEach(chapter => {
      chapter.items.forEach(item => {
        totalScore += parseInt(item.stu_lab.marking)
      })
    })
    return totalScore
  }, [data]);

  const totalScore = useMemo(() => calculateTotalScore(), [calculateTotalScore]);

  useEffect(() => {
    let intervalId = null;

    if (!insPage && examChapters && examChapters.length > 0) {
      intervalId = setInterval(() => {
        const flag = examChapters.some((chapter) => checkExamFlag(chapter, serverTimeOffset));
        setExamFlag(flag);
      }, 500);
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
      {isLoading && !examChapters && !insPage &&
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

      {(insPage || (!isLoading && data)) && data.map((chapter, index) => (
        <ChapterListTableBody key={index} chapter={chapter} insPage={insPage} examFlag={examFlag} />
      ))}

      {(insPage || (!isLoading && data)) &&
        <Stack direction={"row"} spacing="5px">
          <Stack padding={"20px"} justifyContent="center" flex={1} sx={{
            borderRadius: "8px",
            bgcolor: "var(--mirage)",
          }} >
            <Typography variant="h6" >TotalScore</Typography>
          </Stack>
          <Box alignItems={"center"} width={95} className={`outlined ${'row-info-box'}`} >
            <Typography>{totalScore}/{data.reduce((acc, object) => acc + parseInt(object?.chapter_fullmark), 0)}</Typography>
          </Box>
        </Stack>
      }
    </Stack>
  )
}

export default memo(ExerciseChapterList)