/**
 * Created by lenovo on 2017/4/2.
 */
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import VueMaterial from 'vue-material'
import VueSocketio from 'vue-socket.io'
import 'vue-material/dist/vue-material.css'
import Vuerify from 'vuerify'
import VueRouter from 'vue-router'
import App from './App'

Vue.use(VueMaterial)
Vue.use(Vuerify)
Vue.use(VueRouter)
Vue.use(VueSocketio, $url.base_socket_url)

const router = new VueRouter({
  mode: 'history',
  base: __dirname,
  scrollBehavior: () => ({ y: 0 }),
  routes: [
      {
          path: '/apply',
          name: 'apply',
          component: require('./components/SignForm.vue')
      },
      {
        path: '/sign',
        name: 'sign',
        component: require('./components/SignSystemForm.vue')
      },
      {
        path: '/interview/login',
        name: 'interview.login',
        component: require('./components/InterviewLoginForm.vue')
      },
      {
          path: '/interview',
          name: 'interview',
          redirect: { name: 'interview.login' }
      },
      {
          path: '/interview/home',
          name: 'interview.home',
          component: require('./components/InterviewHome.vue')
      }
  ]
})

new Vue({
  el: '#app',
  router,
  render: h => h(App)
})