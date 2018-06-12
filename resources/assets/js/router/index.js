import Courier from '../components/Courier.vue'
import Appointments from '../components/Appointments.vue'
import Subscriptions from '../components/Subscriptions.vue'
import SignIn from '../components/SignIn.vue'
import Dashboard from '../components/Dashboard.vue'
import Shopping from '../components/Shopping.vue'
import ItServices from '../components/ItServices'
import RepairServices from '../components/RepairServices'
import Orders from '../components/Orders'
import Users from '../components/Users'
import Profile from '../components/Profile'
import Departments from '../components/Departments'
import Clients from '../components/Clients'
import Roles from '../components/Roles'
import TopUps from '../components/TopUps'
import Categories from '../components/Categories'
import Products from '../components/Products'
import Deliveries from '../components/Deliveries'
import OrderedItems from '../components/OrderedItems'
import SupplierOrderedItems from '../components/SupplierOrderedItems'
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
      path: '/clients',
      name: 'clients',
      component: Clients
    },
    {
      meta: {auth: true},
      path: '/deliveries',
      name: 'deliveries',
      component: Deliveries
    },
    {
      meta: {auth: true},
      path: '/roles',
      name: 'roles',
      component: Roles
    },
    {
      meta: {auth: true},
      path: '/lpos',
      name: 'lpos',
      component: SupplierOrderedItems
    },
    {
      meta: {auth: true},
      path: '/topUps',
      name: 'topUps',
      component: TopUps
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
      path: '/products',
      name: 'products',
      component: Products
    },
    {
      meta: {auth: true},
      path: '/categories',
      name: 'categories',
      component: Categories
    },
    {
      meta: {auth: true},
      path: '/orderItems',
      name: 'orderItems',
      component: OrderedItems
    },
    {
      meta: {auth: true},
      path: '/departments',
      name: 'departments',
      component: Departments
    },
    {
      meta: {auth: true},
      path: '/profile',
      name: 'profile',
      component: Profile
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
