import { Box, Stack } from '@mui/material';
import { useReactTable, getCoreRowModel, flexRender } from '@tanstack/react-table'
import { getClassNames } from "@/utils";
import { useMemo } from 'react'
import table from '@/assets/css/Table.module.css'
import TimeSchedule from "@/components/_shared/TimeSchedule";

const AllGroupsTable = ({ queryData }) => {

  const columns = useMemo(() => [
    {
      header: "Group ID",
      accessorKey: "group_id",
      cell: (info) => <Box textAlign="center" >{info.getValue()}</Box>,
      size: 90,
    },
    {
      header: "Group No",
      accessorKey: "group_no",
      size: 90,
    },
    {
      header: "Year",
      accessorKey: "year",
      size: 90,
    },
    {
      header: "Semester",
      accessorKey: "semester",
      size: 90,
    },
    {
      header: "Class Date",
      accessorFn: (row) => {
        return `${row.day_of_week + ", " + row.time_start + " - " + row.time_end}`
      },
      cell: (info) => (
        <Stack direction="row" justifyContent="center" alignItems="center" >
          <TimeSchedule classDate={info.getValue()} />
        </Stack>
      ),
      size: 190,
    },
    {
      header: "Students",
      accessorKey: "num_students",
      size: 60,
    },
    {
      header: "Instructor",
      accessorKey: "lecturer_name",
      size: 120,
    },
  ], [])

  const { getHeaderGroups, getRowModel } = useReactTable({
    columns,
    data: queryData.data?.group_list || [],
    getCoreRowModel: getCoreRowModel(),
  })

  return (
    <table style={{ tableLayout: 'fixed', width: '100%', overflowX: 'auto' }} className={getClassNames(table, "my-table")} >
      <thead>
        {getHeaderGroups().map((headerGroup) => (
          <tr key={headerGroup.id}>
            {headerGroup.headers.map((header, index) => {
              return (
                <th key={header.id} style={{ width: `${header.getSize()}px` }} >
                  {flexRender(
                    header.column.columnDef.header,
                    header.getContext()
                  )}
                </th>
              )
            })}
          </tr>
        ))}
      </thead>
      <tbody>
        {!queryData.isPending && getRowModel().rows.map((rows) => (
          <tr key={rows.id} className={getClassNames(table, 'hoverable')} style={{ height: '66px' }} >
            {rows.getVisibleCells().map((cell, index) => {
              return (
                <td key={cell.id} style={{ width: `${cell.column.getSize()}px`, textOverflow: 'ellipsis', whiteSpace: 'nowrap', overflow: 'hidden' }} >
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

export default AllGroupsTable