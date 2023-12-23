/* eslint-disable react/prop-types */
import { Box, Button, Stack, TextField, Typography } from '@mui/material';
import KeywordCon from '@/components/AddExercisePage/KeywordCon';
import MyCodeEditor from '@/components/_shared/MyCodeEditor';
import MyRte from '@/components/_shared/MyRte';
import { useForm, Controller, useFieldArray } from 'react-hook-form';
import { useNavigate, useParams } from 'react-router-dom';
import { getKwConSourceCode } from '@/utils/pythonCode';
import { useRef, useState, useEffect } from 'react';
import { ABS_INS_URL } from '@/utils/constants/routeConst';
import { defaultCon } from '@/store/store';

const defaultValues = {
  lab_name: '',
  lab_content: '',
  sourcecode_content: '# Source code\n',
  keyword_constraints: {
    suggested_constraints: defaultCon,
    user_defined_constraints: defaultCon
  },
}

const ExerciseForm = ({ onAddExercisePage = false, lv, formData = defaultValues }) => {
  const navigate = useNavigate();
  const { groupId, chapterId } = useParams();
  const [isPyodideReady, setIsPyodideReady] = useState(false);
  const [editable, setEditable] = useState(onAddExercisePage);
  const { control, setValue, getValues, handleSubmit, reset } = useForm({ defaultValues: formData });
  const onSubmit = data => console.log(data);
  const rteRef = useRef(null);
  const pyodideWorkerRef = useRef(null);
  const editor = rteRef.current?.editor;

  useEffect(() => {
    reset(formData);
    if (editor) {
      editor
        .chain()
        .setContent(formData.lab_content)
        .run();
    }
    pyodideWorkerRef.current = new Worker('/workers/pyodideWorker.js');

    pyodideWorkerRef.current.onmessage = ({ data }) => {
      if (data.status === 'initialized') {
        setIsPyodideReady(true);
        console.log(data.message);
      } else if (data.status === 'success') {
        // Handle success response here
        const prevKeywordCon = getValues('keyword_constraints');
        const newKeywordCon = { ...prevKeywordCon, suggested_constraints: data.data };
        setValue('keyword_constraints', newKeywordCon);
      } else {
        alert(data.message);
      }
    };

    return () => {
      if (pyodideWorkerRef.current) {
        pyodideWorkerRef.current.terminate();
      }
    };
  }, []);

  useEffect(() => {
    reset(formData);
  }, [editor, formData, reset]);

  const handleKeywordAnalyzer = (pythonCode) => {
    if (!isPyodideReady) {
      console.warn('Pyodide is not ready yet.');
      alert('Pyodide is not ready yet.');
      return;
    }

    if (!editable) return;

    pyodideWorkerRef.current.postMessage({ pythonCode: getKwConSourceCode(pythonCode) });
  };

  const handleCancelAdd = () => {
    navigate(ABS_INS_URL.DYNAMIC.CHAPTER(groupId, chapterId));
  };

  const renderEditButtons = () => {
    if (onAddExercisePage) {
      return (
        <Stack direction="row" spacing={1}>
          <Button type='submit' variant="outlined" size="medium" onClick={() => { }}>
            Submit
          </Button>
          <Button variant="contained" color="error" size="medium" onClick={handleCancelAdd}>
            Cancel
          </Button>
        </Stack>
      );
    } else if (editable) {
      return (
        <Stack direction="row" spacing={1}>
          <Button type='submit' variant="outlined" size="medium">
            Save
          </Button>
          <Button variant="contained" color="error" size="medium" onClick={() => {
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
        <Button variant="contained" size="medium" onClick={() => setEditable(true)}>
          Edit
        </Button>
      );
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <Stack spacing={2} sx={{ padding: '20px', border: '1px solid #202739', borderRadius: '8px' }}>
        <Stack direction="row" justifyContent="space-between" alignItems="center">
          <Typography variant="h6">Level {lv}</Typography>
          {renderEditButtons()}
        </Stack>
        <Controller
          name="lab_name"
          control={control}
          render={({ field }) => (
            <TextField  {...field} label="Lab name" disabled={!editable} InputLabelProps={{ shrink: !!field.value }} />
          )}
        />

        <Controller
          name="lab_content"
          control={control}
          render={({ field }) =>
            <MyRte rteRef={rteRef} content={field.value} onUpdate={({ editor }) => field.onChange(editor.getHTML())} editable={editable} />
          }
        />
        <Box height={400}>
          <Controller
            name="sourcecode_content"
            control={control}
            render={({ field }) =>
              <MyCodeEditor editable={editable} value={field.value} onChange={field.onChange} onBlur={() => { if (isPyodideReady) handleKeywordAnalyzer(field.value) }} />
            }
          />
        </Box>
        <Controller
          name="keyword_constraints"
          control={control}
          render={({ field }) => (
            <KeywordCon
              editable={editable}
              onChange={field.onChange}
              kwCon={{
                suggested_constraints: {
                  value: field.value.suggested_constraints,
                },
                user_defined_constraints: {
                  value: field.value.user_defined_constraints,
                }
              }}
            />
          )}
        />
      </Stack>
    </form >
  );
};

export default ExerciseForm;
