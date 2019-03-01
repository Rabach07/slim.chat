import VueRouter from 'vue-router'

let routes = [
    {
        path: '/app',
        name: 'app',
        component: require('./views/App').default
    },
    {
        path: '/app/profile',
        name: 'profile',
        component: require('./views/Profile').default
    },
    {
        path: '/app/settings',
        name: 'settings',
        component: require('./views/Settings').default
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
