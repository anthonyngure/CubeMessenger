import Vue from 'vue'
import Vuex from 'vuex'
import Cart from './modules/cart'
import Categories from './modules/categories'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    Cart,
    Categories,
  },
})