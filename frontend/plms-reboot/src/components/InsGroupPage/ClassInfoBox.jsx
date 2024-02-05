/* eslint-disable react/prop-types */
import { Stack } from '@mui/material'
import Grid from '@mui/material/Unstable_Grid2';
import classes from '@/assets/css/InsGroup.module.css'

const ClassInfoBox = ({ children, stackProps, gridProps }) => {
  return (
    <Grid xs={4} {...gridProps} >
      <Stack spacing={"10px"} className={classes['info-box']} padding={"20px"} {...stackProps} >
        {children}
      </Stack>
    </Grid>
  )
}

export default ClassInfoBox