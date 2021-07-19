import React, { lazy, Suspense } from 'react'
import { Route } from 'react-router-dom'
import PropTypes from 'prop-types'

import Main from 'layouts/main'
import { Loader } from 'components'

function Public(props) {
  const { component, layout, ...rest } = props
  const Layout = layout ? lazy(() => import(`../layouts/${layout}`)) : Main
  const Component = lazy(() => import(`../${component}`))
  const renderLoader = Loader

  return (
    <Route
      {...rest}
      render={(props) => (
        <Suspense fallback={renderLoader()}>
          <Layout>
            <Component {...props} />
          </Layout>
        </Suspense>
      )}
    />
  )
}

Public.propTypes = {
  component: PropTypes.any,
  layout: PropTypes.any,
  location: PropTypes.object,
}

export default Public
