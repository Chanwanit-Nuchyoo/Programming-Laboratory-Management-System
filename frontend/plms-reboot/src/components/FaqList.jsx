import Accordion from '@mui/material/Accordion';
import AccordionSummary from '@mui/material/AccordionSummary';
import AccordionDetails from '@mui/material/AccordionDetails';
import Typography from '@mui/material/Typography';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';

const FaqList = () => {
  return (
    <div>
      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel1a-content"
          id="panel1a-header"
        >
          <Typography>Python version อะไร</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            Python 3.12.0
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ถ้านักศึกษามีการย้ายกลุ่ม ต้องทำอย่างไร</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            ให้แจ้งอาจารย์ผู้สอน ว่าย้ายมาจากกลุ่มไหน
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ส่งแลปได้กี่ครั้ง</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            ส่งได้ไม่จำกัดจำนวนครั้ง จนกว่าจะได้คะแนนเต็ม
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ทำไมส่งแลปได้คะแนนเต็มแล้ว เข้าไปอีกครั้ง คะแนนเปลี่ยนไป</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            เนื่องจากระบบจะทำการตรวจใหม่ทุกครั้งเมื่อ กดเข้าไปดูรายละเอียด ถ้าโจทย์ หรือ testcase มีการเปลี่ยนแปลงก็จะทำให้ คะแนนที่ได้เปลี่ยนไปด้วย
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ลืมรหัสผ่านต้องทำอย่างไร</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            ให้แจ้งอาจารย์ เพื่อรีเซตรหัสผ่าน
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>Hidden test case คืออะไร</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            เป็น testcase ที่ไม่แสดงผลลัพธ์ออกทางหน้าจอ
            ที่ตั้งใจปิดไว้ ถ้าไม่ผ่าน ให้กลับไปอ่านโจทย์ คิดวิเคราะห์ ให้ถี่ถ้วน
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ถ้าผิดที่ hidden testcase ต้องทำอย่างไร</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            ให้กลับไปอ่านโจทย์อีกครั้ง ให้ละเอียด ถ้าไม่เข้าใจให้ปรึกษาอาจารย์ผู้สอน
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ใช้คำสั่งนอกเหนือจากที่เรียน ได้ไหม</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            โจทย์ทุกข้อ ไม่มีความจำเป็นต้องใช้คำสั่ง นอกเหนือจากที่เรียน หรือที่ระบุไว้ในโจทย์
            ไม่แนะนำให้ใช้คำสั่งนอกเหนือจากที่เรียน
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ทำไมถึงห้ามใช้ import</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            1. import ยังไม่มีความจำเป็นต้องใช้สำหรับการใช้งานพื่นฐาน
            2. การใช้ import จะทำให้บทเรียนมีความซับซ้อนมากขึ้น
            3. การใช้งาน import ถ้าใช้โดยไม่เข้าใจ จะทำให้ผิดกฎหมายได้
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>output ของ test case ยาวได้ขนาดเท่าไร</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            จำนวน byte ของ output ยาวได้ไม่เกิน 1 MB
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ทำไม ไม่มี testcase แสดงออกมา</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            ให้ตรวจสอบการรับอินพุท จำนวน input ต้องเป็นไปตามที่โจทย์กำหนด
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ต้องการ submit ไฟล์ใหม่ หลังจากได้คะแนนเต็มแล้ว ทำได้ไหม</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            ทำได้โดยแจ้ง อาจารย์ให้ทราบ พร้อมทั้งบอกเหตุผล
          </Typography>
        </AccordionDetails>
      </Accordion>

      <Accordion>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel2a-content"
          id="panel2a-header"
        >
          <Typography>ทดสอบได้ ในเครื่องตนเอง แต่ส่งไม่ผ่าน</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography>
            ให้ตรวจสอบ version ของ python
            ตรวจสอบ ตัวอักษร ใหญ่ เล็ก
            ตรวจสอบ ช่องว่างระหว่างตัวอักษร
          </Typography>
        </AccordionDetails>
      </Accordion>
    </div>
  );
}
export default FaqList