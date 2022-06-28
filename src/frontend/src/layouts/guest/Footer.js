import { Box, Typography, Grid, Container, List } from '@mui/material';
import { blueGrey } from '@mui/material/colors';
import FooterLink from './components/FooterLink';
import { useTranslation } from 'react-i18next';

function Footer() {
  const currentYear = new Date().getFullYear();
  const { t } = useTranslation();

  const navigation = [
    { name: t('menu.inquiry'), url: '/inquiry' },
    { name: t('menu.faq'), url: '/faq' },
    { name: t('menu.terms'), url: '/terms' },
  ];

  const resources = [
    { name: t('menu.documentation'), url: '/#' },
    { name: t('menu.api_reference'), url: '/#' },
    { name: t('menu.support'), url: '/#' },
  ];

  return (
    <Box sx={{ py: 8, color: blueGrey['A100'], backgroundColor: blueGrey[900] }} component="footer">
      <Container>
        <Grid container spacing={4}>
          <Grid item xs={12} sm={4}>
            <Box sx={{ mb: 2 }}>
              <img src="/static/images/sprobe-logo.png" alt={process.env.REACT_APP_SITE_TITLE} />
            </Box>
            <Typography variant="body2" component="span">
              &copy; {currentYear} {process.env.REACT_APP_SITE_TITLE}.
            </Typography>
          </Grid>

          <Grid item xs={12} sm={4}>
            <Typography
              variant="body2"
              component="h5"
              sx={{ fontWeight: 600, textTransform: 'uppercase' }}
            >
              {t('labels.navigation')}
            </Typography>

            <List>
              {navigation.map((link, key) => {
                return <FooterLink label={link.name} url={link.url} key={key} />;
              })}
            </List>
          </Grid>

          <Grid item xs={12} sm={4}>
            <Typography
              variant="body2"
              component="h5"
              sx={{ fontWeight: 600, textTransform: 'uppercase' }}
            >
              {t('labels.resources')}
            </Typography>

            <List>
              {resources.map((link, key) => {
                return <FooterLink label={link.name} url={link.url} key={key} />;
              })}
            </List>
          </Grid>
        </Grid>
      </Container>
    </Box>
  );
}

export default Footer;
