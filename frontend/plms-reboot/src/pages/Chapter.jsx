import { Box, Stack, Container, Skeleton, Button } from '@mui/material'
import Grid from '@mui/material/Unstable_Grid2';
import chapterIcon from '@/assets/images/chaptericon.svg'
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from '@/components/_shared/Header'
import LabLevel from '@/components/ChapterPage/LabLevel'
import { useParams } from 'react-router-dom'
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query'
import { getLabChapterInfo, updateAllGroupAssignedChapterItem } from "@/utils/api"
import { useEffect, useState } from 'react';
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";

const Chapter = () => {
  const queryClient = useQueryClient();
  const { groupId, chapterId } = useParams();
  const setSelected = useSetAtom(sidebarSelectedAtom);

  useEffect(() => {
    setSelected('my_groups');
  }, []);

  const { data: labChapterInfo, isPending } = useQuery({
    queryKey: ['labChapterInfo', groupId, chapterId],
    queryFn: ({ queryKey }) => getLabChapterInfo(queryKey[1], queryKey[2]),
  })
  const { mutate: saveAllRandomPools } = useMutation({
    mutationFn: updateAllGroupAssignedChapterItem,
    onSuccess: () => {
      queryClient.invalidateQueries(['labChapterInfo', groupId, chapterId]);
    }
  })
  const [randomPools, setRandomPools] = useState(null)
  const [labLevelInfo, setLabLevelInfo] = useState(null)

  useEffect(() => {
    if (!isPending && labChapterInfo) {
      setRandomPools(labChapterInfo["group_selected_labs"]);
      setLabLevelInfo(Object.values(labChapterInfo.lab_list))
    }
  }, [isPending, labChapterInfo])

  const handleSubmitAll = () => {
    saveAllRandomPools({
      group_id: groupId,
      chapter_id: chapterId,
      pools_list: randomPools
    })
  }

  const resetAll = () => {
    setRandomPools(labChapterInfo["group_selected_labs"]);
  }

  const isDataEqual = (obj1, obj2) => {
    if (obj1 && obj2) {
      const keys1 = Object.keys(obj1);
      const keys2 = Object.keys(obj2);

      if (keys1.length !== keys2.length) {
        return false;
      }

      return keys1.every(key => {
        if (!keys2.includes(key)) {
          return false;
        }

        const arr1 = [...new Set(obj1[key])].sort();
        const arr2 = [...new Set(obj2[key])].sort();

        return arr1.length === arr2.length && arr1.every((value, index) => value === arr2[index]);
      });
    }

    return false;
  }

  const isFormDirty = !isDataEqual(randomPools, labChapterInfo?.group_selected_labs);

  return (
    <Box>
      <Container>
        <Stack spacing={"20px"}>
          <MyBreadCrumbs items={[
            { label: 'My Groups', href: '/ins' },
            { label: `Group ${labChapterInfo?.group_no}`, href: `/ins/group/${groupId}/` },
            { label: isPending ? "Loading..." : `Chapter ${chapterId} : ${labChapterInfo?.chapter_name}`, href: '#' },
          ]} />

          <Stack direction="row" justifyContent="space-between" >
            <Header logoSrc={chapterIcon} title={isPending ? "Loading..." : `Chapter ${chapterId} : ${labChapterInfo?.chapter_name}`} />
            <Stack direction="row" spacing="10px" >
              <Button variant='contained' size='small'
                disabled={!isFormDirty}
                onClick={handleSubmitAll}
                sx={{
                  fontSize: '16px',
                  width: '120px',
                  paddingY: "8px",
                  borderRadius: "8px",
                  bgcolor: "var(--cerulean )",
                  textTransform: "none",
                  flexShrink: "0",
                }}
              >Update All</Button>
              <Button variant='contained' color='error' size='small'
                disabled={!isFormDirty}
                onClick={resetAll}
                sx={{
                  textTransform: "none",
                  width: '120px',
                  paddingY: "8px",
                  fontSize: '16px'
                }}>Reset</Button>
            </Stack>
          </Stack>

          <Grid container spacing={"10px"}>
            {isPending && <>
              <Grid xs={12} md={6}>
                <Skeleton variant='rounded' height={524} />
              </Grid>
              <Grid xs={12} md={6}>
                <Skeleton variant='rounded' height={524} />
              </Grid>
              <Grid xs={12} md={6}>
                <Skeleton variant='rounded' height={524} />
              </Grid>
              <Grid xs={12} md={6}>
                <Skeleton variant='rounded' height={524} />
              </Grid>
            </>}

            {!isPending && randomPools && labLevelInfo && labLevelInfo.map((lv, index) => (
              <LabLevel
                chapterName={labChapterInfo.chapter_name}
                key={index}
                lv={lv}
                index={index}
                selectedListFromAPI={labChapterInfo["group_selected_labs"]}
                randomPools={{ value: randomPools, setValue: setRandomPools }}
              />
            ))}
          </Grid>

        </Stack>
      </Container>
    </Box >
  )
}

export default Chapter