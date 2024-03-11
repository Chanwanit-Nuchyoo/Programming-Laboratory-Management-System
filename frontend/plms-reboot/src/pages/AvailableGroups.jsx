/* eslint-disable no-unused-vars */
import { Box, Button, Container, Stack, Typography, Pagination, Autocomplete, TextField, Accordion, AccordionSummary, AccordionDetails, Chip } from "@mui/material"
import peopleIcon from "@/assets/images/peopleicon.svg";
import { useState, useEffect } from "react"
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import { useQuery } from "@tanstack/react-query";
import { useSearchParams } from "react-router-dom";

// components
import Header from "@/components/_shared/Header";
import MyBreadCrumbs from "@/components/_shared/MyBreadCrumbs"
import AvgTableRow from "@/components/AvailableGroupsPage/AvgTableRow";
import AvgTableHead from "@/components/AvailableGroupsPage/AvgTableHead";
import AllGroupsTable from "@/components/AvailableGroupsPage/AllGroupsTable";
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import { getAllAvailableGroups } from "@/utils/api";

const CustomAutocomplete = ({ options, label, width, onChange, value }) => (
  <Autocomplete
    multiple
    disableCloseOnSelect
    options={options}
    value={value}
    renderInput={(params) => (
      <TextField {...params} variant="outlined" size="small" label={label} sx={{ width }} />
    )}
    renderTags={(value, getTagProps) =>
      value.map((option, index) => (
        <Chip
          label={option}
          {...getTagProps({ index })}
          sx={{ margin: 0.5 }}
          size="small"
        />
      ))
    }
    onChange={onChange}
  />
);

const AvailableGroups = () => {
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    year: "",
    sem: "",
    ins: "",
    day: "",
  });

  const [instructorOptions, setInstructorOptions] = useState([]);
  const [yearOptions, setYearOptions] = useState([]);
  const getSearchParam = (paramName) => {
    const paramValue = searchParams.get(paramName);
    return paramValue && paramValue !== '' ? paramValue.split(',') : [];
  };

  const [selectedYears, setSelectedYears] = useState(getSearchParam('year'));
  const [selectedSemester, setSelectedSemester] = useState(getSearchParam('sem'));
  const [selectedClassDate, setSelectedClassDate] = useState(getSearchParam('day'));
  const [selectedInstructor, setSelectedInstructor] = useState(getSearchParam('ins'));
  const setSelected = useSetAtom(sidebarSelectedAtom);

  const groupsQuery = useQuery({
    queryKey: ['available_groups', searchParams.toString()],
    queryFn: () => getAllAvailableGroups(searchParams.toString()),
    keepPreviousData: true,
  });

  const groups = groupsQuery.data?.group_list || [];

  useEffect(() => {
    setSelected('available_groups');
  }, [])

  useEffect(() => {
    //get all instructors name from groups
    const instructors = groupsQuery.data?.instructor_list || [];
    const years = groupsQuery.data?.year_list || [];
    setInstructorOptions(instructors.map(ins => `${ins.supervisor_firstname} ${ins.supervisor_lastname || ""}`));
    setYearOptions(years);
  }, [groupsQuery.isPending, setSelected])

  return (
    <Box>
      <Container>
        <Stack spacing={"20px"} >
          <MyBreadCrumbs items={[
            { label: 'Available Groups', href: '#' },
          ]} />

          <Header logoSrc={peopleIcon} title="Variables Expression Statement" />

          {/* Filter section */}
          <Stack spacing="10px" >
            <Accordion>
              <AccordionSummary
                expandIcon={<ExpandMoreIcon />}
                aria-controls="panel1-content"
                id="panel1-header"
              >
                <Typography  >Filter Options</Typography>
              </AccordionSummary>
              <AccordionDetails>
                <form>
                  <Stack spacing="20px" >
                    <Stack direction="row" justifyContent="space-evenly">
                      <CustomAutocomplete
                        options={instructorOptions}
                        label="Instructors"
                        width={400}
                        value={selectedInstructor}
                        onChange={(event, value) => setSelectedInstructor(value)}
                      />
                      <CustomAutocomplete
                        options={yearOptions}
                        label="Years"
                        width={200}
                        value={selectedYears}
                        onChange={(event, value) => setSelectedYears(value)}
                      />
                      <CustomAutocomplete
                        options={['1', '2', '3']}
                        label="Semeters"
                        width={200}
                        value={selectedSemester}
                        onChange={(event, value) => setSelectedSemester(value)}
                      />
                      <CustomAutocomplete
                        options={["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]}
                        label="Class Date"
                        width={200}
                        value={selectedClassDate}
                        onChange={(event, value) => setSelectedClassDate(value)}
                      />
                    </Stack>
                    <Stack direction="row" spacing="10px" justifyContent="flex-end" sx={{ paddingRight: "22px" }} >
                      <Button
                        variant="contained"
                        type="button"
                        onClick={() => {
                          setSearchParams(prev => {
                            prev.set('year', selectedYears.join(','));
                            prev.set('sem', selectedSemester.join(','));
                            prev.set('ins', selectedInstructor.join(','));
                            prev.set('day', selectedClassDate.join(','));
                            return prev;
                          });
                        }}
                        sx={{ width: "100px" }}
                      >
                        Filter
                      </Button>
                      <Button
                        variant="contained"
                        type="button"
                        color="error"
                        onClick={() => {
                          setSelectedYears([]);
                          setSelectedSemester([]);
                          setSelectedClassDate([]);
                          setSelectedInstructor([]);
                          setSearchParams(prev => {
                            prev.set('year', '');
                            prev.set('sem', '');
                            prev.set('ins', '');
                            prev.set('day', '');
                            return prev;
                          });
                        }}
                        sx={{ width: "100px" }}
                      >
                        Reset
                      </Button>
                    </Stack>
                  </Stack>
                </form>
              </AccordionDetails>
            </Accordion>
          </Stack>

          {/* New table */}
          <Stack>
            <AllGroupsTable queryData={groupsQuery} />
            <Stack direction="row" justifyContent="flex-end" >
              <Pagination
                count={groupsQuery.data?.number_of_pages || 1}
                defaultPage={1}
                page={parseInt(searchParams.get("page")) || 1}
                onChange={(e, page) => {
                  setSearchParams(prev => {
                    prev.set('page', page)
                    return prev;
                  });
                }}
              />
            </Stack>
          </Stack>

        </Stack>
      </Container>
    </Box >
  )
}

export default AvailableGroups
