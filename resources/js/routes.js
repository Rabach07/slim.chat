import VueRouter from 'vue-router'

let routes = [
    {
        path: '/app',
        name: 'app',
        component: require('./views/App').default,
        children: [
            {
                path: '/app',
                redirect: '/app/chat'
            },
            {
                path: '/app/chat',
                name: 'chat',
                component: require('./views/Chat').default
            },
            {
                path: '/app/people',
                name: 'people',
                component: require('./views/People').default
            },
            {
                path: '/app/automate',
                name: 'automate',
                component: require('./views/Automate').default,
                children: [
                    {
                        path: '/app/automate/:automationId',
                        name: 'automate.show',
                        component: require('./components/AutomationDetail').default,
                        props: true
                    },
                    {
                        path: '/app/automate/new',
                        name: 'automate.new',
                        component: require('./views/AutoNew').default
                    }
                ]
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
                        path: 'properties',
                        name: 'settings',
                        component: require('./views/settings/Properties').default
                    },
                    {
                        path: 'import',
                        name: 'settings.data.import',
                        component: require('./views/settings/Import').default
                    },
                    {
                        path: 'general',
                        name: 'settings.widget.general',
                        component: require('./views/settings/widget/General').default
                    },
                    {
                        path: 'appearance',
                        name: 'settings.widget.appearance',
                        component: require('./views/settings/widget/Appearance').default
                    },
                    {
                        path: 'behavior',
                        name: 'settings.widget.behavior',
                        component: require('./views/settings/widget/Behavior').default
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
        ]
    }
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
