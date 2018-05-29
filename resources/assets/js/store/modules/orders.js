import api from '../../api'

// initial state
const state = {
  all: [],
}

// getters
const getters = {
  allOrders: state => state.all
}

// actions
const actions = {
  getAllOrders ({commit}) {
    if (!state.all.length) {
      api.get('orders', orders => {
        commit('setOrders', orders)
      })
    }
  }
}

// mutations
const mutations = {
  setOrders (state, payLoad) {
    state.all = payLoad
  },
  addCreatedOrder(state, payLoad){
    state.all.push(payLoad)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}