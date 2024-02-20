/* eslint-disable react/prop-types */
import { useState } from 'react';
import {
  Select, Stack, Typography, FormControl, MenuItem, InputLabel, Box,
  TableContainer, Table, TableRow, TableCell, TableBody, Paper, Checkbox, Button, TablePagination, Link as MuiLink
} from '@mui/material';
import Grid from '@mui/material/Unstable_Grid2';
import AddCircleIcon from '@mui/icons-material/AddCircle';
import { ABS_INS_URL } from '@/utils/constants/routeConst';
import { Link, useParams } from 'react-router-dom';
import { useEffect } from 'react';
import { useMutation, useQueryClient } from '@tanstack/react-query';
import { updateGroupAssignedChapterItem } from '@/utils/api';
import { useFormContext, useFieldArray } from 'react-hook-form';

// Sub-components
const TableContent = ({ lv, exerciseList, page, rowsPerPage, randomPools }) => {
  const handleChecked = (exerciseId) => {
    if (randomPools.value[String(lv)].includes(exerciseId)) {

      const updatedPools = {
        ...randomPools.value,
        [String(lv)]: randomPools.value[String(lv)].filter(id => id !== exerciseId)
      }
      randomPools.setValue(updatedPools)
    } else {

      const updatedPools = {
        ...randomPools.value,
        [String(lv)]: [...randomPools.value[String(lv)], exerciseId]
      }
      randomPools.setValue(updatedPools)
    }
  }

  const { groupId, chapterId } = useParams();

  return (
    <TableBody>
      {exerciseList.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage).map((ex, index) => (
        <TableRow
          key={index}
          sx={{
            cursor: "pointer",
            "td": {
              padding: "0px 16px",
              borderTop: "1px solid var(--raven)",
              borderBottom: "1px solid var(--raven)",
              fontSize: "16px",
            },
            "&:last-child td, &:last-child th": { border: "0" },
            ":hover": {
              bgcolor: "var(--hover)"
            }
          }}
        >
          <TableCell width={"10%"}>
            <Checkbox
              inputProps={{ "aria-label": "checkbox" }}
              sx={{
                height: "40px",
              }}
              checked={randomPools.value[String(lv)].includes(ex.exercise_id)}
              onClick={() => { handleChecked(ex.exercise_id) }}
            />
          </TableCell>
          <TableCell align="left">
            <MuiLink
              to={ABS_INS_URL.DYNAMIC.EDIT_EXERCISE(groupId, chapterId, lv, ex.exercise_id)}
              component={Link}
              sx={{
                color: "white",
                "&:hover": {
                  color: "var(--blueRibbon)",
                },
                textOverflow: "ellipsis"
              }}>{ex.lab_name}</MuiLink>
          </TableCell>
        </TableRow>
      ))}
    </TableBody>
  );
}

const arraysAreEqual = (arr1, arr2) => {
  const set1 = new Set(arr1);
  const set2 = new Set(arr2);

  if (set1.size !== set2.size) return false;

  const sortedArr1 = Array.from(set1).sort();
  const sortedArr2 = Array.from(set2).sort();

  return sortedArr1.every((value, index) => value === sortedArr2[index]);
}

