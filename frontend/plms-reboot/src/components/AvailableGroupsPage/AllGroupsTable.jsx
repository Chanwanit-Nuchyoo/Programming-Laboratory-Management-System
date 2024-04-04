import { Box, Stack, Tooltip } from '@mui/material';
import { useReactTable, getCoreRowModel, flexRender } from '@tanstack/react-table'
import { getClassNames } from "@/utils";
import { useMemo } from 'react'
import { userAtom } from "@/store/store";
import { useAtom } from "jotai";
import { useNavigate } from 'react-router-dom';
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import table from '@/assets/css/Table.module.css'
import TimeSchedule from "@/components/_shared/TimeSchedule";

const AllGroupsTable = ({ queryData }) => {
  const [user] = useAtom(userAtom);
  const navigate = useNavigate();

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
      cell: (info) => {
        return (
          <div style={{
            whiteSpace: 'nowrap',
            overflow: 'hidden',
            textOverflow: 'ellipsis'
          }}>
            <Tooltip title={info.getValue() || "no instructor"} >
              {info.getValue() || "no instructor"}
            </Tooltip>
          </div>
        );
      },
      size: 120,
    },
    {
      header: "Staffs",
      accessorKey: "lab_staff",
      cell: (info) => {
        const staffs = info.getValue();
        const staffNames = staffs.map(staff => `${staff.supervisor_firstname || ""} ${staff.supervisor_lastname || ""}`).join(', ');

        return (
          <div style={{
            whiteSpace: 'nowrap',
            overflow: 'hidden',
            textOverflow: 'ellipsis'
          }}>
            <Tooltip title={staffNames || "no staff"} >
              {staffNames || "no staff"}
            </Tooltip>
          </div>
        );
      }
    }
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
        {!queryData.isPending && getRowModel().rows.map((row) => {
          const rowData = row.original;
          let staffs = rowData.lab_staff.map(staff => staff.supervisor_id);
          staffs.push(rowData.lecturer);
          const staffSet = new Set(staffs);
          const isStaff = staffSet.has(user.id);

          return (
            <tr
              key={row.id}
              style={{ height: '66px', backgroundColor: isStaff && "var(--hover)", cursor: isStaff && 'pointer' }}
              onClick={isStaff ? () => {
                navigate(ABS_INS_URL.DYNAMIC.GROUP(rowData.group_id))
              } : null}
            >
              {row.getVisibleCells().map((cell, index) => (
                <td
                  key={cell.id}
                  style={{
                    width: `${cell.column.getSize()}px`,
                    textOverflow: 'ellipsis',
                    whiteSpace: 'nowrap',
                    overflow: 'hidden'
                  }}
                >
                  {flexRender(
                    cell.column.columnDef.cell,
                    cell.getContext()
                  )}
                </td>
              ))}
            </tr>
          )
        })}
      </tbody>
    </table>
  )
}

export default AllGroupsTable