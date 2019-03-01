/**
 * Create widgetDiv
 */
var widgetDiv = document.createElement('div')
widgetDiv.id = 'chat-widget'
widgetDiv.innerHTML = '<chat-widget />'
document.body.appendChild(widgetDiv)

// TODO Put the whole chat window in an iFrame

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

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// })

/*
 * Vue
 */
window.Vue = require('vue')
Vue.component('chat-widget', require('./ChatWidget.vue').default)

const app = new Vue({
    el: '#chat-widget',

    mounted() {
        console.log('Chat ready.')
    }
})
