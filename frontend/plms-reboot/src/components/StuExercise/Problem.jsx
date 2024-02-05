/* eslint-disable react/prop-types */
import { Stack, Typography, Box, Accordion, AccordionSummary, AccordionDetails } from "@mui/material"
import { RichTextReadOnly } from "mui-tiptap"
import { extensions } from "@/utils/tiptap-extensions"
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import TestcaseDisplay from "@/components/StuExercise/TestcaseDisplay";
import he from 'he';
import suggestedIcon from '@/assets/images/suggestedicon.svg'

const typeMessages = {
  "na": "X Not appear",
  "eq": "== Equal",
  "me": ">= More than or equal",
  "le": "<= Less than or equal"
}

const Con = ({ title, list }) => {
  const renderInfo = (item) => {
    if (item.type === "na") {
      return <Typography variant="body2" color="error" >{typeMessages[item.type]}</Typography>
    } else {
      return <>
        <Typography>{typeMessages[item.type]}</Typography>
        <Typography>{item.limit}</Typography>
      </>
    }
  }

  return <>
    {list.length > 0 &&
      <>
        <Typography variant="h6" >{title}</Typography>
        <Stack spacing='20px' paddingLeft="10px" >
          {list.map((item, index) => {
            return (
              <Stack direction='row' spacing='20px' key={index}>
                <Typography  >{item.keyword}</Typography>
                {renderInfo(item)}
              </Stack>
            )
          })}
        </Stack>
      </>
    }
  </>
}

const KeywordConstraint = ({ constraint }) => {
  const classes_con = constraint?.classes
  const imports_con = constraint?.imports
  const methods_con = constraint?.methods
  const functions_con = constraint?.functions
  const variables_con = constraint?.variables
  const reserved_words_con = constraint?.reserved_words

  const isArrayEmpty = array => array.length === 0;

  const isAllEmpty = isArrayEmpty(classes_con) && isArrayEmpty(imports_con) && isArrayEmpty(methods_con) && isArrayEmpty(functions_con) && isArrayEmpty(variables_con) && isArrayEmpty(reserved_words_con)

  return <>
    {isAllEmpty ?
      <Typography>No Keyword Constraints</Typography>
      :
      <Stack spacing="10px" marginBottom="20px" >
        <Con title='Reserved Words' list={reserved_words_con} />
        <Con title='Functions' list={functions_con} />
        <Con title='Methods' list={methods_con} />
        <Con title='Variables' list={variables_con} />
        <Con title='Imports' list={imports_con} />
        <Con title='Classes' list={classes_con} />
      </Stack>
    }
  </>
}

const Problem = ({ exercise }) => {
  const htmlString = exercise.lab_content;

  return (
    <Stack spacing="10px">
      <Typography variant="h6" >{exercise.lab_name}</Typography>

      {/* Content */}
      <Box paddingX="15px" >
        <RichTextReadOnly content={he.decode(htmlString)} extensions={extensions} />
      </Box>

      {/* Keyword Constraints */}
      <Box borderRadius={"8px"} >
        <Accordion sx={{ bgcolor: "transparent" }} >
          <AccordionSummary
            expandIcon={<ExpandMoreIcon />}
            sx={{ bgcolor: "var(--mirage)", borderRadius: "8px", overflow: "hidden" }}
          >
            <Box display="flex" alignItems="center" gap={1}>
              <img src={suggestedIcon} alt="Suggested Icon" />
              <Typography>Keyword Constraints:</Typography>
            </Box>
          </AccordionSummary>
          <AccordionDetails sx={{ bgcolor: "var(--biscay)", borderRadius: "8px" }} >
            {exercise.user_defined_constraints ?
              <KeywordConstraint constraint={exercise.user_defined_constraints} /> : <Typography>No Keyword Constraints</Typography>
            }
          </AccordionDetails>
        </Accordion>
      </Box>

      {/* Testcases */}
      {typeof exercise.testcase === 'string' ?
        <Typography sx={{ padding: "10px" }} >No Testcases</Typography>
        :
        <TestcaseDisplay hug testcaseList={exercise.testcase} />
      }
    </Stack>
  )
}

export default Problem