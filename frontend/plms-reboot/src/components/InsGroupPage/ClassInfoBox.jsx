/* eslint-disable react/prop-types */
import { Grid, Stack } from '@mui/material'
import classes from '@/assets/css/InsGroup.module.css'

const ClassInfoBox = ({ children, stackProps, gridProps }) => {
  return (
    <Grid item xs={4} {...gridProps} >
      <Stack spacing={"10px"} className={classes['info-box']} padding={"20px"} {...stackProps} >
        {children}
      </Stack>
    </Grid>
  )
}

export default ClassInfoBox