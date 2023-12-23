import { useEffect } from 'react';
import { Box, Stack, Container } from '@mui/material'
import DialogBubble from '@/assets/images/dialogbubble.svg'
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "../store/store";

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import FaqList from '@/components/FaqList'
import Header from '@/components/_shared/Header'


const Examination = () => {
  const setSelected = useSetAtom(sidebarSelectedAtom);

  useEffect(() => {
    setSelected('faq');
  }, [])

  return (
    <Box>
      <Container>
        <Stack spacing={"20px"}>

          <MyBreadCrumbs items={[
            { label: 'FAQ', href: '#' },
          ]} />

          <Header logoSrc={DialogBubble} title="FAQ" />

          <FaqList />
        </Stack>
      </Container>
    </Box >
  )
}
export default Examination