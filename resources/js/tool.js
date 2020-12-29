import mail from './store/mail'
import metrika from './store/metrika'
import users from './store/users'

Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'handle-mail',
            path: '/handle-mail',
            component: require('./components/Mail/Index'),
        },
        {
            name: 'handle-mail-single',
            path: '/handle-mail/single/:id',
            component: require('./components/Mail/SingleMail'),
            props: true,
        },
        // {
        //     name: 'handle-mail-single-resend',
        //     path: '/handle-mail/single/resend/:id',
        //     component: require('./components/Mail/ResendSingle'),
        //     props: true,
        // },
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
        {
            name: 'handle-mail-metrika-index',
            path: '/handle-mail/metrika',
            component: require('./components/Metriks/Index'),
        },
        {
            name: 'handle-mail-metrika-pages',
            path: '/handle-mail/metrika/pages',
            component: require('./components/Metriks/PagesChart'),
        },
        {
            name: 'handle-mail-metrika-pages-visited',
            path: '/handle-mail/metrika/pages-visited',
            component: require('./components/Metriks/PagesVisited'),
        },
        {
            name: 'handle-mail-metrika-spam',
            path: '/handle-mail/metrika/spam',
            component: require('./components/Metriks/Spam'),
        },
        {
            name: 'handle-mail-metrika-map',
            path: '/handle-mail/metrika/map',
            component: require('./components/Metriks/Map'),
        },
        {
            name: 'handle-mail-metrika-users',
            path: '/handle-mail/metrika/users',
            component: require('./components/Metriks/Users/Index'),
        },
        {
            name: 'handle-mail-metrika-users-single',
            path: '/handle-mail/metrika/users/single/:ip',
            component: require('./components/Metriks/Users/Single'),
            props: true,
        },
    ])
    store.registerModule('/handle-mail', mail);
    store.registerModule('/metrika', metrika);
    store.registerModule('/metrika/users/single', users);
})
