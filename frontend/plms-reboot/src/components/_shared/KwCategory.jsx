/* eslint-disable react/prop-types */
import { useState, useEffect } from "react";
import { Stack, Typography, Box, AccordionSummary, Accordion, AccordionDetails, Link } from "@mui/material";
import { useFieldArray } from 'react-hook-form'
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import SuggestedRule from '@/components/_shared/SuggestedRule';
import UserDefinedRule from '@/components/_shared/UserDefinedRule';

const KwCategory = ({ title, editable, name, control, category, getValues, side, watch }) => {
  const [isExpanded, setIsExpanded] = useState(false);

  const { append: appendUserDefined, remove: removeUserDefined } = useFieldArray({
    name: `keyword_constraints.user_defined_constraints.${category}`,
    control: control,
  })

  const fields = side === "suggested" ? watch(`keyword_constraints.suggested_constraints.${category}`) : watch(`keyword_constraints.user_defined_constraints.${category}`)

  useEffect(() => {
    // Check if there are items in the fields array and expand accordingly
    if (fields.length > 0) {
      setIsExpanded(true);
    } else {
      setIsExpanded(false);
    }
  }, [fields, category]);

  return <Accordion expanded={isExpanded} onChange={() => { setIsExpanded(prev => !prev) }} sx={{ borderRadius: "8px", overflow: "hidden" }} disableGutters>
    <AccordionSummary
      expandIcon={<ExpandMoreIcon />}
      sx={{ bgcolor: side === "user_defined" ? "var(--hover)" : "" }}
    >
      <Typography >{title} ({fields.length})</Typography>
    </AccordionSummary>
    <AccordionDetails sx={{ bgcolor: side === "user_defined" ? "var(--hover)" : "" }} >
      <Stack>
        <Stack spacing={1} >
          {/* Suggested Keyword Constraints */}
          {side === "suggested" && fields.length !== 0 && fields?.map((rule, index) => (
            <SuggestedRule key={index} editable={editable} control={control} name={name} index={index} append={appendUserDefined} getValues={getValues} />
          ))}

          {/* User Defined Keyword Constraints */}
          {side === "user_defined" && fields.length !== 0 && fields?.map((rule, index) => (
            <UserDefinedRule key={index} editable={editable} control={control} name={name} index={index} append={appendUserDefined} remove={removeUserDefined} getValues={getValues} />
          ))}

          {fields.length === 0 && <Typography paddingLeft={2} sx={{ color: "var(--frenchGray)" }} >No constraints added yet.</Typography>}
          {editable && side === "user_defined" && <Box paddingLeft={2} sx={{ marginLeft: "20px" }} >
            <Link onClick={() => {
              appendUserDefined({
                keyword: "",
                active: true,
                type: "eq",
                limit: 1,
              })
            }} sx={{ cursor: "pointer" }} >Add new keyword constrain</Link>
          </Box>}
        </Stack>
      </Stack>
    </AccordionDetails>
  </Accordion >
}

export default KwCategory;