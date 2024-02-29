import { useMemo } from 'react'
import { useReactTable, getCoreRowModel, flexRender } from '@tanstack/react-table'
import { Link } from 'react-router-dom';
import { ABS_INS_URL } from '@/utils/constants/routeConst';
import { getClassNames } from "@/utils";
import { Typography, Link as MuiLink } from '@mui/material';
import classes from '@/assets/css/Table.module.css'

import PermissionDisplay from '@/components/InsGroupPage/PermissionDisplay';

const columnStyles = {
  Chapter: { minWidth: '' },
  Score: { minWidth: '80px' },
  ["Allow submit"]: { width: '350px', whiteSpace: 'nowrap' },
  ["Access exercise"]: { width: '350px', whiteSpace: 'nowrap' }
}

const permissionAccessorFn = (row, prefix) => {
  return {
    prefix: prefix,
    permissions: {
      allow_access_type: row.allow_access_type,
      access_time_start: row.access_time_start,
      access_time_end: row.access_time_end,
      allow_submit_type: row.allow_submit_type,
      submit_time_start: row.submit_time_start,
      submit_time_end: row.submit_time_end,
    },
    groupId: row.class_id,
    chapterId: row.chapter_id,
    lab: row
  };
}

const GroupLabsTable = ({ data }) => {

  /* 
  {
    "class_id": "22020000",
    "chapter_id": "1",
    "allow_access_type": "deny",
    "access_time_start": null,
    "access_time_end": null,
    "allow_submit_type": "deny",
    "submit_time_start": null,
    "submit_time_end": null,
    "allow_submit": "yes",
    "status": "na",
    "allow_access": "yes",
    "time_start": "00:00:00",
    "time_end": "00:00:00",
    "chapter_name": "Introduction",
    "chapter_fullmark": "10",
    "no_items": "5"
  }
  */

  /** @type import('@tanstack/react-table).ColumnDef<any> */
  const columns = useMemo(() => [
    {
      header: "Chapter",
      accessorFn: (row) => ({
        groupId: row.class_id,
        chapterId: row.chapter_id,
        chapterName: row.chapter_name,
        noItems: row.no_items,
      }),
      cell: (info) => {
        const { groupId, chapterId, chapterName, noItems } = info.getValue();
        return (
          <MuiLink to={ABS_INS_URL.DYNAMIC.CHAPTER(groupId, chapterId)} component={Link} color={'inherit'} underline='none' sx={{ ":hover": { color: "var(--blueRibbon)" } }} >
            <Typography style={{ paddingLeft: '20px' }}>{chapterId}. {chapterName} ({noItems})</Typography>
          </MuiLink>
        )
      }
    },
    {
      header: "Score",
      accessorKey: "chapter_fullmark"
    },
    {
      header: "Access exercise",
      accessorFn: (row) => permissionAccessorFn(row, 'access'),
      cell: (info) => <PermissionDisplay {...info.getValue()} />
    },
    {
      header: "Allow submit",
      accessorFn: (row) => permissionAccessorFn(row, 'submit'),
      cell: (info) => <PermissionDisplay {...info.getValue()} />
    }
  ], [])

  const { getHeaderGroups, getRowModel } = useReactTable({
    columns,
    data,
    getCoreRowModel: getCoreRowModel(),
  })

  return (
    <table className={getClassNames(classes, "my-table")} >
      <thead >
        {getHeaderGroups().map((headerGroup) => (
          <tr key={headerGroup.id} >
            {headerGroup.headers.map((header) => (
              <th
                key={header.id}
                style={columnStyles[header.column.columnDef.header]}
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
          <tr key={rows.id}>
            {rows.getVisibleCells().map(cell => {
              return (
                <td key={cell.id}>
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

export default GroupLabsTable