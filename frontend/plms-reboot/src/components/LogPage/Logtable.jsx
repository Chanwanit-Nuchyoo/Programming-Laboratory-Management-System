import { Box, Stack } from '@mui/material';
import { useReactTable, getCoreRowModel, flexRender } from '@tanstack/react-table'
import { getClassNames } from "@/utils";
import { useMemo } from 'react'
import table from '@/assets/css/Table.module.css'
import TimeSchedule from "@/components/_shared/TimeSchedule";

const Logtable = ({queryData}) => {
    const columns = useMemo(() => [
        {
            header: "Username",
            accessorKey: "stu_id",
            cell: (info) => <Box textAlign="center" >{info.getValue()}</Box>,
            size: 40,
        },
        {
            header: "Remote Ip",
            accessorKey: "remote_ip",
            size: 40,
        },
        {
            header: "pagename",
            accessorKey: "pagename",
            size: 40,
        },
        {
            header: "agent",
            accessorKey: "agent",
            size: 100,
        },
        {
            header: "action",
            accessorKey: "action",
            size: 200,
            cell: (info) => {
              const actionObject = info.getValue();
              return (
                  <Box>
                      {Object.entries(actionObject).map(([key, value]) => (
                          <div key={key}>
                              {key}: {value}
                          </div>
                      ))}
                  </Box>
              );
          },
        },

    ], [])

    const { getHeaderGroups, getRowModel } = useReactTable({
      columns,
      data: queryData/* .data?.group_list */ || [],
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
export default Logtable