import { Suspense, lazy } from 'react';
import { Route, Routes } from 'react-router-dom';
import Loader from 'components/atoms/Loader';
import routes from './routes';

function Router() {
  const AuthenticatedLayout = lazy(() => import('templates/Authenticated'));
  const GuestLayout = lazy(() => import('templates/Guest'));
  const Logout = lazy(() => import('pages/guest/Logout'));

  return (
    <Suspense fallback={<Loader />}>
      <Routes>
        {routes.map((route, i) => {
          const Page = lazy(() => import(`../${route.component}`));
          const layout = route.auth ? (
            <AuthenticatedLayout />
          ) : (
            <GuestLayout navbar={route.navbar} />
          );

          return (
            <Route key={i} element={layout}>
              <Route exact path={route.path} element={<Page />} />
            </Route>
          );
        })}

        <Route exact path="/logout" element={<Logout />} />
      </Routes>
    </Suspense>
  );
}

export default Router;
