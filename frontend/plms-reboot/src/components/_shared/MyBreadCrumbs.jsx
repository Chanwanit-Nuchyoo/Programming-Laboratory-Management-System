/* eslint-disable react/prop-types */
import { Breadcrumbs as MuiBreadcrumbs, Box, Typography } from '@mui/material';
import { NavigateNext } from '@mui/icons-material';
import { NavLink } from 'react-router-dom';

const MyBreadCrumbs = ({ items, lastItemColor = 'var(--cerulean)' }) => {
  return (
    <Box>
      <MuiBreadcrumbs
        separator={<NavigateNext fontSize="small" sx={{ color: 'white' }} />}
        aria-label="breadcrumb"
      >
        {items.map((item, index) => (
          <Typography
            key={index}
            component={NavLink}
            underline="none"
            to={item.href}
            sx={{
              color: index === items.length - 1 ? lastItemColor : 'white',
            }}
          >
            {item.label}
          </Typography>
        ))}
      </MuiBreadcrumbs>
    </Box>
  );
};

export default MyBreadCrumbs;
