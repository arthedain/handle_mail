Nova.booting((Vue, router, store) => {

  router.addRoutes([
    {
      name: 'handle-mail',
      path: '/handle-mail',
      component: require('./components/Tool'),
    },
    {
        name: 'handle-mail-single',
        path: '/handle-mail/single/:id',
        component: require('./components/SingleMail'),
        props: true,
    },
    {
        name: 'handle-mail-failed',
        path: '/handle-mail/failed',
        component: require('./components/Failed/List'),
    },
    {
        name: 'handle-mail-failed-single',
        path: '/handle-mail/failed/single/:id',
        component: require('./components/Failed/Single'),
        props: true,
    },
  ])
})
