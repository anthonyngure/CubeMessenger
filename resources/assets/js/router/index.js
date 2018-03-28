import Courier from '../components/Courier.vue'
import ComingSoon from '../components/ComingSoon.vue'
import Appointments from '../components/Appointments.vue'
import Subscriptions from '../components/Subscriptions.vue'
import SignIn from '../components/SignIn.vue'
import Dashboard from '../components/Dashboard.vue'
import Shopping from '../components/Shopping.vue'
import ItServices from '../components/ItServices'
import RepairServices from '../components/RepairServices'
import Orders from '../components/Orders'
import Users from '../components/Users'
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  hashbang: true,
  linkActiveClass: 'active',
  mode: 'hash',
  routes: [
    {
      path: '/',
      redirect: '/dashboard'
    },
    {
      meta: {auth: false},
      path: '/auth/signIn',
      name: 'signIn',
      component: SignIn
    },
    {
      meta: {auth: true},
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard
    },
    {
      meta: {auth: true},
      path: '/courier',
      name: 'courier',
      component: Courier
    },
    {
      meta: {auth: true},
      path: '/shopping',
      name: 'shopping',
      component: Shopping
    }, {
      meta: {auth: true},
      path: '/orders',
      name: 'orders',
      component: Orders
    },
    {
      meta: {auth: true},
      path: '/appointments',
      name: 'appointments',
      component: Appointments
    },
    {
      meta: {auth: true},
      path: '/subscriptions',
      name: 'subscriptions',
      component: Subscriptions
    },
    {
      meta: {auth: true},
      path: '/users',
      name: 'users',
      component: Users
    },
    {
      meta: {auth: true},
      path: '/settings',
      name: 'settings',
      component: ComingSoon
    }, {
      meta: {auth: true},
      path: '/repairs',
      name: 'repairs',
      component: RepairServices
    },
    {
      meta: {auth: true},
      path: '/it',
      name: 'it',
      component: ItServices
    }
  ]
})
