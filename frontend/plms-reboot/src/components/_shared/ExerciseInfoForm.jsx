/* eslint-disable react/prop-types */
import React, { useState, useRef, useEffect } from "react";
import { Stack, Typography, Button, TextField, Box } from "@mui/material";
import Grid from '@mui/material/Unstable_Grid2';
import { defaultCon } from '@/store/store';
import MyRte from '@/components/_shared/MyRte';
import MyCodeEditor from '@/components/_shared/MyCodeEditor';
import { useForm, Controller } from 'react-hook-form'
import KwCategory from '@/components/_shared/KwCategory';
import { useNavigate, useParams } from "react-router-dom";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { createExercise, updateExercise, getKeywordList, checkKeyword } from "@/utils/api";
import { getConstraintsFailedMessage } from '@/utils';
import { ABS_INS_URL } from "@/utils/constants/routeConst";
import levelIcon from '@/assets/images/levelicon.svg'
import suggestedIcon from '@/assets/images/suggestedicon.svg'
import addfileIcon from '@/assets/images/addfileicon.svg'
import codingIcon from '@/assets/images/codingicon.svg'

//import deleteIcon from '@/assets/images/deleteicon.svg'

const defaultValues = {
  lab_name: '',
  lab_content: '',
  sourcecode_content: '# Source code\n',
  keyword_constraints: {
    suggested_constraints: {
      "reserved_words": [],
      "functions": [],
      "methods": [],
      "variables": [],
      "imports": [],
      "classes": [],
    },
    user_defined_constraints: defaultCon
  },
}

const category_keys = ["reserved_words", "functions", "methods", "variables", "imports", "classes"]

