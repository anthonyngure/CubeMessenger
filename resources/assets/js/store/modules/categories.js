import api from '../../api'

// initial state
const state = {
  all: []
}

// getters
const getters = {
  allCategories: state => state.all
}

// actions
const actions = {
  getAllCategories ({commit}) {
    if (!state.all.length) {
      api.get('categories', categories => {
        commit('setCategories', categories)
      })
    }
  }
}

// mutations
const mutations = {
  setCategories (state, categories) {
    state.all = categories
  },
  
  incrementProductQuantityInCart (state, payLoad) {
    //console.info('incrementProductQuantityInCart')
    //console.info(payLoad.product)
    //console.info(payLoad.quantity)
    const category = state.all.find(category => category.id === payLoad.product.categoryId)
    const product = category.products.find(product => product.id === payLoad.product.id)
    if (!product.quantityInCart) {
      product.quantityInCart = payLoad.quantity
    } else {
      product.quantityInCart += payLoad.quantity
    }
  },
  
  clearProductQuantityInCart (state, payLoad) {
    //console.info('clearProductQuantityInCart')
    const categoriesCopy = state.all
    const category = categoriesCopy.find(category => category.id === payLoad.product.categoryId)
    const product = category.products.find(product => product.id === payLoad.product.id)
    product.quantityInCart = 0
    state.all = []
    state.all = state.all.concat(categoriesCopy)
  },
  clearAllProductsQuantityInCart (state) {
    const categoriesCopy = state.all
    categoriesCopy.forEach(category => {
      category.products.forEach(product => {
        product.quantityInCart = 0
      })
    })
    state.all = []
    state.all = state.all.concat(categoriesCopy)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}