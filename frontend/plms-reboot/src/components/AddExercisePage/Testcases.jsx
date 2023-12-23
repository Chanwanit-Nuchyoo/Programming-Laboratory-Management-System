/* eslint-disable react/prop-types */
import { Stack, Typography, Button } from "@mui/material"
import { useForm, FormProvider, useFieldArray } from 'react-hook-form';
import Testcase from "@/components/AddExercisePage/Testcase"
import { useParams } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import { getExerciseTestcases } from "@/utils/api";
import { useEffect, useState } from "react";

const buttonProps = {
  size: 'medium',
  sx: { paddingX: "25px", borderRadius: "8px", textTransform: "none" },
  variant: 'contained',
};

const Testcases = ({ hasSourceCode = false }) => {
  const { exerciseId } = useParams();
  const { data, isLoading } = useQuery({
    queryKey: ['testcaseData', exerciseId],
    queryFn: () => getExerciseTestcases(exerciseId)
  })
  const [isEditable, setIsEditable] = useState(false);

  const methods = useForm({ defaultValues: { testcases: [] } });

  const { reset, control, handleSubmit, formState: { isDirty } } = methods
  const { fields: testcaseData, append, remove } = useFieldArray({ control, name: "testcases" });

  useEffect(() => {
    if (!isLoading && data) {
      reset({ testcases: data })
    }
  }, [data, isLoading, reset])

  const handleCancel = () => {
    reset({ testcases: data || [] })
    setIsEditable(false)
  }

  const handleSave = (data) => {
    console.log(data)
    setIsEditable(false)
  }

  return (
    <>
      {
        <FormProvider {...methods} >
          <form onSubmit={handleSubmit(handleSave)}>
            <Stack onSubmit={handleSubmit(handleSave)} spacing={"20px"} sx={{
              padding: "20px",
              border: "1px solid #202739",
              borderRadius: "8px",
            }} >
              {/* <Testcase /> */}
              <Stack direction={"row"} justifyContent={"space-between"} >
                <Typography variant='h6' >Test case</Typography>
                <Stack direction={"row"} spacing={"10px"} >
                  {hasSourceCode ?
                    <>
                      {isEditable ?
                        <>
                          <Button {...buttonProps} disabled={!isDirty} type="submit">Save</Button>
                          <Button {...buttonProps} color="error" type="button" onClick={handleCancel}>Cancel</Button>
                        </>
                        :
                        <Button {...buttonProps} type="button" onClick={() => { setIsEditable(true) }}>Edit</Button>
                      }
                    </>
                    :
                    (
                      <Button {...buttonProps} disabled={true} type="button" onClick={() => { setIsEditable(true) }}>Edit</Button>
                    )
                  }
                </Stack>
              </Stack>
              {testcaseData.map((item, index) => <Testcase key={item.id} index={index} control={control} editable={isEditable} />)}
            </Stack >
          </form>
        </FormProvider>
      }
    </>
  )
}

export default Testcases