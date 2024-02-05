import { Box, Stack, Container, Skeleton } from '@mui/material'
import Grid from '@mui/material/Unstable_Grid2';
import chapterIcon from '@/assets/images/chaptericon.svg'
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from '@/components/_shared/Header'
import LabLevel from '@/components/ChapterPage/LabLevel'
import { useParams } from 'react-router-dom'
import { useQuery } from '@tanstack/react-query'
import { getLabChapterInfo } from "@/utils/api"

const Chapter = () => {

  const { groupId, chapterId } = useParams();
  const { data: labChapterInfo, isLoading } = useQuery({
    queryKey: ['labChapterInfo', groupId, chapterId],
    queryFn: ({ queryKey }) => getLabChapterInfo(queryKey[1], queryKey[2]),
  })

  const labLevelInfo = isLoading ? [] : Object.values(labChapterInfo.lab_list)
  const selectedList = isLoading ? {} : labChapterInfo["group_selected_labs"]

  return (
    <Box>
      <Container>
        <Stack spacing={"20px"}>

          <MyBreadCrumbs items={[
            { label: 'My Groups', href: '/ins' },
            { label: `Group ${labChapterInfo?.group_no}`, href: `/ins/group/${groupId}/` },
            { label: isLoading ? "Loading..." : `Chapter ${chapterId} : ${labChapterInfo?.chapter_name}`, href: '#' },
          ]} />

          <Header logoSrc={chapterIcon} title={isLoading ? "Loading..." : `Chapter ${chapterId} : ${labChapterInfo?.chapter_name}`} />

          <Grid container spacing={"10px"}>
            {isLoading && <>
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
            {!isLoading && labLevelInfo?.map((lv, index) => (
              <LabLevel
                chapterName={labChapterInfo.chapter_name}
                key={index}
                lv={lv}
                index={index}
                selectedList={selectedList[String(index + 1)] || []}
              />
            ))}
          </Grid>

        </Stack>
      </Container>
    </Box >
  )
}

export default Chapter