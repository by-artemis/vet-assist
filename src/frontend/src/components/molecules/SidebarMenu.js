import { useSelector } from 'react-redux';
import { Link, useLocation } from 'react-router-dom';
import DashboardIcon from '@mui/icons-material/Dashboard';
import LayersIcon from '@mui/icons-material/Layers';
import PeopleIcon from '@mui/icons-material/People';
import PetsIcon from '@mui/icons-material/Pets';
import RoomPreferencesIcon from '@mui/icons-material/RoomPreferences';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import Typography from '@mui/material/Typography';

const links = [
  {
    label: 'Dashboard',
    path: '/admin',
    icon: <DashboardIcon />,
  },
  {
    label: 'Users',
    path: '/admin/users',
    icon: <PeopleIcon />,
  },
  {
    label: 'Roles',
    path: '/admin/roles',
    icon: <RoomPreferencesIcon />,
  },
  {
    label: 'Pets',
    path: '/pets',
    icon: <PetsIcon />,
  },
  {
    label: 'Integrations',
    path: '/admin/integrations',
    icon: <LayersIcon />,
  },
];

function SidebarMenu() {
  const location = useLocation();
  let localizeLinks = [...links];
  const user = useSelector((state) => state.profile.user);
  const { role } = user;

  // add localization to menu items
  localizeLinks.map((link) => {
    if (link.path.includes('admin') && role !== 'System Admin') {
      localizeLinks = localizeLinks.filter((item) => item !== link);
    }
    // link.label = t(`menu.${link.path.replace('/admin/', '')}`);
    return link;
  });

  return (
    <>
      {localizeLinks.map((item, key) => {
        return (
          <ListItemButton
            key={key}
            component={Link}
            to={item.path}
            selected={location.pathname === item.path}
          >
            <ListItemIcon sx={{ marginLeft: '5px' }}>{item.icon}</ListItemIcon>
            <ListItemText primary={<Typography variant="body2">{item.label}</Typography>} />
          </ListItemButton>
        );
      })}
    </>
  );
}

export { links, SidebarMenu };
