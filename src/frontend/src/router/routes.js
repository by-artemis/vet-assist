import admin from './admin';
import customer from './customer';
import { ROUTE_PATH } from './route-path';

const routes = [
  // Dont Remove. Handle 404 Pages
  {
    path: '*',
    component: 'pages/guest/NotFound',
    auth: false,
  },
  {
    path: '/',
    component: 'pages/guest/Landing',
    auth: false,
  },
  {
    path: '/about',
    component: 'pages/guest/About',
    auth: false,
  },
  {
    path: '/signup',
    component: 'pages/guest/Signup',
    auth: false,
  },
  {
    path: '/login',
    component: 'pages/guest/Login',
    auth: false,
  },
  {
    path: '/forgot-password',
    component: 'pages/guest/ForgotPassword',
    auth: false,
  },
  {
    path: '/password/reset',
    component: 'pages/guest/ResetPassword',
    auth: false,
  },
  {
    path: '/activate',
    component: 'pages/guest/Activate',
    auth: false,
  },
  {
    path: '/profile',
    component: 'pages/authenticated/Profile',
    auth: true,
  },
  {
    path: '/terms',
    component: 'pages/guest/Terms',
    auth: false,
  },
  {
    path: '/faq',
    component: 'pages/guest/Faq',
    auth: false,
  },
  {
    path: '/inquiry',
    component: 'pages/guest/Inquiry',
    auth: false,
  },
  {
    path: '/privacy-policy',
    component: 'pages/guest/PrivacyPolicy',
    auth: false,
  },
  {
    path: ROUTE_PATH.orderManagement,
    component: 'pages/authenticated/Dashboard',
    auth: true,
  },
  // Pets
  {
    path: ROUTE_PATH.petIndex,
    component: 'pages/authenticated/Pet/Index',
    auth: true,
  },
  {
    path: ROUTE_PATH.petCreate,
    component: 'pages/authenticated/Pet/Create',
    auth: true,
  },
  {
    path: ROUTE_PATH.petEdit,
    component: 'pages/authenticated/Pet/Edit',
    auth: true,
  },
  {
    path: ROUTE_PATH.petView,
    component: 'pages/authenticated/Pet/View',
    auth: true,
  },
  ...admin,
  ...customer,
];

// Don't include styleguide in production routes
if (process.env.ENVIRONMENT !== 'production') {
  routes.push({
    path: '/styleguide',
    component: 'pages/guest/Styleguide',
    auth: false,
  });
}

export default routes;
