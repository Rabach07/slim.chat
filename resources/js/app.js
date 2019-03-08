require('./bootstrap')

// Vue
window.Vue = require('vue')

// Vue Router
// window.VueRouter = require('vue-router')
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import router from './routes'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/*
 * Global Vue properties
 * e.g. this.$user
 */
Vue.prototype.$user = window.slimchat.user
Vue.prototype.$business = window.slimchat.business

/*
 * Import third-party functions for global addons (filters, etc.)
 */
var startCase = require('lodash/startCase')
var camelCase = require('lodash/camelCase')

/*
 * Register filters
 */
Vue.filter('title', function (value) {
    if (! value) return ''
    return _.startCase(_.camelCase(value))
})

/*
 * Create the app!
 */
const app = new Vue({
    el: '#app',

    mounted() {
        console.log('App ready.')
    },

    router
})
