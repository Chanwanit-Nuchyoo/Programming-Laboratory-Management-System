import { Box, Stack, Container, Grid, Skeleton } from '@mui/material'
import folderIcon from '@/assets/images/foldericon.png'
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

          <Header logoSrc={folderIcon} title={isLoading ? "Loading..." : `Chapter ${chapterId} : ${labChapterInfo?.chapter_name}`} />

          <Grid container spacing={"10px"}>
            {isLoading && <>
              <Grid item xs={12} md={6}>
                <Skeleton variant='rounded' height={524} />
              </Grid>
              <Grid item xs={12} md={6}>
                <Skeleton variant='rounded' height={524} />
              </Grid>
              <Grid item xs={12} md={6}>
                <Skeleton variant='rounded' height={524} />
              </Grid>
              <Grid item xs={12} md={6}>
                <Skeleton variant='rounded' height={524} />
              </Grid>
            </>}
            {!isLoading && labLevelInfo?.map((lv, index) => (
              <LabLevel
                chapterName={labChapterInfo.chapter_name}
                key={index}
                lv={lv}
                index={index}
                selectedList={
                  selectedList[index + 1] && Object.keys(selectedList[index + 1]).length - 1 > index
                    ? Object.values(selectedList[index + 1])
                    : []
                }
              />
            ))}
          </Grid>

        </Stack>
      </Container>
    </Box >
  )
}

export default Chapter