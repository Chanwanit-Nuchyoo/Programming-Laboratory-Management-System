import { Box, Stack } from '@mui/material';
import { useReactTable, flexRender, getCoreRowModel } from '@tanstack/react-table';
import { getClassNames } from "@/utils";
import { useMemo } from "react"
import { useParams } from "react-router-dom";

import table from '@/assets/css/Table.module.css'
import classes from "@/assets/css/StudentList.module.css";
import useOnlineStudentsList from "@/hooks/useOnlineStudentsList";
import StudentAvatarCell from '@/components/StudentList/StudentAvatarCell';
/* 
  {
    "stu_id": "63010177",
    "stu_firstname": "ชญานิน",
    "stu_lastname": "เลียงจินดาถาวร",
    "stu_nickname": "",
    "stu_gender": "male",
    "stu_dob": null,
    "stu_avatar": null,
    "stu_email": "",
    "stu_tel": "",
    "stu_group": "22020000",
    "note": null,
    "stu_dept_id": null,
    "mid_score": "0",
    "id": "63010177",
    "username": "63010177",
    "password": "56253ac3177fffe0ed6aae5e110b6909",
    "role": "student",
    "added": "2023-01-10 16:42:15",
    "last_login": "2024-02-19 23:03:11",
    "last_seen": "2024-02-19 23:05:28",
    "status": "offline",
    "active": "yes",
    "added_by": "kanut",
    "ci_session": "0",
    "session_id": null,
    "chapter_score": {
        "1": 10,
        "2": 10,
        "3": 4,
        "4": 0,
        "5": 10,
        "6": 2,
        "7": 0,
        "8": 0,
        "9": 0,
        "10": 0,
        "11": 0,
        "12": 0,
        "13": 0,
        "14": 0,
        "15": 0,
        "16": 0,
        "17": 0
    }
}
*/
const columnStyles = {
  "Avatar": { width: '130px' },
  "Student ID": { width: '150px' },
  "Name": { width: '300px' },
  "lab": { width: '100px' }
}

const StudentListTable = ({ isPending, labInfo, data }) => {
  const { groupId } = useParams();
  const onlineStudentsList = useOnlineStudentsList(groupId);

  /** @type import('@tanstack/react-table).ColumnDef<any> */
  const columns = useMemo(() => [
    {
      header: "Avatar",
      accessorFn: (row) => ({
        stu_id: row.stu_id,
        stu_avatar: row.stu_avatar,
      }),
      cell: (info) => {
        const { stu_id, stu_avatar } = info.getValue()
        return (<StudentAvatarCell groupId={groupId} stuId={stu_id} avatar={stu_avatar} onlineStudentsList={onlineStudentsList} />)
      }
    },
    {
      header: "Student ID",
      accessorKey: "stu_id",
    },
    {
      header: "Name",
      accessorFn: (row) => ({
        full_name: `${row.stu_firstname} ${row.stu_lastname}`,
        nickname: row.stu_nickname,
      }),
      cell: (info) => {
        const { full_name, nickname } = info.getValue()
        return (
          <Stack width="100%" justifyContent="center" alignItems="flex-start" paddingX="10px" >
            <Box>{full_name}</Box>
            <Box>{nickname && `(${nickname})`}</Box>
          </Stack>
        )
      }
    },
    ...labInfo.map((lab, index) => ({
      header: `Lab ${index + 1} (10)`,
      accessorFn: (row) => row.chapter_score[index + 1],
    })),
    {
      header: "Total",
      accessorFn: (row) => Object.values(row.chapter_score).reduce((acc, score) => acc + score, 0),
    }
  ], [labInfo])

  const { getHeaderGroups, getRowModel } = useReactTable({
    columns,
    data,
    getCoreRowModel: getCoreRowModel(),
  })

  return (
    <table style={{ tableLayout: 'fixed', width: '100%', overflowX: 'auto' }} className={getClassNames(table, "my-table")} >
      <thead>
        {getHeaderGroups().map((headerGroup) => (
          <tr key={headerGroup.id}>
            {headerGroup.headers.map((header, index) => (
              <th
                key={header.id}
                style={{
                  ...(['Avatar', 'Student ID', 'Name'].includes(header.column.columnDef.header) ?
                    { ...columnStyles[header.column.columnDef.header], minWidth: '150px' }
                    :
                    { ...columnStyles['lab'], minWidth: '150px' }),
                  position: 'sticky',
                  top: 0, // stick to top
                  left: index < 3 ? `${index * 150 - (index >= 1 && 20)}px` : 'auto',
                  background: "var(--mirage)",
                  zIndex: index < 3 ? 20 : 15,
                }}
              >
                {flexRender(
                  header.column.columnDef.header,
                  header.getContext()
                )}
              </th>
            ))}
          </tr>
        ))}
      </thead>
      <tbody>
        {getRowModel().rows.map((rows) => (
          <tr key={rows.id} className={getClassNames(classes, "student-rows")} >
            {rows.getVisibleCells().map((cell, index) => {
              return (
                <td key={cell.id} style={{
                  position: 'sticky',
                  left: index < 3 ? `${index * 150 - (index >= 1 && 20)}px` : 'auto',
                  zIndex: index < 3 ? 10 : 0,
                }}>
                  {flexRender(
                    cell.column.columnDef.cell,
                    cell.getContext()
                  )}
                </td>
              )
            })}
          </tr>
        ))}
      </tbody>
    </table>
  )
}

export default StudentListTable