const Actions = ({ groupId, chapterId, lv, selectedListFromAPI, randomPools }) => {
  const queryClient = useQueryClient();

  const { mutate: updateSelectedLabs } = useMutation({
    mutationFn: updateGroupAssignedChapterItem,
    onSuccess: () => {
      queryClient.invalidateQueries(['labChapterInfo', groupId, chapterId])
    }
  });

  const handleUpdate = () => {
    updateSelectedLabs({
      group_id: groupId,
      chapter_id: chapterId,
      item_id: lv,
      exercise_id_list: randomPools.value[String(lv)]
    });
  }

  const handleReset = () => {
    const updatedPools = {
      ...randomPools.value,
      [String(lv)]: selectedListFromAPI[String(lv)]
    }
    randomPools.setValue(updatedPools);
  }

  return (
    <Stack direction={"row"} alignItems={"center"} spacing={"10px"} justifyContent={"flex-end"}>
      <Button variant='contained' size='medium'
        onClick={handleUpdate}
        disabled={arraysAreEqual(selectedListFromAPI[String(lv)], randomPools.value[String(lv)])}
        sx={{
          fontSize: '16px',
          width: '120px',
          paddingY: "8px",
          borderRadius: "8px",
          bgcolor: "var(--cerulean )",
          textTransform: "none",
          flexShrink: "0",
        }}
      >Update</Button>
      {arraysAreEqual(selectedListFromAPI[String(lv)], randomPools.value[String(lv)]) ?
        (<Link to={ABS_INS_URL.DYNAMIC.ADD_EXERCISE(groupId, chapterId, lv)} >
          <Button variant='outlined' size='medium' sx={{
            width: '140px',
            paddingY: "6px",
            border: "2px solid",
            fontSize: '16px',
            textTransform: "none"
          }} startIcon={<AddCircleIcon size="small" color="primary" />} >Add Lab</Button>
        </Link>)
        :
        ((
          <Button variant='contained' color='error' size='medium'
            onClick={handleReset}
            sx={{
              textTransform: "none",
              //paddingX: "26px",
              width: '120px',
              paddingY: "8px",
              fontSize: '16px'
            }}>Reset</Button>
        ))
      }
    </Stack>
  )
};

const filterExercises = (rule, lv, selected) => {
  switch (rule) {
    case "all":
      return lv;
    case "selected":
      return lv.filter(ex => selected.includes(ex.exercise_id));
    case "Not selected":
      return lv.filter(ex => !selected.includes(ex.exercise_id));
    default:
      return lv;
  }
}

// Main Component
const LabLevel = ({ lv, index, selectedListFromAPI, randomPools }) => {
  const [filterRule, setFilterRule] = useState('all');
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(6);
  const [filteredList, setFilteredList] = useState(lv);
  const { groupId, chapterId, groupNo } = useParams();

  useEffect(() => {
    setFilteredList(filterExercises(filterRule, lv, randomPools.value[String(index + 1)]));
  }, [filterRule, lv, selectedListFromAPI, randomPools.value, index]);

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(+event.target.value);
    setPage(0);
  };

  return (
    <Grid xs={12} md={6}>
      <Stack spacing={"15px"} sx={{
        bgcolor: "var(--biscay)",
        borderRadius: "8px",
        padding: "20px",
      }}>
        {/* Filter UI */}
        <Stack direction={"row"} justifyContent={"space-between"} alignItems={"center"} >
          <Typography>Level {index + 1} - Exercises Pool</Typography>
          <Box width={"140px"}  >
            <FormControl size="small" fullWidth>
              <InputLabel id="filter-rule">Filter</InputLabel>
              <Select
                labelId="filter-rule"
                label="Type"
                value={filterRule}
                onChange={(e) => setFilterRule(e.target.value)}
              >
                <MenuItem value={"all"}>All</MenuItem>
                <MenuItem value={"selected"}>Selected</MenuItem>
                <MenuItem value={"Not selected"}>Not selected</MenuItem>
              </Select>
            </FormControl>
          </Box>
        </Stack>

        {/* Table */}
        <Box width={"100%"} /* height={"300px"} */ sx={{ overflowY: "auto" }} >
          <TableContainer component={Paper}>
            <Table size="small">
              {/* <TableHeader exerciseList={lv} selected={selected} setSelected={setSelected} /> */}
              <TableContent lv={index + 1} exerciseList={filteredList} page={page} rowsPerPage={rowsPerPage} randomPools={randomPools} />
            </Table>
          </TableContainer>
        </Box>

        {/* Pagination */}
        <TablePagination
          component="div"
          count={filteredList.length}
          page={page}
          onPageChange={handleChangePage}
          rowsPerPage={rowsPerPage}
          onRowsPerPageChange={handleChangeRowsPerPage}
          rowsPerPageOptions={[6, 12]}
        />

        {/* Actions */}
        <Actions groupId={groupId} groupNo={groupNo} chapterId={chapterId} lv={index + 1} selectedListFromAPI={selectedListFromAPI} randomPools={randomPools} />

      </Stack>
    </Grid>
  );
};

export default LabLevel 