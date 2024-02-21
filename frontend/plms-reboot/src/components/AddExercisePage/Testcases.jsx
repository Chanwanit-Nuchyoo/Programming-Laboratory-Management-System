/* eslint-disable react/prop-types */
import { Stack, Typography, Button } from "@mui/material"
import { useForm, FormProvider, useFieldArray } from 'react-hook-form';
import Testcase from "@/components/AddExercisePage/Testcase"
import { useParams } from "react-router-dom";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { getExerciseTestcases } from "@/utils/api";
import { useEffect, useState } from "react";
import AddCircleIcon from '@mui/icons-material/AddCircle';
import { saveExerciseTestcase } from "@/utils/api"
import testcaseIcon from '@/assets/images/testcaseicon.svg'
import { v4 as uuidv4 } from 'uuid';

const buttonProps = {
  size: 'medium',
  sx: { paddingX: "25px", borderRadius: "8px", textTransform: "none" },
  variant: 'contained',
};

const Testcases = ({ hasSourceCode = false }) => {
  const { exerciseId } = useParams();

  const { data, isLoading, status, refetch: refetchTestcaseData } = useQuery({
    queryKey: ['testcaseData', exerciseId],
    queryFn: () => getExerciseTestcases(exerciseId),
    /* refetchInterval: ({ state: { data } }) => {
      if (data && Array.isArray(data) && data.length !== 0) {
        if (data.every(testcase => testcase.is_ready === "yes")) {
          return false;
        } else {
          return 1000;
        }
      } else if (data && Array.isArray(data)) {
        return false;
      } else {
        return 1000;
      }
    }, */
  })
  const queryClient = useQueryClient();
  const { mutate: saveTestcases } = useMutation({
    mutationFn: saveExerciseTestcase,
    onSuccess: () => {
      queryClient.invalidateQueries(['testcaseData', exerciseId])
    }
  })

  const [isEditable, setIsEditable] = useState(false);
  const [originalTestcases, setOriginalTestcases] = useState([]);
  const methods = useForm({ defaultValues: { testcase_list: [], removedList: [] }, shouldUnregister: false });
  const { reset, control, handleSubmit, watch, formState: { isDirty } } = methods
  const { fields: testcaseData, append: appendTestcaseList, remove } = useFieldArray({ control, name: "testcase_list" });
  const watchedTestcaseData = watch("testcase_list");
  const watchedRemovedList = watch("removedList");
  const allTestcasesHaveInput = watchedTestcaseData.every(testcase => !!testcase.testcase_content);

  const handleCancel = () => {
    reset({ testcase_list: data || [], removedList: [] })
    setIsEditable(false)
  }

  const subscribeForResult = (jobId) => {
    const eventSource = new EventSource(`${import.meta.env.VITE_REALTIME_BASE_URL}/subscribe/testcase-result/${jobId}`);

    eventSource.onmessage = (event) => {
      refetchTestcaseData();
      eventSource.close();
    }
  }

  const handleSubmitedAll = (formData) => {
    const jobId = uuidv4();
    const requestBody = {
      "exercise_id": exerciseId,
      "testcase_list": formData.testcase_list,
      "removed_list": watchedRemovedList,
      "job_id": jobId,
    }
    subscribeForResult(jobId);
    saveTestcases(requestBody);
  }

  const handleSubmitEditedTestcase = (formData) => {
    const jobId = uuidv4();
    const requestBody = {
      "exercise_id": exerciseId,
      "testcase_list": [],
      "removed_list": watchedRemovedList,
      "job_id": jobId
    }

    const editedOrAddedTestcases = formData.testcase_list.filter((testcase, index) => {
      return testcase.testcase_content !== originalTestcases[index]?.testcase_content || testcase.testcase_note !== originalTestcases[index]?.testcase_note || testcase.show_to_student !== originalTestcases[index]?.show_to_student || testcase.active !== originalTestcases[index]?.active;
    });

    requestBody["testcase_list"] = editedOrAddedTestcases;

    subscribeForResult(jobId);
    setIsEditable(false);
    saveTestcases(requestBody);
  }

  const handleSubmitSingle = (formData, testcaseIndex) => {
    const jobId = uuidv4();
    const requestBody = {
      "exercise_id": exerciseId,
      "testcase_list": [],
      "removed_list": watchedRemovedList,
      "job_id": jobId
    }
    const testcase = formData.testcase_list[testcaseIndex];
    requestBody["testcase_list"].push(testcase);
    subscribeForResult(jobId);
    saveTestcases(requestBody);
    return
  }

  const handleAddNewTestcase = (event) => {
    event.preventDefault();
    appendTestcaseList({
      "testcase_id": null,
      "exercise_id": exerciseId,
      "testcase_note": "",
      "active": "no",
      "show_to_student": "no",
      "testcase_content": "",
      "testcase_error": "",
      "testcase_output": "",
      "is_ready": "no"
    })
  }

  useEffect(() => {
    if (!isLoading && data) {
      reset({ testcase_list: data, removedList: [] })
      setOriginalTestcases(data);
    }
  }, [data, isLoading, reset])

  return (
    <>
      {
        <FormProvider {...methods} >
          <form onSubmit={(e) => e.preventDefault()}>
            <Stack spacing={"12px"} sx={{
              bgcolor: 'var(--biscay)',
              padding: "20px",
              //border: "1px solid #202739",
              borderRadius: "8px",
            }} >
              {/* <Testcase /> */}
              <Stack direction={"row"} justifyContent={"space-between"} >
                <Typography sx={{ color: '#0ca6e9', fontSize: '18px', fontWeight: 'bold', display: 'flex', alignItems: 'center' }} >
                  <img src={testcaseIcon} alt="Testcase Icon" style={{ marginRight: '8px' }} /> Test case
                </Typography>
                <Stack direction={"row"} spacing={"10px"} >
                  <>
                    {isEditable ?
                      <>
                        <Button {...buttonProps} disabled={!isDirty || !allTestcasesHaveInput} onClick={handleSubmit(handleSubmitEditedTestcase)}
                          sx={{
                            width: '120px',
                            height: '40px',
                            fontSize: '16px'
                          }}>Save</Button>
                        <Button {...buttonProps} color="error" type="button" onClick={handleCancel}
                          sx={{
                            width: '120px',
                            height: '40px',
                            fontSize: '16px'
                          }}>Cancel</Button>
                      </>
                      :
                      <>
                        <Button {...buttonProps} color={'error'} type="button" onClick={handleSubmit(handleSubmitedAll)}
                          sx={{
                            width: '160px',
                            height: '40px',
                            fontSize: '16px',
                          }}>Run All Testcase</Button>
                        <Button {...buttonProps} type="button" onClick={() => { setIsEditable(true) }}
                          sx={{
                            width: '120px',
                            height: '40px',
                            fontSize: '16px'
                          }}>Edit</Button>
                      </>
                    }
                  </>
                </Stack>
              </Stack>
              <Stack direction={'row'} >
                {isEditable && <Button {...buttonProps} type="submit" variant={"outlined"} startIcon={<AddCircleIcon size="small" />} onClick={handleAddNewTestcase}
                  sx={{
                    width: '220px',
                    height: '40px',
                    fontSize: '16px',
                    borderRadius: '24px',
                    border: 'solid 2px'
                  }}>Add New Testcase</Button>}
              </Stack>
              {!isLoading &&
                <>
                  {Array.isArray(testcaseData) && testcaseData.length > 0 ?
                    [...testcaseData].reverse().map((item, reversedIndex) => {
                      const realIndex = testcaseData.length - 1 - reversedIndex;
                      const originalTestcase = item.testcase_id === null ? null : originalTestcases.filter(testcase => testcase.testcase_id === item.testcase_id)[0];
                      return <Testcase key={item.id} realIndex={realIndex} originalTestcase={originalTestcase} testcase={item} remove={remove} editable={isEditable} submitFn={handleSubmitSingle} />
                    })
                    :
                    <Stack direction="row" justifyContent="center" alignItems="center" sx={{ borderRadius: "8px", bgcolor: "var(--mirage)", padding: "20px" }} >
                      <Typography sx={{ color: 'var(--text-color)', fontSize: '16px' }} >No test case available</Typography>
                    </Stack>
                  }
                </>
              }
            </Stack >
          </form>
        </FormProvider>
      }
    </>
  )
}

export default Testcases
