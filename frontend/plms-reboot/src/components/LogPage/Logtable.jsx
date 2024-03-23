import { Box, Stack, Typography, Tooltip } from '@mui/material';
import { useReactTable, getCoreRowModel, flexRender } from '@tanstack/react-table'
import { getClassNames } from "@/utils";
import { useMemo } from 'react'
import { statusProperties } from "@/utils";
import table from '@/assets/css/Table.module.css'
import moment from 'moment';

const negativeAction = [
  'log out',
  'logout all students',
  'repeat login. user logged out from old session.',
]

const actionKeyTitles = {
  "stu_id": "stu id",
  "status": "status",
  "submission_id": "sub id",
  "attempt": "attempt",
  "sourcecode_filename": "filename",
  "marking": "marking"
}

const ActionElement = ({ action }) => {
  if (typeof action === 'string') {
    return (
      <Tooltip title={action} >
        <Stack direction="row" spacing="5px">
          <Typography sx={{ bgcolor: negativeAction.includes(action) || ['reject'].includes(action.split(" ")[0]) ? "#F44336" : "var(--chathamBlue)", padding: "2.5px 10px", borderRadius: "30px" }} >Action</Typography>
          <Typography display="flex" alignItems="center" >: {action}</Typography>
        </Stack>
      </Tooltip>
    );
  }

  if (typeof action === 'object') {
    return (
      <Stack width="400px" >
        <Stack direction="row" spacing="5px" bgcolor={statusProperties[action.status].color} padding="5px 5px" borderRadius="8px 8px 0px 0px" >
          <Typography>Action</Typography >
          <Typography display="flex" alignItems="center" >: exercise submit</Typography>
        </Stack>
        <Box padding="10px" bgcolor="black" borderRadius="0px 0px 8px 8px" >
          {Object.entries(action).map(([key, value]) => (
            !['job_id'].includes(key) && (
              <Stack direction="row" spacing="5px" key={key}>
                <Typography textAlign="right" width="90px">{actionKeyTitles[key]}</Typography>
                <Typography display="flex" alignItems="center" >: {value === undefined || value === null ? 'running...' : value}</Typography>
              </Stack>
            )
          ))}
        </Box>
      </Stack>
    );
  }

  return null;
};


const Logtable = ({ queryData }) => {
  const columns = useMemo(() => [
    {
      header: "Time Stampt",
      accessorKey: "timestamp",
      cell: (info) => {
        const timestamp = moment(info.getValue());
        return (
          <Tooltip title={timestamp.format('YYYY-MM-DD HH:mm:ss')}>
            <Box textAlign="center" >{timestamp.format('YYYY-MM-DD HH:mm:ss')}</Box>
          </Tooltip>
        )
      },
      size: 70,
    },
    {
      header: "Remote IP",
      accessorKey: "remote_ip",
      size: 60,
      cell: (info) => {
        const ip = info.getValue();
        return (
          <Tooltip title={ip}>
            <Box textAlign="center" >{ip}</Box>
          </Tooltip>
        )
      },
    },
    {
      header: "User Agent",
      accessorKey: "agent",
      cell: (info) => {
        const agent = info.getValue();
        return (
          <Tooltip title={agent}>
            <Box textAlign="center" >{agent}</Box>
          </Tooltip>
        )
      },
      size: 80,
    },
    {
      header: "Page name",
      accessorKey: "page_name",
      cell: (info) => {
        const page_name = info.getValue();
        return (
          <Tooltip title={page_name}>
            <Box textAlign="center" >{page_name}</Box>
          </Tooltip>
        )
      },
      size: 50,
    },
    {
      header: "Username",
      accessorKey: "username",
      cell: (info) => <Tooltip title={info.getValue()}>
        <Box textAlign="center" >{info.getValue()}</Box>
      </Tooltip>,
      size: 40,
    },
    {
      header: "Action",
      accessorKey: "action",
      size: 200,
      cell: (info) => {
        const action = info.getValue();
        return (
          <Stack width="100%" alignItems="flex-start">
            <ActionElement action={action} />
          </Stack>
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
    <table style={{ tableLayout: 'fixed', width: '100%', overflowX: 'auto' }} className={getClassNames(table, "my-table-2")} >
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