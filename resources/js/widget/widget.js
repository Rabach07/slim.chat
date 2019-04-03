/**
 * Grab settings
 */
window.slimchat = window.top.slimchat

/*
 * Axios
 */
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

/*
 * Laravel Echo
 */
import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_WS_HOST,
    wsPort: process.env.MIX_PUSHER_WS_PORT,
    encrypted: process.env.MIX_PUSHER_ENCRYPTED,
    enabledTransports: ['ws', 'wss'],
    disableStats: true
})

/*
 * Third-party
 */
var distanceInWordsStrict = require('date-fns/distance_in_words_strict')

/*
 * Vue
 */
window.Vue = require('vue')

// Global variables
Vue.prototype.$sounds = {
    announce: new Audio('/sounds/announce.m4a'),
    message: new Audio('/sounds/message.m4a')
}

/*
 * Register filters
 */
Vue.filter('nl2br', function (value) {
    if (!value) return ''
    return value.replace(/(?:\r\n|\r|\n)/g, '<br>')
})
Vue.filter('ago', function (value) {
    if (!value) return ''
    value = distanceInWordsStrict(new Date(value), new Date).split(' ')
    return value[0] + value[1][0]
})

// Components
Vue.component('chat-widget', require('./ChatWidget.vue').default)

// Vue!
const app = new Vue({
    el: '#app',

    data: {
        ready: false,
        app_id: null,
        visitor_uuid: null,
    },

    created() {
        console.log('widget.js created.')

        // app_id
        this.app_id = window.slimchat.app_id

        // visitor_uuid
        this.visitor_uuid = localStorage.getItem('slimchat.visitor_uuid')
        axios.get('/api/announce/' + this.visitor_uuid)
        .then(response => {
            this.visitor_uuid = response.data.data.uuid
            localStorage.setItem('slimchat.visitor_uuid', this.visitor_uuid)
            console.log('Visitor: ', this.visitor_uuid)

            this.ready = true
        })
    }
})
