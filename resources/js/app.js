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
var keyBy = require('lodash/keyBy')
var mapValues = require('lodash/mapValues')
var distanceInWordsStrict = require('date-fns/distance_in_words_strict')

// Toasted
import Toasted from 'vue-toasted'
Vue.use(Toasted, {
    position: 'top-right',
    duration: 3000,
    iconPack: 'fontawesome',
    className: 'toast'
})
// Use: this.$toasted.global.saved()
Vue.toasted.register('saved', 'Saved successfully!', {
    type: 'success',
    icon: 'fa-check-circle'
})

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
        ready: false,
        business_id: window.slimchat.business_id,
        user: window.slimchat.user,
        business: {},
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
            axios.get('/api/businesses/' + this.business_id)
            .then(response => {
                this.business = response.data.data
                this.business.settings = _.mapValues(_.keyBy(this.business.settings, 'name'), 'value')
                this.business.property_definitions = _.mapValues(_.keyBy(this.business.property_definitions, 'name'), 'type')
                this.ready = true
            })
        },
        fetchConversations() {
            axios.get('/api/conversations?filter[status]=1', {
                params: {
                    business_id: this.business_id
                }
            })
            .then(response => {
                this.conversations = response.data.data
            })
        }
    },

    created() {
        this.fetchBusiness()
        this.fetchConversations()

        Echo.channel('businesses.' + this.business_id + '.conversations')
        .listen('ConversationUpdated', event => {
            this.fetchConversations()
        })

        Echo.channel('businesses.' + this.business_id)
        .listen('BusinessUpdated', event => {
            this.business = event.business
        })
    },

    mounted() {
        console.log('App ready.')
    },

    beforeDestroyed() {
        Echo.leave('businesses.' + this.business_id)
        Echo.leave('businesses.' + this.business_id + '.conversations')
    },

    router
})
