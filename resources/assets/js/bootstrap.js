/**
 * Created by lenovo on 2017/4/2.
 */
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// window.$ = window.jQuery = require('jquery');

// require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest'
};

window.$url = require('./url.js');
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

/**
 *  bind axios and lodash to Vue
 */
axios.interceptors.response.use(response => {
    return Promise.resolve(response)
}, errors => {
  return Promise.reject(errors.response)
})

Object.defineProperty(Vue.prototype, '$http', {
  value: window.axios,
  writable: false
})

Object.defineProperty(Vue.prototype, '_', {
  value: window._,
  writable: false
})

Object.defineProperty(Vue.prototype, '$url', {
  value: window.$url,
  writable: false
})

