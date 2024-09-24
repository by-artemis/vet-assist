const customer = [
  {
    path: '/pets',
    component: 'pages/authenticated/Pet/Index',
    auth: true,
  },
  {
    path: '/pets/create',
    component: 'pages/authenticated/Pet/Create',
    auth: true,
  },
  {
    path: '/pets/edit',
    component: 'pages/authenticated/Pet/Edit',
    auth: true,
  },
];

export default customer;
