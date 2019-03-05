import VueRouter from 'vue-router'

let routes = [
    {
        path: '/app',
        name: 'app',
        component: require('./views/App').default
    },
    {
        path: '/app/people',
        name: 'people',
        component: require('./views/People').default
    },
    {
        path: '/app/profile',
        name: 'profile',
        component: require('./views/Profile').default
    },
    {
        path: '/app/settings',
        component: require('./views/Settings').default,
        children: [
            {
                path: 'appearance',
                name: 'settings',
                component: require('./views/settings/Appearance').default
            },
            {
                path: 'behaviour',
                name: 'settings.behaviour',
                component: require('./views/settings/Behaviour').default
            },
            {
                path: 'account',
                name: 'settings.account',
                component: require('./views/settings/Account').default
            },
            {
                path: 'team',
                name: 'settings.team',
                component: require('./views/settings/Team').default
            },
            {
                path: 'billing',
                name: 'settings.billing',
                component: require('./views/settings/Billing').default
            },
        ]
    },
    // {
    //     path: '*',
    //     name: '404',
    //     component: require('./views/404').default,
    // },
]

export default new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active',
})
