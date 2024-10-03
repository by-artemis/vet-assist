const petPath = {
  petIndex: '/pets',
  petCreate: '/pets/create',
  petEdit: '/pets/edit/:id',
  petView: '/pets/view/:id',
};

export const ROUTE_PATH = {
  ...petPath,

  dashboard: '/dashboard',
  about: '/about',
  profile: '/profile',

  contactUs: '/contact-us',
  aboutUs: '/about-us',
  termsOfUse: '/terms-of-use',
  privacyPolicy: '/privacy-policy',
};
