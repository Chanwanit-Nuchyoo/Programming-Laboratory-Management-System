import { useEffect } from 'react';
import { Box, Stack, Container } from '@mui/material'
import Newspaper from '@/assets/images/newspapericon.svg'
import classes from '@/assets/css/Instruction.module.css'
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs'
import Header from '@/components/_shared/Header'

const Instruction = () => {

  const setSelected = useSetAtom(sidebarSelectedAtom);

  useEffect(() => {
    setSelected('instruction');
  }, [])

  return (
    <Box>
      <Container>
        <Stack spacing={"20px"}>

          <MyBreadCrumbs items={[
            { label: 'Instructions', href: '#' },
          ]} />

          <Header logoSrc={Newspaper} title="Instructions" />

          <Box sx={{
            padding: "2px 40px",
            bgcolor: "var(--biscay)",
            borderRadius: "20px",
            width: "100%",
            minHeight: "500px",
            color: "White",
            fontFamily: "ChakraPetch",
          }}>
            <div className={classes['Title']}>
              <text>ข้อแนะนำการใช้งาน</text>
            </div>
            <ol className={classes['rules']}>
              <li>เว็บไซต์นี้ถูกออกแบบมาเพื่อให้นักศึกษา ชั้นปีที่ 1 วิชา 01006012 Computer Programming, KMITL</li>
              <li>เพื่อการแสดงผลที่ดี แนะนำให้ใช้ Google Chrome หรือ Firefox</li>
              <li>Browser ที่ไม่แนะนำให้ใช้ Internet Explorer</li>
              <li>นักศึกษาต้องเขียนโปรแกรมในเครื่องตัวเอง แล้วอัพโหลด Source code (filename.py) เข้าไปในระบบ</li>
              <li>หลังจากใช้งานเสร็จให้ Log out ออกจากระบบ</li>
              <li>การเข้าระบบครั้งแรก ให้ใช้ รหัสนักศึกษาซึ่งเป็นตัวเลขจำนวน 8 ตัว ทั้ง username และ password</li>
              <li>ในการ Login ครั้งแรก หลังจาก Log in แล้ว ให้เปลี่ยน password และแก้ไขเพิ่มเติมข้อมูลให้ครบถ้วน รวมถึงอัพโหลดรูปภาพที่เห็นหน้าได้ชัด ไม่ใส่หน้ากาก</li>
              <li>ถ้านักศึกษา Login ไม่ได้ ให้แจ้งอาจารย์เพื่อ Reset password</li>
              <li>ให้นักศึกษาตรวจสอบว่า กลุ่มที่ ถูกต้องหรือไม่ (อยู่หน้า Home) ถ้าไม่ถูกต้องให้แจ้งอาจารย์</li>
              <li>แต่ละบท (Chapter) จะมีแบบฝึกหัด 5 ข้อ (Item) ข้อละ 2 คะแนน</li>
              <li>สามารถส่งได้ไม่จำกัดจำนวนครั้ง จนกว่าจะถูก ทั้งนี้เพื่อให้นักศึกษาได้ฝึกฝนด้วยตนเอง</li>
              <li>ถ้าส่งแล้วไม่ได้คะแนน อาจเป็น 0 หรือ -1 ก็ได้ แต่เมื่อส่งผ่านจะได้ 2 คะแนนต่อข้อ</li>
              <li>นักศึกษาไม่สามารถ Log in จากคอมพิวเตอร์ 2 เครื่องได้ในเวลาเดียวกัน</li>
              <li>Source code ที่ส่ง จะถูกใส่ Timestamp ไว้ที่ส่วนต้นของไฟล์ ซึ่งไม่มีผลต่อการทำงาน</li>
              <li>คำสั่งที่ไม่มีในบทเรียน ไม่แนะนำให้ใช้ ถ้าใช้นักศึกษาจะต้องรับความเสี่ยงกรณีที่ตรวจแล้วไม่ได้คะแนน</li>
              <li>หลังจากส่ง Source code แล้วไม่ผ่าน Test case จะมีการแสดงผลถึงตัวแรกที่ไม่ผ่าน</li>
              <li>Test case ที่ไม่แสดงผลอินพุท เรียกว่า Hidden test case</li>
              <li>อาจารย์สามารถเปิดหรือปิดแล็บเมื่อไหร่ก็ได้</li>
              <li>เมื่อเรียนบทเรียนแล้ว ควรทำแล็บให้เสร็จโดยเร็ว</li>
              <li>แล็บแต่ละ Chapter จะเปิดเป็นเวลาประมาณ 7 วัน</li>
              <li>Source code ที่ส่ง ห้ามมีคำว่า import</li>
            </ol>
          </Box>


        </Stack>
      </Container>
    </Box >
  )
}
export default Instruction