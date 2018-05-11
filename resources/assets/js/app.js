// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.


import Vue from 'vue'
import VueAxios from 'vue-axios'
import axios from 'axios'
import {loadProgressBar} from 'axios-progress-bar'
import Notifications from 'vue-notification'
Vue.use(Notifications)
import 'axios-progress-bar/dist/nprogress.css'
import App from './App.vue'
import router from './router'
import Vuetify from 'vuetify'
import VueTimeago from 'vue-timeago'
import formatCurrency from 'format-currency'

const DEBUG = false


const GOOGLE_MAPS_KEY = 'AIzaSyAS_9BsQpqTP8EVuMZ7rQ9gMCl0wmqhm7k'
const PRIMARY_COLOR = '#1A75BA'
const ACCENT_COLOR = '#FFC908'


Vue.router = router


Vue.use(VueAxios, axios)
//Vue.axios.defaults.baseURL = DEBUG ? 'http://localhost:3000/api/v1' : 'https://cube-messenger.com/api/v1'
Vue.axios.defaults.baseURL = DEBUG ? 'http://localhost:3000/api/v1' : 'http://35.192.81.247/api/v1'
Vue.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
Vue.axios.defaults.headers.common['Accept'] = 'application/json'
Vue.axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'

// Add a request interceptor
Vue.axios.interceptors.request.use(function (config) {
  // Do something before request is sent
  //console.info(`REQUEST INTERCEPTOR - CONFIG \n ${JSON.stringify(config)}`)
  return config
}, function (error) {
  // Do something with request error
  //console.error(`REQUEST INTERCEPTOR - ERROR \n ${JSON.stringify(error)}`)
  return Promise.reject(error)
})

// Add a response interceptor
Vue.axios.interceptors.response.use(function (response) {
  // Do something with response data
  // let token = this.axios._getHeaders.call(this, response).Authorization
  // console.info(`RESPONSE INTERCEPTOR - TOKEN \n ${token}`)
  // console.info(`RESPONSE INTERCEPTOR - RESPONSE \n ${JSON.stringify(response.data)}`)
  return response
}, function (error) {
  // Do something with response error
  // alert(error)
  console.error(`RESPONSE INTERCEPTOR - ERROR \n`)
  if (error.response) {
    console.info(error.response.status)
    console.info(error.response.data)
    console.info(error.response.headers)
  } else if (error.request) {
    console.info(`REQUEST: ${JSON.stringify(error.request)}`)
  } else {
    console.info(`MESSAGE: ${JSON.stringify(error.message)}`)
  }
  return Promise.reject(error)
})

Vue.use(require('@websanova/vue-auth'), {
  auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
  fetchData: {url: 'auth/user', method: 'GET', enabled: true},
  registerData: {url: 'auth/signUp', method: 'POST', redirect: {name: 'dashboard'}},
  loginData: {url: 'auth/signIn', method: 'POST', redirect: {name: 'dashboard'}, fetchUser: true},
  logoutData: {url: 'auth/signOut', method: 'POST', redirect: {name: 'signIn'}, makeRequest: true},
  refreshData: {url: 'auth/refresh', method: 'GET', enabled: false, interval: 0},
  authRedirect: {path: 'auth/signIn'}
})

require('vuetify/dist/vuetify.min.css')
Vue.use(Vuetify, {
  theme: {
    primary: PRIMARY_COLOR,
    secondary: '#424242',
    accent: ACCENT_COLOR,
    error: '#FF5252',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FFC107'
  }
})

Vue.use(VueTimeago, {
  name: 'timeago', // component name, `timeago` by default
  locale: 'en-US',
  locales: {
    // you will need json-loader in webpack 1
    'en-US': require('vue-timeago/locales/en-US.json')
  }
})

Vue.config.productionTip = true

Vue.prototype.$appName = 'Cube Messenger'

Vue.prototype.$actions = {
  addedDelivery: 'addedDelivery',
  addedSubscription: 'addedSubscription',
  collapsedDrawer: 'collapsedDrawer',
  clickedToolbarSideIcon: 'clickedToolbarSideIcon',
  placedOrder: 'placedOrder',
  requestedService: 'requestedService',
  addedAppointment: 'addedAppointment',
  approved: 'approved',
  rejected: 'rejected',
  signedIn: 'rejected'
}

Vue.prototype.$utils = {
  //url: DEBUG ? 'http://localhost:3000' : 'https://cube-messenger.com',
  url: DEBUG ? 'http://localhost:3000' : 'http://35.192.81.247',
  googleMapsKey: GOOGLE_MAPS_KEY,
  googleGeocodeUrl: 'https://maps.googleapis.com/maps/api/geocode/json',
  googleDirectionsUrl: 'https://maps.googleapis.com/maps/api/directions/json',
  log: function (logData) {
    if (DEBUG) {
      console.info(logData)
    }
  },
  imageUrl (relativePath) {
    return '/storage/' + relativePath
  },
  dummyImage () {
    return `https://unsplash.it/150/300?image=${Math.floor(Math.random() * 100) + 1}`
  },
  formatMoney: function (val) {
    let opts = {format: '%s%v', symbol: 'KES '}
    return formatCurrency(Math.ceil(val), opts)
  },
  
  primaryColor: PRIMARY_COLOR,
  accentColor: ACCENT_COLOR
}

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  http: {
    emulateJSON: true,
    emulateHTTP: true
  },
  template: '<App></App>',
  components: {App},
  data () {
    return {
      test: 'This is a test in the app'
    }
  },
  mounted () {
    loadProgressBar()
  }
})