const ExerciseInfoForm = ({ onAddExercisePage = false, lv, formData = defaultValues }) => {
  const navigate = useNavigate()
  const queryClient = useQueryClient()
  const { chapterId, level, groupId, exerciseId } = useParams()
  const { control, handleSubmit, getValues, setValue, watch, reset, formState: { isValid, errors, isDirty } } = useForm({ defaultValues: formData, mode: 'onBlur' });
  const [editable, setEditable] = useState(onAddExercisePage);
  const [isPyodideReady, setIsPyodideReady] = useState(false);
  const rteRef = useRef(null);
  const pyodideWorkerRef = useRef(null);
  const editor = rteRef.current?.editor;

  const { mutate: createNewExercse } = useMutation({
    mutationFn: createExercise,
    onSuccess: (data) => {
      navigate(ABS_INS_URL.DYNAMIC.EDIT_EXERCISE(groupId, chapterId, level, data.exercise_id))
    },
    onError: (err) => {
      console.log(err)
    }
  })

  const { mutate: updateExistingExercse } = useMutation({
    mutationFn: updateExercise,
    onSuccess: (data) => {
      queryClient.invalidateQueries(['edit-exercise-form', exerciseId])
    },
    onError: (err) => {
      console.log(err)
    }
  })

  const { mutate: getKwList } = useMutation({
    mutationFn: getKeywordList,
    onSuccess: (data) => {
      if (data.status === 'success') {
        setValue('keyword_constraints.suggested_constraints.reserved_words', data.data.reserved_words);
        setValue('keyword_constraints.suggested_constraints.functions', data.data.functions);
        setValue('keyword_constraints.suggested_constraints.methods', data.data.methods);
        setValue('keyword_constraints.suggested_constraints.variables', data.data.variables);
        setValue('keyword_constraints.suggested_constraints.imports', data.data.imports);
        setValue('keyword_constraints.suggested_constraints.classes', data.data.classes);
      } else {
        alert(data.message);
      }
    },
  })

  const handleCodeChecking = () => {
    const sourcecode = getValues('sourcecode_content')
    getKwList({
      sourcecode: sourcecode
    })
  }

  const handleCreateExercise = async (data) => {
    try {
      const newExercise = { ...data }
      newExercise.lab_chapter = chapterId
      newExercise.lab_level = level
      newExercise.testcase = 'no_input'
      newExercise.full_mark = 0

      checkKeyword({
        sourcecode: newExercise.sourcecode_content,
        exercise_kw_list: newExercise.keyword_constraints.user_defined_constraints
      }).then((res) => {
        if (res.status === 'passed') {
          createNewExercse(newExercise)
        } else {
          const message = getConstraintsFailedMessage(res);

          alert(message);
        }
      })

    } catch (err) {
      console.log(err)
    }
  }

  const handleUpdateExercise = (data) => {
    const updatedExercise = { ...data }
    updatedExercise.exercise_id = exerciseId

    checkKeyword({
      sourcecode: updatedExercise.sourcecode_content,
      exercise_kw_list: updatedExercise.keyword_constraints.user_defined_constraints
    }).then((res) => {
      if (res.status === 'passed') {
        updateExistingExercse(updatedExercise)
        setEditable(false)
      } else {
        const message = getConstraintsFailedMessage(res);
        alert(message);
      }
    })
  }

  const onSubmit = onAddExercisePage ? handleCreateExercise : handleUpdateExercise;

  useEffect(() => {
    reset(formData);
    if (editor) {
      editor
        .chain()
        .setContent(formData.lab_content)
        .run();
    }
  }, [editor, formData, reset]);

  const renderEditButtons = () => {
    if (onAddExercisePage) {
      return (
        <Stack direction="row" spacing={1}>
          <Button disabled={!isValid} type='submit' variant="contained" size="medium"
            sx={{
              width: '120px',
              height: '40px',
              fontSize: '16px',
              textTransform: 'none'
            }}>Submit
          </Button>
          <Button variant="contained" color="error" size="medium"
            sx={{
              width: '120px',
              height: '40px',
              fontSize: '16px',
              textTransform: 'none'
            }}
            onClick={() => navigate(ABS_INS_URL.DYNAMIC.CHAPTER(groupId, chapterId))}>
            Cancel
          </Button>
        </Stack>
      );
    } else if (editable) {
      return (
        <Stack direction="row" spacing={1}>
          <Button disabled={!isValid || !isDirty} type='submit' variant="contained" size="medium"
            sx={{
              width: '120px',
              height: '40px',
              fontSize: '16px',
              textTransform: 'none'
            }}>
            Save
          </Button>
          <Button variant="contained" color="error" size="medium"
            sx={{
              width: '120px',
              height: '40px',
              fontSize: '16px',
              textTransform: 'none'
            }}
            onClick={() => {
              setEditable(false)
              reset(formData)
              if (editor) {
                editor
                  .chain()
                  .setContent(formData.lab_content)
                  .run();
              }
            }} >
            Cancel
          </Button>
        </Stack>
      );
    } else {
      return (

        <Button variant="contained" size="medium"
          sx={{
            width: '120px',
            height: '40px',
            fontSize: '16px',
            textTransform: 'none'
          }}
          onClick={() => setEditable(true)}
        >Edit</Button>

      );
    }
  };

  const getCategoryTitle = (category) => {
    const words = category.split('_');
    const capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));
    return capitalizedWords.join(' ');
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)} >

      <Stack sx={{ padding: '20px', bgcolor: 'var(--biscay)', borderRadius: '8px' }}>
        <Stack direction="row" justifyContent="space-between" alignItems="center">
          <Typography sx={{ color: '#0ca6e9', fontSize: '18px', fontWeight: 'bold', display: 'flex', alignItems: 'center' }} >
            <img src={levelIcon} alt="Level Icon" style={{ marginRight: '10px' }} /> Level {lv}
          </Typography>
          {renderEditButtons()}
        </Stack>
        <Controller
          name="lab_name"
          control={control}
          rules={{ required: 'Lab name is required!' }}
          render={({ field }) => (
            <TextField {...field} label="Lab name" disabled={!editable} InputLabelProps={{ shrink: !!field.value }}
              sx={{ marginTop: 2, marginBottom: 2 }} />
          )}
        />

        <Controller
          name="lab_content"
          control={control}
          render={({ field }) =>
            <MyRte rteRef={rteRef} content={field.value} onUpdate={({ editor }) => field.onChange(editor.getHTML())} editable={editable} />
          }
        />

        <Stack spacing="10px" sx={{ marginTop: 2 }}>
          <Stack direction="row" justifyContent='space-between' alignItems="center" >
            <Stack direction="row" spacing="10px">
              <img src={codingIcon} alt="Addfile Icon" />
              <Typography>Source code :</Typography>
            </Stack>
            <Stack direction="row" spacing="10px">
              {editable && <Button variant="contained" onClick={handleCodeChecking} sx={{
                width: '150px',
                height: '40px',
                fontSize: '16px',
                textTransform: 'none'
              }} >Analyze Code</Button>}
            </Stack>
          </Stack>

          <Box height={400} sx={{ borderRadius: '8px', overflow: 'hidden' }}>
            <Controller
              name="sourcecode_content"
              control={control}
              rules={{ required: 'The content of exercise is required!' }}
              render={({ field: { onChange, onBlur, value } }) =>
                <MyCodeEditor
                  editable={editable}
                  className={!editable && "disabled-editor"}
                  onChange={onChange}
                  value={value}
                />
              }
            />
          </Box>
        </Stack>

        <Grid container spacing={1} sx={{ marginTop: 2 }}>
          <Grid xs={12} md={6}>
            <Box display="flex" alignItems="center" paddingBottom={2} sx={{ paddingLeft: 0 }}>
              <img src={suggestedIcon} alt="Suggested Icon" style={{ marginRight: '10px' }} />
              <Typography>Suggested Keyword Constraints:</Typography>
            </Box>
            <Stack spacing={"5px"}>
              {category_keys.map((category, index) => <KwCategory editable={editable} key={index} title={getCategoryTitle(category)} getValues={getValues} name={`keyword_constraints.suggested_constraints.${category}`} control={control} watch={watch} category={category} side={"suggested"} />)}
            </Stack>
          </Grid>
          <Grid xs={12} md={6}>
            <Box display="flex" alignItems="center" paddingBottom={2}>
              <img src={addfileIcon} alt="Addfile Icon" style={{ marginRight: '10px' }} />
              <Typography>User defined Keyword Constraints :</Typography>
            </Box>
            <Stack spacing={"5px"}>
              {category_keys.map((category, index) => <KwCategory editable={editable} key={index} title={getCategoryTitle(category)} getValues={getValues} name={`keyword_constraints.user_defined_constraints.${category}`} control={control} watch={watch} category={category} side={"user_defined"} />)}
            </Stack>
          </Grid>
        </Grid>

      </Stack>
    </form >
  )
}

export default ExerciseInfoForm