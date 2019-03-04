/**
 * Create widgetDiv
 */
var widgetDiv = document.createElement('div')
widgetDiv.id = 'chat-widget'
widgetDiv.innerHTML = '<chat-widget v-if="ready" app_id="app_id" user_id="user_id" />'
document.body.appendChild(widgetDiv)

// TODO Put the whole chat window in an iFrame

/*
 * UUID
 */
const uuidv4 = require('uuid/v4')

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
    disableStats: true,
    encrypted: false, // true
})

/*
 * Vue
 */
window.Vue = require('vue')
Vue.component('chat-widget', require('./ChatWidget.vue').default)

const app = new Vue({
    el: '#chat-widget',

    data: {
        ready: false,
        app_id: window.slimchat,
        user_id: null,
    },

    created() {
        console.log('widget.js created.')

        // app_id
        this.app_id = window.slimchat.app_id

        // user_id
        this.user_id = localStorage.getItem('slimchat.user_id')
        if (this.user_id == null) {
            localStorage.setItem('slimchat.user_id', uuidv4())
        }

        this.ready = true
    }
})
