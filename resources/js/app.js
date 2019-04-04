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
Vue.component('ago', require('./components/Ago').default)
Vue.component('transition-expand', require('./components/TransitionExpand').default)

/*
 * Global static Vue properties
 * e.g. this.$user
 */
Vue.prototype.$sound = {
    announce: new Audio('/sounds/announce.m4a'),
    message: new Audio('/sounds/message.m4a')
}

// Event bus
Vue.prototype.$bus = new Vue({})

/*
 * Import third-party functions for global addons (filters, etc.)
 */
 // Lodash & date-fns
var Favico = require('favico.js')
Vue.prototype.$favico = new Favico({ position: 'up', animation: 'none' })
var startCase = require('lodash/startCase')
var camelCase = require('lodash/camelCase')
var distanceInWordsStrict = require('date-fns/distance_in_words_strict')

// Toasted
import Toasted from 'vue-toasted'
Vue.use(Toasted, {
    position: 'top-right',
    duration: 3000,
    iconPack: 'fontawesome',
    className: 'toast'
})
Vue.toasted.register('saved', 'Saved successfully!', {
    type: 'success',
    icon: 'fa-check-circle'
})
// this.$toasted.global.saved()

/*
 * Register filters
 */
Vue.filter('nl2br', function (value) {
    if (!value) return ''
    return value.replace(/(?:\r\n|\r|\n)/g, '<br>')
})
Vue.filter('title', function (value) {
    if (! value) return ''
    return _.startCase(_.camelCase(value))
})
Vue.filter('ago', function (value) {
    if (!value) return ''
    value = distanceInWordsStrict(new Date(value), new Date).split(' ')
    if (value[1][0] == 's') {
        return 'just now'
    }
    return value[0] + value[1][0]
})

/*
 * Create the app!
 */
var app = new Vue({
    el: '#app',

    data: {
        user: window.slimchat.user,
        business: window.slimchat.business,
        conversations: []
    },

    watch: {
        conversations(newConversations) {
            this.$favico.badge(newConversations.length)
        }
    },

    methods: {
        fetchUser() {
            //
        },
        fetchBusiness() {
            axios.get('/api/businesses/' + this.business.id)
            .then(response => {
                this.business = response.data.data
            })
        },
        fetchConversations() {
            axios.get('/api/conversations?filter[status]=1', {
                params: {
                    business_id: this.business.id
                }
            })
            .then(response => {
                this.conversations = response.data.data
            })
        }
    },

    created() {
        this.fetchConversations()

        Echo.channel('businesses.' + this.business.id + '.conversations')
        .listen('ConversationUpdated', event => {
            this.fetchConversations()
        })

        Echo.channel('businesses.' + this.business.id)
        .listen('BusinessUpdated', event => {
            this.business = event.business
        })
    },

    mounted() {
        console.log('App ready.')
    },

    beforeDestroyed() {
        Echo.leave('businesses.' + this.business.id)
        Echo.leave('businesses.' + this.business.id + '.conversations')
    },

    router
})
