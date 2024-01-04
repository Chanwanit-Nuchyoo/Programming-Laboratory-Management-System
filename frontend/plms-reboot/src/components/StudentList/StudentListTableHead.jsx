/* eslint-disable react/prop-types */
import { Box, Button, Stack, Skeleton } from "@mui/material";
import { buttonStyle } from "@/utils";

const buttonStyleExtended = { ...buttonStyle, minHeight: "63.48px" };
const buttons = [
  { label: "Avatar", boxProps: { flex: 1.5, width: 120 } },
  { label: "Student ID", boxProps: { flex: 1, width: 150 } },
  { label: "Name", boxProps: { width: 250 } },
]

const defaultBoxProps = { width: 85 }
const commonStackStyle = {
  position: "sticky",
  bgcolor: "var(--ebony)",
  zIndex: "10",
}
const TableHeadButton = ({ label, boxProps }) => (
  <Box {...boxProps} className="table-head-column">
    <Button fullWidth sx={buttonStyleExtended} >{label}</Button>
  </Box>
)
const StudentListTableHead = ({ isLoading, labInfo }) => {

  return (
    <>
      <Stack direction="row" spacing="5px" width="fit-content" sx={{ ...commonStackStyle, top: "-1px", paddingY: "10px" }} >
        <Stack direction="row" spacing="5px" sx={{ ...commonStackStyle, left: "0px" }} >
          {buttons.map((button, index) => (
            <TableHeadButton key={index} {...button} />
          ))}
        </Stack>
        {isLoading && Array.from({ length: 11 }).map((_, index) => (
          <Skeleton key={index} variant="rounded" width={85} height={63.48} animation="wave" />
        ))}
        {!isLoading && labInfo.map((lab, index) => (
          <TableHeadButton key={index} label={`Lab ${index + 1}\n(${lab.chapter_fullmark})`} boxProps={defaultBoxProps} />
        ))}
        {!isLoading && (
          <TableHeadButton label="Total" boxProps={defaultBoxProps} />
        )}
      </Stack>

      {isLoading && Array.from({ length: 4 }).map((_, index) => (
        <Skeleton key={index} variant="rounded" width={1520} height={120} />
      ))}
    </>
  );
};

export default StudentListTableHead