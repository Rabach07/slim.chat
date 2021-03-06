
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.response.use(
    response => {
        return response
    },
    error => {
        switch (error.response.status) {
            case 403:
                Vue.toasted.show('Unauthorised! You may not be logged in.', {
                    type: 'error',
                    icon: 'fa-exclamation-triangle'
                })
                break
            case 429:
                Vue.toasted.show('Too many requests!', {
                    type: 'error',
                    icon: 'fa-exclamation-triangle'
                })
                break
            case 422:
            case 500:
                if (error.response.data.errors != null) {
                    let messages = error.response.data.errors
                    messages = messages[Object.keys(error.response.data.errors)[0]]
                    messages.forEach(message => {
                        Vue.toasted.show(message, {
                            type: 'info',
                            icon: 'fa-exclamation-triangle'
                        })
                    })
                } else {
                    Vue.toasted.show(error.response.data.message, {
                        type: 'info',
                        icon: 'fa-exclamation-triangle'
                    })
                }
                break
        }

        return Promise.reject(error)
    }
)

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js')

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_WS_HOST,
    wsPort: process.env.MIX_PUSHER_WS_PORT,
    wssPort: process.env.MIX_PUSHER_WS_PORT,
    encrypted: process.env.MIX_PUSHER_ENCRYPTED != 'false',
    enabledTransports: ['ws', 'wss'],
    disableStats: true
})
